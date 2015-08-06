<?php
/**
 * Database class
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 * 
 * For questions, help, comments, etc., please contact <n0nick@php.net>.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 */

/**
 * Database class
 *
 * The class handles all of the system's connection to the mySQL connection.
 * All queries and data are being processed through this class, so that
 * porting this to a different brand of SQL database should be a piece of pie.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 */
class Database {

   /**
    * Host name
    *
    * The database server's hostname.
    * Leave blank to use PHP's default.
    *
    * @var string
    * @see connect
    */
   var $host;
   /**
    * Username
    *
    * mySQL username to access the database with.
    * This user must have privaliges to the table designated to the system.
    *
    * @var string
    * @see connect
    * @see $password
    */
   var $username;
   /**
    * Password
    *
    * The correct password for the user.
    *
    * @var string
    * @see connect
    * @see $username
    */
   var $password;
   /**
    * Database name
    *
    * The name of the database to connecto to.
    *
    * @var string
    * @see connect
    */
   var $dbname;
   /**
    * Database prefix
    *
    * Table name prefix for all tables used by the script.
    *
    * @var string
    * @see query
    */
   var $prefix;
   
   /**
    * Database link
    *
    * The mySQL link resource for queries and data fetches.
    *
    * @var resource
    * @see connect
    * @access private
    */
   var $link = 0;
   /**
    * Last result
    *
    * The resource containing the result from last database query.
    *
    * @var resource
    * @see query
    * @access private
    */
   var $last_result = 0;

   /**
    * Database constructor
    *
    * Constructs the database instance and stores the connection variables.
    *
    * @param string $host Host name
    * @param string $user Username
    * @param string $pass Password
    * @param string $name Database name 
    * @return void
    */
   function Database($host, $user, $pass, $name, $prefix) {

      $this->host     = $host;
      $this->username = $user;
      $this->password = $pass;
      $this->dbname   = $name;
      $this->prefix   = $prefix;

   } // Database()


   /**
    * Connects to database
    *
    * Makes the connection to the mySQL database.
    *
    * @return success flag
    * @link   http://php.net/manual/en/function.mysql-connect.php
    * @todo   remove stupid utf8 workaround and see how it's done in mysql 4.1
    */
   function connect() {

      @$this->link = mysql_connect ($this->host,
                                   $this->username,
                                   $this->password);
      if (mysql_errno()) {
         return mysql_error();
      } else {
         mysql_select_db ($this->dbname, $this->link);
         // WARNING WARNING
         // stupidest utf8 workaround ahead
         // PLEASE.WALK.CAREFULY
         mysql_query("SET NAMES 'utf8'");
         // hazlash
         return TRUE;
      }

   } // connect()


   /**
    * Sends a mySQL query
    *
    * Sends the query to the database and returns the result.
    *
    * @param string $sql SQL query
    * @return resource Query result
    * @link   http://www.php.net/manual/en/function.mysql-query.php
    */
   function query($sql) {
      $sql = str_replace('`+', '`'.$this->prefix, $sql);

      $this->last_result = mysql_query($sql, $this->link);
      return $this->last_result;

   } // query()


   /**
    * Fetches results array
    *
    * Fetches an associative array with values from the given query result.
    *
    * @param resource $result Query result resource
    * @return array Array of results
    * @link   http://www.php.net/manual/en/function.mysql-fetch-assoc.php
    */
   function fetch_assoc($result=0) {

      if ($result == 0) { $result = $this->last_result; }
      return mysql_fetch_assoc($result);

   } // fetch_array()


   /**
    * Fetches results numeric array
    *
    * Fetches a numeric array with values from the given query result.
    *
    * @param resource $result Query result resource
    * @return array Array of results
    * @link   http://www.php.net/manual/en/function.mysql-fetch-row.php
    */
   function fetch_row($result=0) {

      if ($result == 0) { $result = $this->last_result; }
      return mysql_fetch_row($result);

   } // fetch_row()


   /**
    * Last ID
    *
    * Returns the last id created by an INSERT command.
    *
    * @return int Last id number
    * @link   http://www.php.net/manual/en/function.mysql-insert-id.php
    */
   function insert_id() {

      return mysql_insert_id($this->link);

   }


   /**
    * Result rows count
    *
    * Returns result rows count for a query
    *
    * @param resource $result Query result resource
    * @return int Result rows count
    * @link   http://www.php.net/manual/en/function.mysql-num-rows.php
    */
   function num_rows($result=0) {

      if ($result == 0) { $result = $this->last_result; }
      return mysql_num_rows($result);

   } // num_rows()


   /**
    * Affected rows count
    *
    * Returns the number of rows affected by last query.
    *
    * @return int Affected rows count
    * @link   http://www.php.net/manual/en/function.mysql-affected-rows.php
    */
   function affected_rows() {

      return mysql_affected_rows($this->link);

   } // affected_rows()


   /**
    * Last error
    *
    * Returns the description of the mySQL error from previous operation,
    * if occured.
    *
    * @return string mySQL error message
    * @link   http://www.php.net/manual/en/function.mysql-error.php
    */
   function error() {

      return mysql_error($this->link);

   } // error()


   /**
    * Database deconstructors
    *
    * Closes the database connection.
    *
    * @return boolean Returns state of success.
    * @link   http://www.php.net/manual/en/function.mysql-close.php
    */
   function _Database() {

      return mysql_close($this->link);

   } // _Database()

} // Database

/* Simba says Roar! */ ?>