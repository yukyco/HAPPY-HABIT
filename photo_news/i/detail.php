<?php

//既存ページのデザインを反映する場合には必要な箇所のソースを以下のhtmlソース部にただコピペすればOKです
//HTML、CSS、JS部分などは自由に編集可能です。

//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(START)
//----------------------------------------------------------------------

//設定ファイルインクルード
include_once("../photo_news/config.php");
//このページの文字コード。
//Shift-jisは「SJIS」、EUC-JPは「EUC-JP」と指定してください。デフォルトはUTF-8。
$encodingType = 'UTF-8';
//データファイル（news.dat）の相対パス ※設置箇所が変わる場合は変更して下さい
$file_path = '../photo_news/data/news.dat';
//画像の保存先を指定
$img_updir = "../photo_news/upimg";

//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(END)
//----------------------------------------------------------------------

if(!$copyright){echo $warningMesse; exit;}else{
	if(!empty($_GET['id'])){
		$id=$_GET['id'];
	}else{
		exit('パラメータがありません');	
	}
	$lines = newsListSortUser(file($file_path),$encodingType);
	foreach($lines as $key => $val){
	$lines_array = explode(",",$val);
	  if($lines_array[0] == $id){
		  $end_flag = 1;
		  break;
	  }
	}
	if($end_flag != 1) exit('データ取得エラー');
$lines_array[3] = rtrim($lines_array[3]);
$lines_array[1] = ymd2format($lines_array[1],$encodingType);//日付フォーマットの適用
?>
<?php echo"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title><?php	echo $lines_array[2];//記事のタイトルを表示?></title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
</head>
<body>
<?php
//ブラウザ出力（HTML部は編集可）
echo <<<EOF

<div style="font-size:small;color:#369"><font size="2" color="#336699">{$lines_array[2]}</font></div>
<div style="font-size:small;text-align:right;"><font size="2">{$lines_array[1]}</font></div>
<div style="font-size:small"><font size="2">{$lines_array[3]}</font></div>

EOF;
  for($i=0;$i<$photo_count;$i++){
	foreach($extensionTypeList as $extensionVal){
	  if(file_exists("{$img_updir}/{$id}_{$i}.{$extensionVal}")) {
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
<div align="center" style="text-align:center"><img src="{$img_updir}/{$id}_{$i}.{$extensionVal}" vspace="2" width="230" /></div>

EOF;
	  }

//------------------------------------------------------------------------------------------
// 旧バージョン互換用処理　(STSRT)　不要な場合ここから削除可
// ※旧バージョンのデータファイル（news.dat）を使用する場合にのみ処理するので最新版を新規で使う場合には削除可能です
// と言うよりも無駄な処理であり、若干ですが負荷もかかるので、できれば削除してください。
// アップ画像が複数になったことによりファイル名の命名規則が変わったためです。
//------------------------------------------------------------------------------------------
elseif(file_exists("{$img_updir}/{$id}.{$extensionVal}")) {
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
<div align="center" style="text-align:center"><img src="{$img_updir}/{$id}.{$extensionVal}" vspace="2" width="230" /></div>
EOF;
break(2);
}
//------------------------------------------------------------------------------------------
// 　旧バージョン互換用処理 (END) 不要な場合ここまで削除可
//------------------------------------------------------------------------------------------
	  
	}
  }
?>
<br />
<!--<p class="close_btn"><a href="">戻る→</a></p>-->
<?php echo copyright_dsp($encodingType,$copyright); }//著作権表記削除不可?>
</body>
</html>