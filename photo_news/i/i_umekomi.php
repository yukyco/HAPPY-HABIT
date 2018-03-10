<?php echo"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>新着情報、お知らせ</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
</head>
<body>

<!--▼▼トップページ埋め込み時はここから以下をコピーして任意の場所に貼り付けてください（html部は編集可）▼▼-->
<div id="news_wrap">
<?php 
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(START)
//----------------------------------------------------------------------
//設定ファイルインクルード（相対パス）※設置箇所が変わる場合は変更して下さい
include_once("../photo_news/config.php");
//このページの文字コード。Shift-jisは「SJIS」、EUC-JPは「EUC-JP」と指定してください。デフォルトはUTF-8。
$encodingType = 'UTF-8';
//データファイル（news.dat）の相対パス ※設置箇所が変わる場合は変更して下さい
$file_path = '../photo_news/data/news.dat';
//記事詳細ページの相対パス（このファイルから見たdetail.phpのパス）
$post_path = 'detail.php';
//表示件数（ニュースの表示数）
$news_dsp_count = 100;
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
	  $title = title_format($lines_array[3],$lines_array[2],$lines_array[0],$post_path,'mb');//タイトルのフォーマットの適用
	  
	  //NEWマーク表示処理　※タグ部変更可。画像でももちOK（さらに下にある「{$new_mark}」を移動すれば表示場所を変えられます）
	  if($new_mark = new_mark_func($lines_array[1],'<span style="color:red;font-size:xx-small;" class="new_mark"> NEW !</span>'));
		
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
・<span style="font-size:small"><font size="2">{$upymd}  <br />{$title} {$new_mark}</font></span><br />

EOF;

}	
?>
<?php echo copyright_dsp($encodingType,$copyright); }//著作権表記削除不可?>
</div>
<!--▲▲トップページ埋め込み時　コピーここまで▲▲-->

</body>
</html>