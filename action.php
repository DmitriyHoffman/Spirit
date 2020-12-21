<?php
  session_start();
$sid = $_SESSION['hash'];
require("inc/site_config.php");
require("inc/config.php");
require("inc/bd.php");
$pass = $_POST['pass'];
$login = $_POST['login'];
$type = $_POST['type'];
$email = $_POST['email'];
$error = 0;
$fa = "";
if($type == "battledice") {
  $sql_select = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$balance = $row['balance'];
}

  $rand = rand(1, 999);
  $team = $_POST['team'];
  $per = $_POST['per'];
  $sum = $_POST['sum'];
  $win = round((100 / $per) * $sum, 2);


  if($team != 'red' && $team != 'blue' || $team == '') {
   $error = 1;
   $mess = "Выберите цвет";
   $fa = "fatal";
  }

  if($sum > $balance) {
   $error = 2;
   $mess = "Недостаточно средств";
   $fa = "fatal";
  }
  if(!is_numeric($sum)) {
   $error = 3;
   $mess = "Ошибка!";
   $fa = "fatal";
  }
  if($sum < 1) {
   $error = 4;
   $mess = "Ставки от 1";
   $fa = "fatal";
  }
  if($sum > $max_bet) {
   $error = 5;
   $mess = "Макс ставка - $max_bet";
   $fa = "fatal";
  }
  if($per < $min_per || $per > $max_per ) {
   $error = 6;
   $mess = "Шанс от " . $min_per . " до " . $max_per;
   $fa = "fatal";
  }
  if(!is_numeric($per)) {
   $error = 7;
   $mess = "Ошибка!";
   $fa = "fatal";
  }
  if (!preg_match("#^[.0-9]+$#",$sum)) {
   $error = 8;
   $mess = "Недопустимые символы!";
   $fa = "fatal";
  }
  if (!preg_match("#^[.0-9]+$#",$per)) {
   $error = 8;
   $mess = "Недопустимые символы!";
   $fa = "fatal";
  }
  if(!$_SESSION['hash']) {
   $error = 9;
   $mess = "Авторизуйтесь";
   $fa = "fatal";
  }

  if($error == 0) {
    $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$balance = $row['balance'];
$ban = $row['ban'];
$sliv = $row['sliv'];
$fart = $row['win'];
$login = $row['login'];
$user_id = $row['id'];
$usbetsum = $row['betsum'];

}
if ( empty($usbetsum) ){

$usbetsum = 0;

}
  if($team == "red") {
$nwin = ($per * 10) - 1;
    $win_range = ($per / 100) * 999;
      if($fart == 0) {
  if($sliv == 0) {
  $rand = rand(1,999);
  }
  }
  if($sliv == 1) {
    $rand = rand($win_range, 999);
    $rand = rand($rand, 999);
  }
  if($fart == 1) {
    $rand = getrandmax($win_range, $nwin);
    $rand = rand($rand, $nwin);
  }
    if($rand > $win_range) {
       $newbalance = $balance - $sum;
     $update_sql2 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql2);

      $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `color`, `colordrop`, `mode`)
  VALUES ('NULL', '$user_id', '$login', '$rand', '$nwin - 999', '$sum', '$per', 'lose', '-$sum', '$team', 'blue', '1');";
mysql_query($insert_sql1);
     $mess = "Вы проиграли! Выпало число: $rand";
     $fa = "error";
    }
    if($rand <= $win_range) {
       $newbalance = ($balance + $win) - $sum;
     $update_sql2 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql2);
      $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `color`, `colordrop`, `mode`)
  VALUES ('NULL', '$user_id', '$login', '$rand', '$nwin - 999', '$sum', '$per', 'win', '+$win', '$team', 'red', '1');";
mysql_query($insert_sql1);
     $fa = "success";
    }
  }

 if($team == "blue") {
   $nwin = ($per * 100) - 1;
   $win_range = 999 - ($per / 100) * 999;
   if($fart == 0) {
  if($sliv == 0) {
  $rand = rand(1,999);
  }
  }
  if($sliv == 1) {
    $rand = rand(0, $win_range);
    $rand = rand(0, $rand);
  }
   if($fart == 1) {
    $rand = rand($win_range, 999);
    $rand = rand($rand, 999);
 //   $rand = rand($nwin, $rand);
  }
    if($rand < $win_range) {
     $newbalance = $balance - $sum;
     $update_sql2 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql2);
      $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `color`, `colordrop`, `mode`)
  VALUES ('NULL', '$user_id', '$login', '$rand', '$nwin - 999', '$sum', '$per', 'lose', '-$sum', '$team', 'red', '1');";
mysql_query($insert_sql1);
     $mess = "Вы проиграли! Выпало число: $rand";
     $fa = "error";
    }
    if($rand >= $win_range) {
       $newbalance = ($balance + $win) - $sum;
     $update_sql2 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql2);
     $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `color`, `colordrop`, `mode`)
  VALUES ('NULL', '$user_id', '$login', '$rand', '$nwin - 999', '$sum', '$per', 'win', '+$win', '$team', 'blue', '1');";
