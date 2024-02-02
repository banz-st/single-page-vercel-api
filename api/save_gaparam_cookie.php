<?php
  // PHP code goes here
  header('Content-Type: application/json');

  // 空チェック
  function IsNullOrEmptyString($str){
    return ($str === null || trim($str) === '');
  }

  // POSTの時の処理
  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $cookie_set_flag = false;
    $ga_cookie_name = ['utm_source','utm_medium','utm_campaign','gclid','yclid'];
    // Cookie期限：30日
    $expire = 30*24*3600;

    if(!IsNullOrEmptyString($_POST['ga_params_url'])) {
      // UTMパラメーターあれば配列に変更
      $url_params = explode("&", $_POST['ga_params_url']);

      foreach ($url_params as $param) {
        $cookie = explode("=", $param);
        $cookie_name = $cookie[0];
        $cookie_value = $cookie[1];
        // 必要なパラメータだけをCookieとして保存
        if(in_array($cookie_name, $ga_cookie_name)){
          $cookie_set_flag = true;
          setcookie( $cookie_name, $cookie_value, time()+$expire, '/');
        }
      }
    }
    // リファラルURL保存（UTMパラメータある時のみ）
    if(!IsNullOrEmptyString($_POST['ref_url'])) {
      if($cookie_set_flag){
        setcookie( "cf_ref_url", $cookie_value, time()+$expire, '/');
      }
    }

  }
?>