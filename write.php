<?php
/**
* version 4.0
*/

// Define constants
$BBS_HOME = ".";
$BBS = "$BBS_HOME/bbs.php";

require "$BBS_HOME/proc.php";
require "$BBS_HOME/private/db.php";
$thread="thread2";

//メッセージを受け取る
$name=$_POST['name'];
$mes=$_POST['message'];

//エラー処理
$err=echeck($name,$mes);

if($_SERVER['REQUEST_METHOD']!='POST'){
	die('エラー：不正なアクセスです。');
}else if($err!=NULL){
	die($err.'<br> <a href="'.$BBS.'">掲示板にもどる</a>');
}else{
//--- 正常な場合：データベースへの書き込み ---

	// データベースへ接続する
	$mysqli = new mysqli( $db_host, $db_user, $db_pass, $db_name );

	//接続失敗時の処理
	if ($err = $mysqli->connect_error) {
		echo "エラー：データベースへの接続に失敗しました<br>\n"
			.'<a href="'.$BBS.'">掲示板にもどる</a>';
		error_log($err);
		exit;
	}

	$query = "insert into ".$thread." ("
			."name, comment, ip_addr"
			.") values ("
			."'".$mysqli->real_escape_string( $name ) ."',"
			."'".$mysqli->real_escape_string( $mes ) ."',"
			."'".$mysqli->real_escape_string( $_SERVER["REMOTE_ADDR"] ) ."'"
			.")";
	$res = $mysqli->query($query); //データベースへ書き込み
		
	//書き込み失敗時の処理
	if (!res){
		echo "エラー：データの書き込みに失敗しました<br>\n"
			.'<a href="'.$BBS.'">掲示板にもどる</a>';
		error_log($mysqli->error);
		exit;
	}
	echo "メッセージを書き込みました！<br/>\n";
	echo '<a href="'.$BBS.'">掲示板にもどる</a>';

	// データベースへの接続を閉じる
	$mysqli->close();
}
?>