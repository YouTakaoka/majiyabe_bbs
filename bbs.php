<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>なんでも質問掲示板（バージョン4.1）</title>
  <script type="text/javascript"
src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
  <link rel="stylesheet" href="http://yuyanagi.html.xdomain.jp/mystyles.css">
  <script language="JavaScript"><!--
   function prev(){
	   prevwin.location="preview.php?name="+encodeURIComponent(document.subform.name.value)+"&message="+encodeURIComponent(document.subform.message.value);
	   //プレビューページを呼び出す(GETでプレビュー渡す)
   }
  // --></script>
</head>

<!-- <body class="body1"> -->
<body>
<p>なんでも質問掲示板（セキュアヴァージョン）です。</p>

<form name="subform" action="write.php" method="post">
<!--ボタンを押すとwrite.phpに飛ぶ．フレームの場合は中身だけ変わる-->
なまえ：<input type="text" name="name"><br/>
コメント：<br/>
<textarea name="message" cols="50" rows="5"></textarea><br/>
<!--テキストエリア-->
<input type="button" value="プレビュー" onclick="prev();">
<input type="submit" value="書き込み"><br/>
</form>

<p>数式も書けるよ！書き方は<a href="../tex.html" target="_blank">こちら</a></p>

<!--プレビュー-->
プレビュー<br/>
<iframe src="preview.php?name=なまえ&message=コメント" name="prevwin" width="500" height="200"></iframe>

<hr>
<?php
$BBS_HOME = ".";
$WRITE = "$BBS_HOME/write.php";

require "$BBS_HOME/proc.php";
require "$BBS_HOME/private/db.php";
   
$thread="thread2";
 
// データベースへ接続する
$mysqli = new mysqli( $db_host, $db_user, $db_pass, $db_name );

//接続失敗時の処理
if ($err = $mysqli->connect_error) {
        echo "エラー：データベースへの接続に失敗しました<br>\n";
        echo "$err\n";
	error_log($err);
	exit;
}

$query = "select id,name,daytime,comment from ".$thread;
$res = $mysqli->query($query);

//読み込み失敗時の処理
if (!$res){
	echo "エラー：データの読み込みに失敗しました<br>\n";
	error_log($mysqli->error);
	exit;
}

//データベースからデータを読み込む
	while( $row = $res->fetch_assoc() ){ //fetch_assoc():行に対応する連想配列を返す関数。データがなくなるとNULLを返す。
		$opt = outpt( $row['name'],$row['daytime'],$row['comment'] );
		echo $opt;
	}

// データベースへの接続を閉じる
$mysqli->close();
?>

</body>
</html>
