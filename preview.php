<?php
/**
* version 3.3
*/

require "proc.php";

//メッセージを受け取る
$name=$_GET['name'];
$mes=$_GET['message'];

//エラー処理
$err=echeck($name,$mes);

if($err==NULL){
	$prv=outpt($name,daytime(),$mes);
}else{
	$prv=$err;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
  <script type="text/javascript"
src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
  <link rel="stylesheet" href="http://yuyanagi.html.xdomain.jp/mystyles.css">
</head>
<!-- <body class="body1"> -->
<body>

<!--プレビュー出力-->
<?php echo $prv; ?>

</body>
</html>