mysql_query($insert_sql1);
     $fa = "success";
    }
  }
  }

  $result = array(
  'success' => "$fa",
  'error' => "$mess",
    'number' => "$rand",
    'win' => "$win",
    'balance' => "$balance",
    'new_balance' => "$newbalance"
    );
}
if($type == "resetPassPanel") {
 $newpass = $_POST['newPass'];
  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$newpass)) {
    $error = 1;
	$mess = 'Недопустимые символы';
	$fa = "error";
  }
  if($error == 0) {
 $update_sql2 = "UPDATE engmn_user SET pass = '$newpass' WHERE hash = '$sid'";
    mysql_query($update_sql2);
  $fa = "success";
  }
  $result = array(
	'success' => "$fa",
	'error' => "$mess"
    );
}
if($type == "deposit")
{

$size = $_POST['sum'];
$sql_select = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$user_id = $row['id'];
}

if($error == 0) {
$podpis = md5($fk_id.':'.$size.':'.$fk_secret_1.':'. $user_id);
  $fa = "success";
}
    $result = array(
  'success' => "success",
  'locations' => "http://www.free-kassa.ru/merchant/cash.php?m=".$fk_id."&oa={$size}&o={$user_id}&s=".$podpis.""
    );
}
if($type == "continue_reg") {
  $login = $_POST['login'];
  $pass = $_POST['pass'];
  $dllogin = strlen($login);
  $dlpass = strlen($pass);
  $sql_select1 = sprintf("SELECT COUNT(*) FROM engmn_user WHERE login='%s'", mysql_real_escape_string($login));
$result1 = mysql_query($sql_select1);
$row = mysql_fetch_array($result1);
if($row)
{
$count = $row['COUNT(*)'];
}
$ip_c = $_SERVER['REMOTE_ADDR'];
$sql_select11 = sprintf("SELECT COUNT(*) FROM engmn_user WHERE ip='%s'", mysql_real_escape_string($ip_c));
$result11 = mysql_query($sql_select11);
$row = mysql_fetch_array($result11);
if($row)
{
$count_ipp = $row['COUNT(*)'];
}
$sql_select100 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result100 = mysql_query($sql_select100);
$rw = mysql_fetch_array($result100);
if ( $rw ) {

  $myregip = $rw['ip'];

}
  if($login == '' || $pass == '') {
   $error = 1;
   $mess = "Заполните все поля";
   $fa = "error";
  }
  if($login != '' && $pass != '') {
  if($dllogin < 5 || $dllogin > 15) {
   $error = 2;
   $mess = "Логин от 5 до 15 симв.";
   $fa = "error";
  }
  if($dlpass < 6 || $dlpass > 12) {
   $error = 3;
   $mess = "Пароль от 6 до 12 симв.";
   $fa = "error";
  }
  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$login)) {
    $error = 4;
	$mess = 'Недопустимые символы';
	$fa = "error";
  }
  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$pass)) {
    $error = 5;
	$mess = 'Недопустимые символы';
	$fa = "error";
  }
  if($count >= 1) {
    $error = 6;
	$mess = "Логин занят";
	$fa = "error";
  }
