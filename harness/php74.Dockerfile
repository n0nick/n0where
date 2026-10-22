FROM php:7.4-fpm
RUN docker-php-ext-install mysqli
COPY harness.ini /usr/local/etc/php/conf.d/zz-harness.ini
# Create the Smarty dirs IN THE IMAGE so the per-version named volumes
# inherit www-data ownership; an empty named volume would be root-owned
# and php-fpm could not write compiled templates into it.
RUN mkdir -p /var/www/html/n0/templates_c /var/www/html/n0/cache \
 && chown -R www-data:www-data /var/www/html/n0
RUN printf '<?php echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;' > /usr/local/etc/probe.php
