<?php
/**
* version 4.1
* continuous post checking
*/

// Define constants
$BBS_HOME = ".";
$BBS = "$BBS_HOME/bbs.php";
$DIFF = new DateInterval("PT1M"); // post time difference threshold = 1minute
$NOW = new DateTime("now");
$IP_ADDR = $_SERVER["REMOTE_ADDR"];

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

        /* When connection is successful */
        
        /* Check continuous post */
        // Get the ip address of the last post
        $query = "select daytime from ".$thread." where ip_addr = '".$IP_ADDR."' order by daytime desc limit 1;";
        $res = $mysqli->query($query);
        $row = $res->fetch_assoc();
        $last = new DateTime($row['daytime']);

        if($NOW < $last->add($DIFF)){
                die("一分以内の連続した書込みはできません。<br>\n<a href='$BBS'>掲示板にもどる</a>");
        }
        
        // Make query and write database
	$query = "insert into ".$thread." ("
			."name, comment, ip_addr"
			.") values ("
			."'".$mysqli->real_escape_string( $name ) ."',"
			."'".$mysqli->real_escape_string( $mes ) ."',"
			."'".$mysqli->real_escape_string( $IP_ADDR ) ."'"
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