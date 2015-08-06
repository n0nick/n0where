function closeDestroyer() {
  if (div = document.getElementById('explorerdestroyer')) {
    div.style.display = "none";
  }
  var today = new Date();
  var expire = new Date();
  expire.setTime(today.getTime() + 259200000);
  setCookie('destroyer','hide',expire)
}

function loadPage() {
  var destroyer = getCookie('destroyer');
  if (destroyer == 'hide') {
    if (div = document.getElementById('explorerdestroyer')) {
      div.style.display = "none";
    }
  }
}

function addComment(parent) {
  if (div = document.getElementById('postform')) {
    if (div.style.display == "block") {
      div.style.display = "none";
    } else {
      div.style.display = "block";
      if (cmt = document.getElementById('gocode')) {
        cmt.focus();
      }
    }
  }
  if (prt = document.getElementById('parentid')) {
    prt.value = parent;
  }
}

function sizer(size) {
  document.body.style.fontSize = size;
  var today = new Date();
  var expire = new Date();
  expire.setTime(today.getTime() + 259200000);
  setCookie('sizer',size,expire);
}

function focuser(inputz) {
  inputz.style.backgroundColor = "lightyellow";
}
function blurer(inputz) {
  inputz.style.backgroundColor = "#efefef";
}

function comments(c) {
   window.open(c, 'n0comments', 'toolbar=yes, directories=no,'
              +'status=no, resizable=yes, scrollbars=yes, location=no'
              +', dependent, width=400, height=350');
}
function commentsp(c) {
   if (window.event && window.event.keyCode == 13) {
      return comments(c);
   }
}

function emoticon(code) {
   x = document.postform.comment;
   x.value = x.value + code;
   document.postform.comment.focus();
}
function emoticonp(code) {
   if (window.event && window.event.keyCode == 13) {
      return emoticon(code);
   }
}
function closep() {
   if (window.event && window.event.keyCode == 13) {
      return window.close();
   }
}

window.name='n0main';
