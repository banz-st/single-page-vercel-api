let url = window.location.search.substring(1);
var cookieSetFlag = false;

var params = new URLSearchParams();
params.append('ga_params_url', url);
params.append('ref_url', window.document.referrer);

// SafariだとJSでCookie保存したらITPで引っかかって期限は1日になってしまうので
// phpでCookie保存処理書いてあります
axios.post("/api/save_gaparam_cookie", params)
  .then(response => {
    console.log('response:', response);
  })
  .catch(error => {
      console.log('Error:', error);
  });

// CSRF用トークンをcookieに保存
setCookie(`ma_token=${token()}`, 30)


function setCookie(cookie, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cookie + ";" + expires + ";path=/";
}

// ランダムトークン作成
function rand() {
  return Math.random().toString(36).substring(2);
};

function token() {
  // トークンを長くするため2回呼ぶ
  return rand() + rand();
};