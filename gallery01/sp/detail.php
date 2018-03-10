<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>ギャラリー詳細ページ</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">

<!-- ▽▽▽　埋め込み時以下head部にコピペ ここから　▽▽▽ -->

<style type="text/css">

/*--- CSSは設置ページ合わせて自由に編集ください --*/

/*---------------------------------
	        Base CSS 
---------------------------------*/
body{ 
	margin:0;padding:0;
	color:#555;
}
#gallery_wrap {
	padding:5px;
	font-size:90%;
}
.detail_photo{
	text-align:center;	
}
.detail_photo img{
	max-width:100%;
	height:auto;
}
.detail_title{
	
}
.detail_text{
	
}

.back a{
	margin:10px 3px;
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

<!-- △△△　埋め込み時head部にコピペ ここまで　△△△ -->

</head>
<body>

<!-- ▽▽▽　任意のページへ埋め込み時表示したい場所へコピペここから　▽▽▽ -->
<div id="gallery_wrap">
<?php
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(START)
//----------------------------------------------------------------------
include_once("../gallery/config.php");//設定ファイルインクルード
$img_updir = "../gallery/upimg";//画像の保存先相対パス

//埋め込み設置するページの文字コード
//Shift-jisは「SJIS」、EUC-JPは「EUC-JP」と指定してください。デフォルトはUTF-8。
$encodingType = 'UTF-8';
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(END)
//----------------------------------------------------------------------

if(isset($_GET['id'])) $id = h($_GET['id']);else exit('パラメータが無効です');
if(!$copyright){echo $warningMesse; exit;}else{
$lines = newsListSortUser(file($file_path),$copyright);//ファイル内容を取得

//for($i = 0; $i < $max_i; $i++){
foreach($lines as $linesVal){
	$lines_array = explode(",",$linesVal);
	if($id == $lines_array[0]){
		break;
	}
}
	  
	$lines_array[3] = rtrim($lines_array[3]);
	$lines_array[1] = ymd2format($lines_array[1]);//日付フォーマットの適用
	if($encodingType!='UTF-8') $lines_array[1]=mb_convert_encoding($lines_array[1],"$encodingType",'UTF-8');
	if($encodingType!='UTF-8') $lines_array[2]=mb_convert_encoding($lines_array[2],"$encodingType",'UTF-8');
	$alt_text = str_replace(array('<br />','<br>'),'',$lines_array[2]);
		
//ギャラリー表示部（HTML部は自由に変更可）
echo <<<EOF
<p class="detail_title">{$lines_array[1]}</p>
<p class="detail_text">{$lines_array[2]}</p>
<p class="detail_photo"><img src="{$img_updir}/{$lines_array[0]}.{$lines_array[3]}" alt="{$alt_text}" /></p>

EOF;
?>
<p class="back"><a href="javascript:history.back();">&laquo; 戻る</a></p>
<?php if($encodingType!='UTF-8') $copyright=mb_convert_encoding($copyright,"$encodingType",'UTF-8');echo $copyright;}//著作権表記削除不可?>
</div>

<!-- △△△　任意のページへ埋め込み時表示したい場所へコピペここまで　△△△ -->

</body>
</html>