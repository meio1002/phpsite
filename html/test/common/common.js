/*
*  パスワード強度チェック
*  see
*     https://www.websec-room.com/passswordchecker
*/
function setPasswordLevel(password) {
  var level = getPasswordLevel(password);
  var text = "";

  if (level == 1) { text = "弱い";}
  if (level == 2) { text = "やや弱い";}
  if (level == 3) { text = "普通";}
  if (level == 4) { text = "やや強い";}
  if (level == 5) { text = "強い";}

  document.getElementById("pass_message").innerHTML = text;
}

function setConfirmMessage(confirm_password) {
    const password = document.getElementById("password").value;
    var message = "";
    if (password == confirm_password) {
        message = "";
    } else {
        message =  "パスワードが一致しません";
    }
    
    document.getElementById("pass_confirm_message").innerHTML = message;
  }