if($count_ip > 1) {
    $error = 7;
    $mess = "Такой IP уже зарегистрирован";
    $fa = "error";
  }
  }
  if($error == 0) {

	if ( $encpass == 1 ){

	$pass = md5($pass);

}
	$ref = $_SESSION["ref"];
  $last_id = mysql_query("SELECT id FROM engmn_user ORDER BY id DESC LIMIT 1");
$lastid = mysql_result($last_id, 0) +1;
 $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
 $ref_code = substr(str_shuffle($str_result), 0, 1);
 $ref_code = $ref_code . $lastid . $ref_code;
	$update_sql1 = "UPDATE engmn_user SET login = '$login' WHERE hash = '$sid'";
    mysql_query($update_sql1);
    $update_sql2 = "UPDATE engmn_user SET pass = '$pass' WHERE hash = '$sid'";
    mysql_query($update_sql2);
     $update_sql2 = "UPDATE engmn_user SET ref_id = '$ref' WHERE hash = '$sid'";
    mysql_query($update_sql2);
     $update_sql2 = "UPDATE engmn_user SET ref_code = '$ref_code' WHERE hash = '$sid'";
    mysql_query($update_sql2);
    $fa = "success";
  }
  $result = array(
	'success' => "$fa",
	'error' => "$mess"
    );
}
if($type == "registration") {
  $login1 = $_POST['login'];
  $pass = $_POST['pass'];
  $repeatpass = $_POST['repeatpass'];
  $dllogin = strlen($login1);
  $dlpass = strlen($pass);
  $sql_select1 = sprintf("SELECT COUNT(*) FROM engmn_user WHERE login='%s'", mysql_real_escape_string($login1));
$result1 = mysql_query($sql_select1);
$row = mysql_fetch_array($result1);
if($row)
{
$count = $row['COUNT(*)'];
}
$ip_c = $_SERVER['REMOTE_ADDR'];
$sql_select11 = sprintf("SELECT COUNT(*) FROM engmn_user WHERE ip='%s'", mysql_real_escape_string($ip_c));
$result11 = mysql_query($sql_select11);
$row = mysql_fetch_array($result11);
if($row)
{
$count_ip = $row['COUNT(*)'];
}
  if($login1 == '' || $pass == '' || $repeatpass == '') {
    $error = 1;
    $mess = "Заполните все поля";
    $fa = "error";
  }
  if($pass != $repeatpass) {
    $error = 2;
    $mess = "Пароли не совпадают";
    $fa = "error";
  }
  if($login1 != '' && $pass != '' && $repeatpass != '') {
  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$login1)) {
    $error = 3;
  $mess = "Недопустимые символы";
  $fa = "error";
  }
  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$pass)) {
    $error = 4;
  $mess = "Недопустимые символы";
  $fa = "error";
  }
  if($dllogin < 4 || $dllogin > 20) {
    $error = 5;
    $mess = "Логин от 4 до 20 симв.";
    $fa = "error";
  }
  if($count >= 1) {
    $error = 6;
    $mess = "Логин занят";
    $fa = "error";
  }
  if($count_ip >= 1) {
    $error = 7;
    $mess = "Такой IP уже зарегистрирован";
    $fa = "error";
  }
    if($dlpass < 6 || $dlpass > 12) {
    $error = 8;
    $mess = "Пароль от 6 до 12 симв.";
    $fa = "error";
  }
  }
  if($error == 0) {
    if ( $encpass == 1 ){

      $pass = md5($pass);

    }
$ip = $_SERVER["REMOTE_ADDR"];
$ref = $_SESSION["ref"];
$datas = date("d.m.Y");
  $datass = date("H:i:s");
  $data = "$datas $datass";
  $chars3="qazxswedcvfrtgnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
$max3=32;
$size3=StrLen($chars3)-1;
$passwords3=null;
while($max3--)
$hash.=$chars3[rand(32,$size3)];

$last_id = mysql_query("SELECT id FROM engmn_user ORDER BY id DESC LIMIT 1");
$lastid = mysql_result($last_id, 0) +1;
 $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
 $ref_code = substr(str_shuffle($str_result), 0, 1);
 $ref_code = $ref_code . $lastid . $ref_code;

 $refer_find = mysql_query("SELECT * FROM engmn_user WHERE ref_code='" . $ref . "'");
 $referfind = mysql_fetch_array($refer_find);
 if ( $referfind ){

    $refercode = $referfind['ref_code'];

 }
 if ( $refercode != $ref or $ref == "" ){

$ref = "";

 }else{

    $bonus_reg = $bonus_reg + $ref_size;

 }
  $insert_sql1 = "INSERT INTO `engmn_user` (`date_reg`, `ip`, `ref_id`, `ref_code`, `login`, `pass`, `hash`, `balance`, `social`)
  VALUES ('{$data}', '{$ip}', '{$ref}', '{$ref_code}', '{$login}', '{$pass}', '{$hash}', '{$bonus_reg}', '');";
mysql_query($insert_sql1);
    $_SESSION['hash'] = $hash;
    $_SESSION['login'] = 1;
    $fa = "success";
  }
  $result = array(
  'success' => "$fa",
  'error' => "$mess"
    );
}
if($type == "login") {
  $login = $_POST['login'];
  $pass = $_POST['pass'];
 $sql_select11 = sprintf("SELECT * FROM engmn_user WHERE login = '" . $login . "'");
$result11 = mysql_query($sql_select11);
$row11 = mysql_fetch_array($result11);
if($row11)
{
$encpassusr = $row11['encpass'];
$passs = $row11['pass'];
}

  if ( $encpassusr == "1" ){

	$pass = md5($pass);

}

  $sql_select1 = sprintf("SELECT COUNT(*) FROM engmn_user WHERE login='%s' AND pass='%s'", mysql_real_escape_string($login), mysql_real_escape_string($pass));
$result1 = mysql_query($sql_select1);
$row = mysql_fetch_array($result1);
if($row)
{
$count = $row['COUNT(*)'];
}
  if($login == '' || $pass == '') {
    $error = 1;
    $mess = "Заполните все поля";
    $fa = "error";
  }
  if($login != '' && $pass != '') {
  if($count == 0) {
    $error = 2;
    $mess = "Неверный логин или пароль";
    $fa = "error";
  }

  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$login)) {
    $error = 3;
	$mess = 'Недопустимые символы';
	$fa = "error";
}
  if (!preg_match("#^[aA-zZ0-9\-_]+$#",$pass)) {
    $error = 4;
	$mess = 'Недопустимые символы';
	$fa = "error";
}

  }


  if($error == 0) {
    $sql_select2 = sprintf("SELECT * FROM engmn_user WHERE login='%s' AND pass='%s'", mysql_real_escape_string($login), mysql_real_escape_string($pass));
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$hash = $row['hash'];
}
    $_SESSION['hash'] = $hash;
    $_SESSION['login'] = 1;
    $fa = "success";
  }
  $result = array(
	'success' => "$fa",
	'error' => "$mess"
    );
}
if($type == "deletewithdraw") {
  $id_delete = $_POST['del'];
$sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$login = $row['login'];
$ban = $row['ban'];
$balance = $row['balance'];
}
$sql_select3 = "SELECT * FROM engmn_withdraws WHERE id='$id_delete'";
$result3 = mysql_query($sql_select3);
$row = mysql_fetch_array($result3);
if($row)
{
$user_id_w = $row['user_id'];
$sum = $row['sum'];
$status = $row['status'];
}
if($status != 0) {
   $error = 1;
   $mess = "";
   $fa = "error";
}
if($user_id != $user_id_w) {
   $error = 2;
   $mess = "";
   $fa = "error";
}
  if($error == 0) {
    $delete = "DELETE FROM `engmn_withdraws` WHERE id = '$id_delete'";
mysql_query($delete);
  $newbalance = $balance + $sum;
    $update_sql1 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql1);
    $fa = "success";
  }
  $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$newbalance"
    );
}
if($type == "withdrawuser") {

$sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$login = $row['login'];
$ban = $row['ban'];
$balance = $row['balance'];
}
$sql_select23 = "SELECT SUM(suma) FROM engmn_payments WHERE user_id='$user_id'";
$result23 = mysql_query($sql_select23);
$row = mysql_fetch_array($result23);
if($row)
{
$sumdep = $row['SUM(suma)'];
}
if($sumdep == '') {
 $sumdep = 0;
}
$system = $_POST['system'];
$wallet = $_POST['wallet'];
$sum = $_POST['sum'];
  if($system == 4) {
      $ps = "qiwi";
    }
    if($system == 2) {
      $ps = "payeer";
    }
    if($system == 3) {
      $ps = "wm";
    }
    if($system == 1) {
      $ps = "ya";
    }
    if($system == 5) {
      $ps = "beeline";
    }
    if($system == 6) {
      $ps = "megafon";
    }
    if($system == 7) {
      $ps = "mts";
    }
    if($system == 8) {
      $ps = "tele";
    }
    if($system == 9) {
      $ps = "visa";
    }
    if($system == 10) {
      $ps = "mc";
    }
