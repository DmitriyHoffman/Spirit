<?php
require("inc/bd.php");

session_start();
header('X-Frame-Options:SAMEORIGIN');
header('X-Content-Type-Options:nosniff');
header('X-Frame-Options: DENY');
header("X-XSS-Protection: 1; mode=block");

$sid = $_SESSION['hash'];
$allbots = "SELECT COUNT(*) FROM engmn_bots";
$result_bots = mysql_query($allbots); 
$row = mysql_fetch_array($result_bots);
if($row)
{	
$bots = $row['COUNT(*)'];
}
if ( $bots < 1 ){
	
	$bots_active = 0;
	
}else{
	
	$bots_active = 1;
	
}
if($bots_active == 1) {
if($bots >= 1) {
$randbot = rand(1, $bots); // выбор бота

$select_info_bot = "SELECT * FROM engmn_bots WHERE id = '$randbot'";
$result_select_bots = mysql_query($select_info_bot);
$row = mysql_fetch_array($result_select_bots);
if($row)
{	
$logbot = $row['bot_login'];
$bot_min = $row['bot_min_bet'];
$bot_max = $row['bot_max_bet'];
}
$rand_bot_bet = rand($bot_min, $bot_max); // ставка бота
$rand_bot_per = rand(1, 95); // шанс на выигрыш бота
$rand_bot_number = rand(0, 999999);
$rand_bot_sum = round(((100 / $rand_bot_per) * $rand_bot_bet), 2);
$rand_bot_type = array('min', 'max'); // м или б
$rand_bot_type_select = rand(0, 1);
if($rand_bot_type_select == 0) {
$rand_bot_win_num = $rand_bot_per * 10000;
if($rand_bot_number > $rand_bot_win_num) {
  $rand_bot_type_game = "lose"; // бот проиграл
  $rand_bot_sum = "-" . $rand_bot_bet;
  $rand_bot_cel = "0 - $rand_bot_win_num";
  $bot = "INSERT INTO `engmn_games` (`id`, `user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `bot`) VALUES (NULL, '0', '$logbot', '$rand_bot_number', '$rand_bot_cel', '$rand_bot_bet', '$rand_bot_per', '$rand_bot_type_game', '$rand_bot_sum', '1');";
  mysql_query($bot);
  }
  if($rand_bot_number < $rand_bot_win_num) { // если бот выиграл
  $rand_bot_type_game = "win"; // бот выиграл
  $rand_bot_sum = "+" . round(((100 / $rand_bot_per) * $rand_bot_bet), 2);
  $rand_bot_cel = "0 - $rand_bot_win_num";
  $bot = "INSERT INTO `engmn_games` (`id`, `user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `bot`) VALUES (NULL, '0', '$logbot', '$rand_bot_number', '$rand_bot_cel', '$rand_bot_bet', '$rand_bot_per', '$rand_bot_type_game', '$rand_bot_sum', '1');";
  mysql_query($bot);
  }
}
 // если бот ставит на больше 
if($rand_bot_type_select == 1) {
$rand_bot_win_num = 1000000 - ($rand_bot_per * 10000);
if($rand_bot_number < $rand_bot_win_num) {
  $rand_bot_type_game = "lose"; // бот проиграл
  $rand_bot_sum = "-" . $rand_bot_bet;
  $rand_bot_cel = "$rand_bot_win_num - 999999";
  $bot = "INSERT INTO `engmn_games` (`id`, `user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `bot`) VALUES (NULL, '0', '$logbot', '$rand_bot_number', '$rand_bot_cel', '$rand_bot_bet', '$rand_bot_per', '$rand_bot_type_game', '$rand_bot_sum', '1');";
  mysql_query($bot);
  }
  if($rand_bot_number > $rand_bot_win_num) { // бот выиграл
  $rand_bot_type_game = "win"; // бот выиграл
  $rand_bot_sum = "+" . round(((100 / $rand_bot_per) * $rand_bot_bet), 2);
  $rand_bot_cel = "$rand_bot_win_num - 999999";
  $bot = "INSERT INTO `engmn_games` (`id`, `user_id`, `login`, `number`, `cel`, `sum`, `chance`, `type`, `win_summa`, `bot`) VALUES (NULL, '0', '$logbot', '$rand_bot_number', '$rand_bot_cel', '$rand_bot_bet', '$rand_bot_per', '$rand_bot_type_game', '$rand_bot_sum', '1');";
  mysql_query($bot);
  }
}
}
}
?>