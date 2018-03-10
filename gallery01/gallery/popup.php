<?php
//設定ファイルインクルード
include_once("config.php");
if(!$copyright){echo $warningMesse; exit;}else{
	if(!empty($_GET['id'])){
		$id=h($_GET['id']);
	}else{
		exit('パラメータがありません');	
	}
	$lines = newsListSortUser(file($file_path),$copyright);
	foreach($lines as $key => $val){
	$lines_array = explode(",",$val);
	  if($lines_array[0] == $id){
		  $end_flag = 1;
		  break;
	  }
	}
	if($end_flag != 1) exit('データ取得エラー');
$lines_array[3] = rtrim($lines_array[3]);
$lines_array[1] = ymd2format($lines_array[1]);//日付フォーマットの適用
$title = str_replace("<br />","",$lines_array[2]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php	echo $title;?></title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body id="popup">
<?php
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
<p class="up_ymd">{$lines_array[1]}</p>
<div id="detailWrap">{$lines_array[2]}</div>
<p class="detailPhoto" align="center"><img src="{$img_updir}/{$lines_array[0]}.{$lines_array[3]}" alt="{$title}" /></p>
EOF;
?>
<br />
<p class="close_btn"><a href="javascript:window.close();">CLOSE</a></p>
<?php echo $copyright;}//著作権表記無断削除不可?>
</body>
</html>