$dwallet = strlen($wallet);
if($wallet == '' || $sum == '') {
  $error = 1;
  $mess = 'Заполните все поля';
  $fa = "error";
}
if($sum > $balance) {
  $error = 2;
  $mess = "Недостаточно средств";
  $fa = "error";
}
if($ban == 1) {
  $error = 3;
  $mess = "Ваш аккаунт заблокирован";
  $fa = "error";
}
  if($sum != '' && $wallet != '') {
if(!is_numeric($sum)) {
  $error = 4;
  $mess = "Введите корректную сумму";
  $fa = "error";
}
if($dwallet < 8 || $dwallet > 20) {
  $error = 5;
  $mess = "Кошелек от 8 до 20 символов";
  $fa = "error";
}

if($sum < $min_withdraw_sum) {
  $error = 6;
  $mess = "Минимальная сумма вывода $min_withdraw_sum";
  $fa = "error";
}
if (!preg_match("#^[aA-zZ0-9\-_.]+$#",$sum))
{
	$mess = "Недопустимые символы в сумме";
	$fa = "error";
	$error = 7;
}
if (!preg_match("#^[+0-9PpWw]+$#",$wallet))
{
	$mess = "Недопустимые символы в реквизитах";
	$fa = "error";
	$error = 8;
}
if($sumdep < $dep_withdraw) {
    $mess = "Пополните баланс на $dep_withdraw";
    $error = 9;
  $fa = "error";

  }
  }
  if($error == 0) {
    $summ = round($sum, 2);
    $newbalance = $balance - $sum;
    $datas = date("d.m.Y");
	$datass = date("H:i:s");
	$data = "$datas $datass";
    $insert_sql11 = "INSERT INTO `engmn_withdraws` (`id`, `user_id`, `ps`, `wallet`, `sum`, `date`, `status`) VALUES (NULL, '$user_id', '$ps', '$wallet', '$summ', '$data', '0');";
    mysql_query($insert_sql11);
    $update_sql1 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql1);
    $fa = "success";
}
  $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$newbalance"
    );
}
if($type == "createPromoUser") {

$sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$ban = $row['ban'];
$balance = $row['balance'];
}
$name = $_POST['createname'];
$sum = $_POST['createsum'];
$act = $_POST['createactive'];
$sql_select4 = sprintf("SELECT COUNT(*) FROM engmn_promo WHERE name='%s'", mysql_real_escape_string($name));
$result4 = mysql_query($sql_select4);
$row = mysql_fetch_array($result4);
if($row)
{
$count = $row['COUNT(*)'];
}
if($name == '' || $sum == '' || $act == '') {
  $error = 1;
  $mess = "Заполните все поля";
  $fa = "error";
}
if($ban == 1) {
  $error = 2;
  $mess = "Ваш аккаунт заблокирован";
  $fa = "error";
}
if(($sum * $act) > $balance) {
  $error = 3;
  $mess = "Недостаточно средств";
  $fa = "error";
}
  if($name != '' && $sum != '' && $act != '') {
  if($sum < 1) {
  $error = 4;
  $mess = "Сумма от 1";
  $fa = "error";
}
  if($act < 1) {
  $error = 5;
  $mess = "Кол-во от 1";
  $fa = "error";
}
  if(!is_numeric($sum)) {
  $error = 6;
  $mess = "Сумма цифрами";
  $fa = "error";
}
  if(!is_numeric($act)) {
  $error = 7;
  $mess = "Кол-во цифрами";
  $fa = "error";
}
  if (!preg_match("#^[а-яА-ЯaA-zZ0-9\-_]+$#",$name)) {
   $error = 8;
   $mess = "Недопустимые символы";
   $fa = "error";
}
  if($count > 0) {
  $error = 9;
  $mess = "Промокод уже существует";
  $fa = "error";
}
}
  if($error == 0) {
    $datas = date("d.m.Y");
	$datass = date("H:i:s");
	$data = "$datas $datass";
  $newbalance = $balance - ($sum * $act);
  $insert_sql1 = "INSERT INTO `engmn_promo` (`id`, `date`, `name`, `sum`, `active`, `actived`, `id_active`) VALUES (NULL, '$data', '$name', '$sum', '$act', '0', '');";
    mysql_query($insert_sql1);
    $update_sql1 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql1);
    $fa = "success";
}
$result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$newbalance"
    );
}
if($type == "activePromo") {

$sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$ban = $row['ban'];
$balance = $row['balance'];
}
// инфу о пользователе мы получили, получаем промо
$promo = $_POST['promoactive']; // получаем введенное промо
$sql_select = sprintf("SELECT COUNT(*) FROM engmn_promo WHERE name='%s'", mysql_real_escape_string($promo));
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$count = $row['COUNT(*)'];
}

  if($promo == '') {
    $error = 1;
    $mess = "Введите промокод";
    $fa = "error";
  }
  if($count == 0) {
    $error = 2;
    $mess = "Промокод не найден";
    $fa = "error";
  }
 if($count != 0) {
    $sql_select1 = "SELECT * FROM engmn_promo WHERE name='$promo'";
$result1 = mysql_query($sql_select1);
$row = mysql_fetch_array($result1);
if($row)
{
$sum = $row['sum'];
$limit = $row['active'];
$actived = $row['actived'];
$idactive = $row['id_active'];
}
  }
  if($count == 1) {
  if($limit == $actived || $actived > $limit) {
    $error = 3;
    $mess = "Активации закончились";
    $fa = "error";
  }
  if($ban == 1) {
    $error = 4;
    $mess = "Ваш аккаунт заблокирован";
    $fa = "error";
  }
  }
  if (preg_match("/$user_id /",$idactive))  {
	$error = 5;
    $mess = "Вы уже активировали этот код";
    $fa = "error";
   }
  if($error == 0) {
    $newbalance = $balance + $sum;
    $newactive = $actived + 1;
    $newid = "$user_id $idactive";
    $update_sql1 = "UPDATE engmn_user SET balance = '$newbalance' WHERE hash = '$sid'";
    mysql_query($update_sql1);
    // обновляем бд (2)
    $update_sql2 = "UPDATE engmn_promo SET actived = '$newactive' WHERE name = '$promo'";
    mysql_query($update_sql2);
    // обновляем бд (3)
    $update_sql3 = "UPDATE engmn_promo SET id_active = '$newid' WHERE name = '$promo'";
    mysql_query($update_sql3);
    $fa = "success";
  }
  $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$newbalance"
    );
}
if($type == "bonus")
{
$min_bonus_size = $min_bonus_s * 100;
$max_bonus_size = $max_bonus_s * 100;
$data = Date("dmY");
$sql_select = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bonus = $row['bdate'];
$payment_user_id = $row['id'];
$balance = $row['balance'];
}
$sql_select23 = "SELECT SUM(suma) FROM engmn_payments WHERE user_id='$payment_user_id'";
$result23 = mysql_query($sql_select23);
$row = mysql_fetch_array($result23);
if($row)
{
$sumdep = $row['SUM(suma)'];
}
$sql_selector = "SELECT * FROM engmn_config WHERE id='1'";
$resultor = mysql_query($sql_selector);
$rower = mysql_fetch_array($resultor);
if($rower)
{
$bSum = $rower['bsum'];
}

