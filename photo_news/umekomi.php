<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新着情報、お知らせ</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />

<!--▼▼CSSとPCポップアップ用JS。PCのトップページ埋め込み時　要コピペ（head部分）CSSはお好みで自由に編集してください▼▼-->
<style type="text/css">
/* CSSはお好みで */
li{
	color:#666;
	font-size:14px;
	margin:0;padding:0;
	padding-bottom:2px;
	margin-bottom:3px;
	border-bottom:1px dotted #ccc;
	line-height:120%;
}
ul{
	margin:0 0 15px;
	padding:0;
}
a{color:#36F;text-decoration:underline;}
a:hover{color:#039;text-decoration:none;}
</style>

<script type="text/javascript">
<!--
function openwin(url) {//PC用ポップアップ。ウインドウの幅、高さなど自由に編集できます
 wn = window.open(url, 'win','width=520,height=500,status=no,location=no,scrollbars=yes,directories=no,menubar=no,resizable=no,toolbar=no');wn.focus();
}
-->
</script>
<!--▲▲CSSとPCポップアップ用JS。PCのトップページ埋め込み時　要コピペ（head部分）▲▲-->

</head>
<body>

<!--▼▼トップページ埋め込み時はここから以下をコピーして任意の場所に貼り付けてください（html部は編集可）▼▼-->
<div id="news_wrap">
<ul id="news_list">
<?php 
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(START)
//----------------------------------------------------------------------

//設定ファイルインクルード（相対パス）※設置箇所が変わる場合は変更して下さい
include_once("photo_news/config.php");
//このページの文字コード。Shift-jisは「SJIS」、EUC-JPは「EUC-JP」と指定。デフォルトはUTF-8。
$encodingType = 'UTF-8';
//データファイル（news.dat）の相対パス ※設置箇所が変わる場合は変更して下さい
$file_path = 'photo_news/data/news.dat';
//ポップアップの相対パス（このファイルから見たpopup.phpのパス）※設置箇所が変わる場合は変更して下さい
$post_path = 'photo_news/popup.php';

//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(END)
//----------------------------------------------------------------------

if(!$copyright){echo $warningMesse; exit;}else{
//ファイルの内容を取得　表示
$lines = newsListSortUser(file($file_path),$encodingType);
foreach($lines as $key => $val){
	if($key >= $news_dsp_count) break;
	  $lines_array = explode(",",$val);
	  $upymd = ymd2format($lines_array[1],$encodingType);//日付フォーマットの適用
	  $lines_array[3] = rtrim($lines_array[3]);
	  $title = title_format($lines_array[3],$lines_array[2],$lines_array[0],$post_path);//タイトルのフォーマットの適用

	  //NEWマーク表示処理　※タグ部変更可。画像でももちOK（さらに下にある「{$new_mark}」を移動すれば表示場所を変えられます）
	  if($new_mark = new_mark_func($lines_array[1],'<span style="color:red;font-size:12px;" class="new_mark"> NEW !</span>'));
		
//ブラウザ出力
echo <<<EOF
<li><span class="news_List_Ymd">{$upymd} </span> <span class="news_List_Title">{$title} </span>{$new_mark}</li>

EOF;
}	
?>
</ul>
<?php echo copyright_dsp($encodingType,$copyright); }//著作権表記削除不可?>
</div>
<!--▲▲トップページ埋め込み時　コピーここまで▲▲-->

</body>
</html>