<?php
try{
  require_once('../common/common.php');

  $post=sanitize($_POST);
  $staff_code=$post['code'];
  $staff_pass=$post['pass'];

  // $staff_code=htmlspecialchars($staff_code,ENT_QUOTES,'UTF-8');
  // $staff_pass=htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

  $staff_pass=md5($staff_pass);

  // ローカル環境接続ーーーーーーーーーーーーーーー
  $dbn = 'mysql:host=localhost; dbname=booksample; charset=utf8';
  $user = 'root';
  $pass = '';
  // ーーーーーーーーーーーーーーーーーーーーーーーー
  $dbh = new PDO($dbn, $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql='SELECT name FROM mst_staff where code=? AND password=?';
  $stmt=$dbh->prepare($sql);
  $data[]=$staff_code;
  $data[]=$staff_pass;
  $stmt->execute($data);

  $dbh=null;

  $rec=$stmt->fetch(PDO::FETCH_ASSOC);

  if($rec==false)
  {
    print 'スタッフコードかパスワードが間違っています。<br />';
    print '<a href="staff_login.html">戻る</a>';
  }
  else
  {
    session_start();
    $_SESSION['login']=1;
    $_SESSION['staff_code']=$staff_code;
    $_SESSION['staff_name']=$rec['name'];
    header('Location:staff_top.php');
    exit();
  }
}
catch(Exception $e){
  print 'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}
?>