if($bonus == $data){
    $error = 5;
$fa = "error";
$mess = "Вы получали бонус за эти 24 часа";
}
if ( $minbonusdep != 0 ){
if ( $sumdep < $minbonusdep ){

$error = 6;
$fa = "error";
$mess = "Для получения бонуса нужно пополнить <b>" . $minbonusdep . "</b> D.";

}
}
if ( $error == 0 ){
    $randomb = rand($min_bonus_size,$max_bonus_size) / 100;
$balancenew = $balance + $randomb;
$bsum = $bsum + $randomb;

$update_sql = "Update engmn_user set balance='$balancenew' WHERE hash='$sid'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
$update_sql = "Update engmn_config set bsum='$bsum' WHERE id='1'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
$update_sql = "Update engmn_user set bdate='$data' WHERE hash='$sid'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
$fa = "success";
}
$result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$balancenew",
	'bonussize' => "$randomb"
    );
}
if($type == "activateref")
{
$rcode = $_POST['refcode'];
$sql_select = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$refidd = $row['ref_code'];
$myrefer = $row['ref_id'];
$balance = $row['balance'];
}

$sql_selector = "SELECT * FROM engmn_config WHERE id='1'";
$resultor = mysql_query($sql_selector);
$rower = mysql_fetch_array($resultor);
if($rower)
{
$bSum = $rower['bsum'];
}

