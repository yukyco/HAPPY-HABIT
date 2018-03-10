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
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title><?php	echo $lines_array[2];//記事のタイトルを表示?></title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<style type="text/css">

/*--- CSSは設置ページ合わせて自由に編集ください --*/

/*---------------------------------
	        Base CSS 
---------------------------------*/
body{ 
	margin:0;padding:0;
	color:#555;
}
h2{
	font-size:14px;
	color:#36F;
}
#wrap {
	padding:5px;
	font-size:90%;
}
.detail_photo{
	text-align:center;
	margin:5px 0;
}
.detail_photo img{
	max-width:100%;
	height:auto;
}
.up_ymd{
	text-align:right;	
}
.back a{
	margin:10px 15px;
	padding:3px 15px;
	border:1px solid #aaa;
	text-decoration:none;
	color:#666;
	font-size:12px;
	border-radius:4px;
}

/*---------------------------------
	       /Base CSS 
---------------------------------*/

</style>
</head>
<body>
<div id="wrap">
<?php
//ブラウザ出力（HTML部は編集可）
echo <<<EOF

<h2>{$lines_array[2]}</h2>
<p class="up_ymd">{$lines_array[1]}</p>
<div id="detailWrap">{$lines_array[3]}</div>

EOF;
  for($i=0;$i<$photo_count;$i++){
	foreach($extensionTypeList as $extensionVal){
	  if(file_exists("{$img_updir}/{$id}_{$i}.{$extensionVal}")) {
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
<div class="detail_photo"><img src="{$img_updir}/{$id}_{$i}.{$extensionVal}" /></div>

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
<div class="detail_photo"><img src="{$img_updir}/{$id}.{$extensionVal}" /></div>
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
<p class="back"><a href="javascript:history.back();">&laquo; 戻る</a></p>
<?php echo copyright_dsp($encodingType,$copyright); }//著作権表記削除不可?>
</div>
</body>
</html>