<?php
/**
* version 4.0
*/

//エラー処理
function echeck($name, $mes){
	if($name==NULL){
		$err="エラー：名前が書いてないよ！<br/>\n";
	}elseif($mes==NULL){
		$err="エラー：コメントが書いてないよ！<br/>\n";
	}
	else{
		$err=NULL;
	}
	return $err;
}


//日付と時刻の取得
function daytime(){
	date_default_timezone_set('Asia/Tokyo'); //タイムゾーンの設定
	return date("Y-m-d H:i:s");
}

//アウトプット関数（表示、preview時に必要）
function outpt($name,$daytime,$mes){
	//htmlタグを認識しないように変換
	$name=htmlspecialchars($name);
	$mes=htmlspecialchars($mes);
	
	//改行処理
        $mes = preg_replace('/\n/',"<br>\n",$mes);

	$opt="<table border=1 width='400'><tr><td><b>{$name}</b>({$daytime})</td></tr><tr><td>{$mes}</td></tr></table><br/>\n";
	return $opt;
}
?>