if($rcode == $refidd){
    $error = 111;
$fa = "error";
$mess = "Вы не можете активировать свой реф. код!";
}
if ( empty($rcode) ){

    $error = 222;
$fa = "error";
$mess = "Введите реф. код!";

}
 $sql_selecta = "SELECT * FROM engmn_user WHERE ref_code='$rcode'";
$resulta = mysql_query($sql_selecta);
$rowa = mysql_fetch_array($resulta);
 if ( $rowa['ref_code'] != $rcode ){
    $error = 6;

$fa = "error";
$mess = "Такого реф.кода не существует!";
}
if ( !empty($myrefer) ){

    $error = 7;
    $fa = 'error';
    $mess = 'Вы уже активировали реф. код!';

}
if ( $error == 0 ){

$balancenew = $balance + $ref_size;
$update_sql = "Update engmn_user set balance='$balancenew' WHERE hash='$sid'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
$update_sql = "Update engmn_user set ref_id='$rcode' WHERE hash='$sid'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
$fa = "success";
}
$result = array(
  'success' => "$fa",
  'error' => "$mess",
  'balance' => "$balance",
  'new_balance' => "$balancenew",
  'bonussize' => "$randomb"
    );
}
if($type == "exit") {
 unset($_SESSION['hash']);
 unset($_SESSION['login']);
  $fa = "success";
  $result = array(
	'success' => "$fa",
	'error' => "$mess"
    );
}
if($type == "minbet") {
 // $winsum = $_POST['win'];

  $sum = $_POST['amount'];
  $per = $_POST['chance'];
  $nwin = ($per * 10000) - 1;
  $winsum = round(((100 / $per * $sum) - $sum), 2);
  //$nwin = $_POST['nwin'];
  $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$balance = $row['balance'];
$ban = $row['ban'];
$sliv = $row['sliv'];
$fart = $row['win'];
$login = $row['login'];
$user_id = $row['id'];
}
  if($fart == 0) {
  if($sliv == 0) {
  $rand = rand(0,999999);
  }
  }
  if($sliv == 1) {
    $rand = rand($nwin, 999999);
  }
  if($fart == 1) {
    $rand = rand(0, $nwin);
  }
  $hash = hash('sha512', $rand);
  if((empty($_SESSION['hash'])) || $_SESSION['login'] != 1){
    $error = 2;
    $mess = "Авторизуйтесь";
    $fa = "error";
  }
     if($_SESSION['hash'] != '') {
       if($sum > $balance) {
         $newbalance = $balance;
         $error = 4;
         $mess = "Недостаточно средств";
         $fa = "error";
       }
       if($per > $max_per || $per < $min_per) {
         $newbalance = $balance;
         $error = 98;
         $mess = "% Шанс от $min_per до $max_per";
         $fa = "error";
       }
       if($ban == 1) {
         $newbalance = $balance;
         $error = 97;
         $mess = "Ваш аккаунт заблокирован";
         $fa = "error";
       }
       if($sum < $min_bet) {
         $newbalance = $balance;
         $error = 64;
         $mess = "Ставки от $min_bet";
         $fa = "error";
       }
       if($sum > $max_bet) {
         $newbalance = $balance;
         $error = 69;
         $mess = "Макс. ставка $max_bet";
         $fa = "error";
       }
       if(!is_numeric($sum)) {
           $newbalance = $balance;
         $error = 77;
         $mess = "Введите сумму корректно";
         $fa = "error";

       }
       if($error == 0) {
  if($rand <= $nwin)
  {
    $summ = round($sum, 2);
    $winsumm = round($winsum, 2) + $sum;
	if ( $winsumm == 0 ){

		$winsumm = "-" . $summ;

	}else{

		$winsumm = "+" . round($winsum, 2) + $sum;

	}
  $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`)
	VALUES ('NULL', '$user_id', '$login', '$rand', '0 - $nwin', '$summ', '$per', 'win', '$winsumm');";
mysql_query($insert_sql1);
  $newbalance = $balance + $winsum;
    $update_sql4 = "Update engmn_user set balance='$newbalance' WHERE hash='$sid'";
      mysql_query($update_sql4);
	$newbetsum = $betsum + $sum;
   $update_sql5 = "Update engmn_config set betsum='$newbetsum' WHERE id='1'";
      mysql_query($update_sql5);
  $fa = "success";
  }
       }

       if($error == 0) {
  if($rand > $nwin)
  {
    $summ = round($sum, 2);
     $winsumm = round($winsum, 2) + $sum;
	if ( $winsumm == 0 ){

		$winsumm = "-" . $summ;

	}else{

		$winsumm = "+" . round($winsum, 2) + $sum;

	}
  $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`)
	VALUES ('NULL', '$user_id', '$login', '$rand', '0 - $nwin', '$summ', '$per', 'lose', '0');";
mysql_query($insert_sql1);
  $newbalance = $balance - $sum;
    $update_sql4 = "Update engmn_user set balance='$newbalance' WHERE hash='$sid'";
      mysql_query($update_sql4);
  $newbetsum = $betsum + $sum;
   $update_sql5 = "Update engmn_config set betsum='$newbetsum' WHERE id='1'";
      mysql_query($update_sql5);
  $error = 0;
  $mess = "Выпало <b>$rand</b>";
  $fa = "success";
  }
   }
     }

  $winning = $winsum + $sum;
  $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'number' => "$rand",
    'hash' => "$hash",
    'fullwin' => "$winning",
    'balance' => "$balance",
    'new_balance' => "$newbalance"

    );
}
if($type == "maxbet") {
  // $winsum = $_POST['win'];
  $per = $_POST['per'];
  $nwin = 1000000 - ($per * 10000);
  //$nwin = $_POST['nwin'];
  $sum = $_POST['sum'];
  $sum = round($sum, 2);
  $winsum = round(((100 / $per * $sum) - $sum), 2);
  $sql_select3 = "SELECT * FROM engmn_config WHERE id='1'";
$result3 = mysql_query($sql_select3);
$row = mysql_fetch_array($result3);
if ($row){

	$betsum = $row['betsum'];

}
  $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$balance = $row['balance'];
$ban = $row['ban'];
$sliv = $row['sliv'];
$fart = $row['win'];
$login = $row['login'];
$user_id = $row['id'];
$usbetsum = $row['betsum'];

}
if ( empty($usbetsum) ){

$usbetsum = 0;

}
  if($fart == 0) {
  if($sliv == 0) {
  $rand = rand(0,999999);
  }
  }
  if($sliv == 1) {
    $rand = rand(0, $nwin);
  }
  if($fart == 1) {
    $rand = rand($nwin, 999999);
  }
  $hash = hash('sha512', $rand);
  if((empty($_SESSION['hash'])) || $_SESSION['login'] != 1){
    $error = 2;
    $mess = "Авторизуйтесь";
    $fa = "error";
  }

     if($_SESSION['hash'] != '') {
       if($sum > $balance) {
         $newbalance = $balance;
         $error = 1;
         $mess = "Недостаточно средств";
         $fa = "error";
       }
       if($per > $max_per || $per < $min_per) {
         $newbalance = $balance;
         $error = 2;
         $mess = "% Шанс от $min_per до $max_per";
         $fa = "error";
       }
       if($ban == 1) {
         $newbalance = $balance;
         $error = 3;
         $mess = "Ваш аккаунт заблокирован";
         $fa = "error";
       }
       if($sum < $min_bet) {
         $newbalance = $balance;
         $error = 4;
         $mess = "Ставки от $min_bet";
         $fa = "error";
       }
       if($sum > $max_bet) {
         $newbalance = $balance;
         $error = 5;
         $mess = "Макс. ставка $max_bet";
         $fa = "error";
       }
       if(!is_numeric($sum)) {
           $newbalance = $balance;
         $error = 6;
         $mess = "Введите сумму корректно";
         $fa = "error";

       }
       if($error == 0) {
  if($rand >= $nwin)
  {
    $summ = round($sum, 2);
     $winsumm = round($winsum, 2) + $sum;

$winsumm = "+" . $winsumm;

  $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`)
	VALUES ('NULL', '$user_id', '$login', '$rand', '$nwin - 999999', '$summ', '$per', 'win', '$winsumm');";
mysql_query($insert_sql1);
  $newbalance = $balance + $winsum;
    $update_sql4 = "Update engmn_user set balance='$newbalance' WHERE hash='$sid'";
      mysql_query($update_sql4);

	$newbetsum = $betsum + $sum;
   $update_sql5 = "Update engmn_config set betsum='$newbetsum' WHERE id='1'";
      mysql_query($update_sql5);
      $newusbetsum = $usbetsum + $sum;
   $update_sq5555 = "Update engmn_user set betsum='$newusbetsum' WHERE hash='$sid'";
      mysql_query($update_sq5555);
  $fa = "success";
  }
       }
     }


       if($error == 0) {
  if($rand < $nwin)
  {
    $summ = round($sum, 2);
     $winsumm = round($winsum, 2) + $sum;
$winsumm = "-" . $winsumm;

  $insert_sql1 = "INSERT INTO `engmn_games` (`id`,`user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`)
	VALUES ('NULL', '$user_id', '$login', '$rand', '$nwin - 999999', '$summ', '$per', 'lose', '$winsumm');";
mysql_query($insert_sql1);
  $newbalance = $balance - $sum;
    $update_sql4 = "Update engmn_user set balance='$newbalance' WHERE hash='$sid'";
      mysql_query($update_sql4);
	  $newbetsum = $betsum + $sum;
   $update_sql5 = "Update engmn_config set betsum='$newbetsum' WHERE id='1'";
      mysql_query($update_sql5);
            $newusbetsum = $usbetsum + $sum;
   $update_sq5555 = "Update engmn_user set betsum='$newusbetsum' WHERE hash='$sid'";
      mysql_query($update_sq5555);
  $error = 0;
  $mess = "Выпало <b>$rand</b>";
  $fa = "success";
  }
       }

  $winning = $winsum + $sum;

  $result = array(
	'success' => "$fa",
	'error' => "$mess",
	'number' => "$rand",
    'hash' => "$hash",
    'fullwin' => "$winning",
    'balance' => "$balance",
    'new_balance' => "$newbalance"

    );
}

  if ( $type == "chatClear" ){

 $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$he_admin = $row['admin'];

}
if ( $he_admin != 1 and $he_admin != 2 and $he_admin !=3){

  $error = 1;
  $mess = "Вы не являетесь администратором.";
  $fa = "error";

}
if ( $error == 0 ){

mysql_query("DELETE FROM `engmn_messages`");
$error = 0;
$mess = "Вы успешно очистили чат!";
$fa = "success";

}
$result = array(
  'success' => "$fa",
  'error' => "$mess"
    );
 }
  if ( $type == "cbanUser" ){

$cUsBan = $_POST['cbanUserId'];
 $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$he_admin = $row['admin'];

}
$sql_select3 = "SELECT * FROM engmn_user WHERE id='$cUsBan'";
$result3 = mysql_query($sql_select3);
$row1 = mysql_fetch_array($result3);
if($row1)
{
$clogin = $row1['login'];
$cname = $row1['vk_name'];
$cbanned = $row1['chat_ban'];
$hee_admin = $row1['admin'];
}
if ( !empty($cname) ){

$clogin = $cname;

}
if ( $he_admin != 1 and $he_admin != 2 and $he_admin !=3 ){

  $error = 1;
  $mess = "Вы не являетесь администратором.";
  $fa = "error";

}
if ( $he_admin != 1 ){
if ( $hee_admin == 1 or $hee_admin == 2 or $hee_admin == 3 ){

$error = 2;
$mess = "Данный пользователь является администратором.";
$fa = "error";

}
}
if ( $cbanned == 1){

$error = 3;
$mess = "Данный пользователь уже заблокирован.";
$fa = "error";

}
if ( empty($clogin) ){

  $error = 4;
$mess = "Пользователя с таким ID не существует.";
$fa = "error";
}
if ( $error == 0 ){

mysql_query("Update engmn_user set chat_ban=1 WHERE id='$cUsBan'");
mysql_query("DELETE FROM engmn_messages WHERE user_id='$cUsBan'");
 mysql_query("INSERT INTO engmn_messages (user_id,name,text,prefix,admin_hide) VALUES ('','sys', '" . $clogin . ' забанен.' . "', 'sys', '1')");

$error = 0;
$mess = "Вы успешно заблокировали пользователя под ID: " . $cUsBan;
$fa = "success";

}
$result = array(
  'success' => "$fa",
  'error' => "$mess"
    );
 }
  if ( $type == "cunbanUser" ){

$cUsBan = $_POST['cunbanUserId'];
 $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$he_admin = $row['admin'];

}
$sql_select3 = "SELECT * FROM engmn_user WHERE id='$cUsBan'";
$result3 = mysql_query($sql_select3);
$row1 = mysql_fetch_array($result3);
if($row1)
{
$clogin = $row1['login'];
$cbanned = $row1['chat_ban'];
$hee_admin = $row1['admin'];
}

if ( $he_admin != 1 and $he_admin != 2 and $he_admin !=3 ){

  $error = 1;
  $mess = "Вы не являетесь администратором.";
  $fa = "error";

}
if ( $cbanned != 1){

$error = 3;
$mess = "Данный пользователь не имеет блокировки.";
$fa = "error";

}
if ( empty($clogin) ){

  $error = 4;
$mess = "Пользователя с таким ID не существует.";
$fa = "error";
}
if ( $error == 0 ){

mysql_query("Update engmn_user set chat_ban=0 WHERE id='$cUsBan'");

$error = 0;
$mess = "Вы успешно заблокировали пользователя под ID: " . $cUsBan;
$fa = "success";

}
$result = array(
  'success' => "$fa",
  'error' => "$mess"
    );
 }

 if ( $type == "deleteMsg" ){

    $msg_id = $_POST['msgg_id'];
 $sql_select2 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result2 = mysql_query($sql_select2);
$row = mysql_fetch_array($result2);
if($row)
{
$user_id = $row['id'];
$he_admin = $row['admin'];

}
$sql_select3 = "SELECT * FROM engmn_messages WHERE id='$msg_id'";
$result3 = mysql_query($sql_select3);
$row1 = mysql_fetch_array($result3);
if($row1)
{
  $msgText = $row1['text'];
  $msgAdmin = $row1['admin_hide'];
}

if ( $he_admin != 1 and $he_admin != 2 and $he_admin != 3 ){

  $error = 1;
  $mess = "Вы не являетесь администратором.";
  $fa = "error";

}

if ( empty($msgText) ){

  $error = 4;
$mess = "Такого сообщения не существует.";
$fa = "error";
}
if ( $error == 0 ){

mysql_query("DELETE FROM `engmn_messages` WHERE id='$msg_id'");

$error = 0;
$mess = "Вы успешно удалили сообщение под номером: " . $msgId;
$fa = "success";

}
$result = array(
  'success' => "$fa",
  'error' => "$mess"
    );
 }

    echo json_encode($result);

?>