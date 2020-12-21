<?php
require("inc/bd.php");
require("inc/site_config.php"); 
session_start();
$sid = $_SESSION['hash'];

$sql_select5 = "SELECT COUNT(*) FROM engmn_user WHERE online=1";
$result5 = mysql_query($sql_select5);
$row2 = mysql_fetch_array($result5);
$online = $row2['COUNT(*)'];
$sql_select = "SELECT * FROM engmn_games ORDER BY `id` DESC LIMIT 15";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
do
{
 
	$sql_select1 = "SELECT * FROM engmn_user WHERE id=".$row['user_id'];
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);



if($row['chance'] >= 60)
{
	$sts = "success";
}
if($row['chance'] < 60 && $row['chance'] >= 30)
{
	$sts = "warning";
}
if($row['chance'] <= 29)
{
	$sts = "danger";
}

if($row['type'] == "win")
{
	$st = "success";
}
if($row['type'] == "lose")
{
	$st = "danger";
}
$login = ucfirst($row['login']);

$bot = $row['bot'];

if ( $bot == '1' ){
	
	$usid = '<a>';
	
}else{
	
	$usid = '<a href="user/id/' . $row['user_id'] . '">';
	
}
	
	
	$mode = $row['mode'];
	$colorbtl = $row['color'];
	$colorbtl = str_replace('red', '#f9307e', $colorbtl);
	$colorbtl = str_replace('blue', '#3ea1f8', $colorbtl);

	$nmber = $row['number'];
	if ( $mode != 1 ){
	$nmber = $nmber / 10000;
	$nmber = round($nmber, 2) . '%';
	}
	$cel = $row['chance'];
	$cel = 100 / $cel;
	$cel = round($cel, 2);
	$cel = "x" . $cel;
	$win_summa = $row['win_summa'];
if ( $mode == 1 ){

	$cel = "<p style='background-color: " . $colorbtl . ";padding: 5px 15px;border-radius: 50px;display: inline;'><font color='#fffff'>" . $cel . "</font></p>";
	$win_summa = $row['colordrop'];
	$win_summa = str_replace('red', '#f9307e', $win_summa);
	$win_summa = str_replace('blue', '#3ea1f8', $win_summa);

	$win_summa = "<p style='background-color: " . $win_summa . ";padding: 5px 15px;border-radius: 50px;display: inline;'><font color='#fffff'>" . $row['win_summa'] . "</font></p>";
}
	$sql_select3 = "SELECT * FROM engmn_user WHERE id=".$row['user_id'];
$result3 = mysql_query($sql_select3);
$row3 = mysql_fetch_array($result3);
	if ( $row3 ){

$name = $row3['vk_name'];
if ( !empty($name) ){

$login = explode(' ', $name);
$login = $login[0];

}

}
if ( $mode == 1 ){

$mode = '<a href="/wheel"><img src="/img/wheelModeP.png" /></a>';

}elseif ( $mode == 0) {

$mode = '<a href="/"><img src="/img/dicesRangeP.png" /></a>';

}
if($st == "success"){
		$color = '"table_content transform green"';
		$plus = $win_summa;
	}else{
		
		$color = '"table_content transform red"';
		$plus = "-" . $row['sum'];
	}
	$game =  <<<HERE

$game
<tr class="table_bbg" data-user="2370363" data-game="1"><td>$usid<font color="#0165ff"><b> $login </b></font></a></td><td class="none">$nmber</td><td>$cel</td><td class="none">$row[sum]</td><td class="none">$row[chance]%</td><td class=$color>$plus</td><td>$mode</td> </tr>

HERE;
$st = "";
$sts = "";
$login = "";


}
while($row = mysql_fetch_array($result));
$time = time() + 5;
$update_sql111 = "Update engmn_user set online='1', online_time='$time' WHERE hash='$sid'";
    mysql_query($update_sql111) or die("" . mysql_error());
	
	$sql_select = "SELECT COUNT(*) FROM engmn_user WHERE online='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$online_default = $row['COUNT(*)'];
$fake_online = $fake_online + rand(1, 3);
$online = $online_default + $fake_online;

$sql_select = "SELECT COUNT(*) FROM engmn_user";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$users_default = $row['COUNT(*)'];
$userscount = $users_default;

$sql_select = "SELECT COUNT(*) FROM engmn_games";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$gamescount = $row['COUNT(*)'];


$sql_select = "SELECT * FROM engmn_config WHERE id=" . '1';
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$betsum = $row['betsum'];

$sql_select5 = "SELECT * FROM engmn_user WHERE hash='$sid'";
$result5 = mysql_query($sql_select5);
$row5 = mysql_fetch_array($result5);

$lid = $row5['id'];
$admin = $row5['admin'];

$sql_select = "SELECT * FROM engmn_games WHERE user_id='$lid' AND mode='0' ORDER BY id DESC LIMIT 1";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);


$type = $row['type'];
$numberr = $row['number'];
$numberr = $numberr / 10000;
$numberr = round($numberr, 2);
$chanc = $row['chance'];

	
$sql_select1s = "SELECT * FROM engmn_games WHERE user_id='$lid' ORDER BY id DESC LIMIT 5";
$result1s = mysql_query($sql_select1s);
$row1s = mysql_fetch_array($result1s);

		
if($row1s['type'] == "win")
{
	$stss = "success";
}
if($row1s['type'] == "lose")
{
	$stss = "danger";
}
if($stss == "success"){
		$colorr = '"table_content transform green"';
		$plus = "+" . $win_summa;
	}else{
		
		$color = '"table_content transform red"';
		$plus = "-" . $sum;
	}

	$celll = $row1s['chance'];
	$celll = 100 / $celll;
	$celll = round($celll, 2);
	$celll = "x" . $celll;
	$numberos = $row['number'];
	$numberos = $numberos / 10000;
	$numberos = round($numberos, 2);
	
$row1s = mysql_fetch_array($result1s);
$gamito =  <<<HERE
$gamito
<tr class="table_bbg" data-user="2370363" data-game="1"><td class="none">$numberos%</td><td>$celll</td><td class="none">$row1s[sum]</td><td class="none">$row1s[chance]%</td><td class=$colorr>$plus</td> </tr>

HERE;

	
	
	$sql_select11 = "SELECT * FROM engmn_user WHERE hash='$sid'";
	$result11 = mysql_query($sql_select11);
	$rowito = mysql_fetch_array($result11);

$balanco = round($rowito['balance'], 2);
if ( $balanco >= $max_bet ){
	
	$maxbetos = $max_bet;
	
}else{
	$bolos = explode(".", $balanco);
	$bolos = $bolos[0];
	$maxbetos = $bolos;
	
}
if ( $type == "win" ){
	
	$type = "positive";
	
}else{
	
	$type = "negative";
	
}

if ( $admin == '1' ){
	
	$adminus = '<li><a href="/admin" onclick="location.href = "/admin";" class="profile-light_link">Админ-панель</a></li><li></li>';
	
}

else
	
	{
		
		$adminus = '';
		
	}
	if ( date('j') == 1 ){

		$sql_select11 = "UPDATE engmn_user SET betsum=0";
	$result11 = mysql_query($sql_select11);

	}
	
    $result = array(
	'game' => "$game",
    'online' => "$online",
	'ucount' => "$userscount",
	"gcount" => "$gamescount",
	"betsum" => "$betsum",
	"balancce" => "$balanco",
	'chanc' => "$chanc",
	'numberr' => "$numberr",
	'type' => "$type",
	'adminus' => "$adminus",
    'maxbetos' => "$maxbetos",
	'gamito' => "$gamito"
	);
	
    echo json_encode($result);
?>