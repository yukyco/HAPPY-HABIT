<?php echo"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>ギャラリー一覧</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
</head>
<body>

<!-- ▽▽▽　任意のページへ埋め込み時表示したい場所へコピペここから　▽▽▽ -->
<?php
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(START)
//----------------------------------------------------------------------
include_once("../gallery/config.php");//設定ファイルインクルード
$img_updir = "../gallery/upimg";//画像の保存先相対パス
$pagelength = 10;//1ページあたりの画像表示数
$pagerDispLength = 3;//ページングの表示数 奇数のみ。現在見ているページ番号の前後に均等数のナビを表示するため

//埋め込み設置するページの文字コード
//Shift-jisは「SJIS」、EUC-JPは「EUC-JP」と指定してください。デフォルトはUTF-8。
$encodingType = 'UTF-8';

//※ガラケーは実機での表示確認は行っておりませんのでご了承下さい。
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(END)
//----------------------------------------------------------------------

$lines = newsListSortUser(file($file_path),$copyright);//ファイル内容を取得
if(!function_exists('PHPkoubou')){ echo $warningMesse; exit;}else{
$pager = pagerOut($lines,$pagelength,$pagerDispLength,'mb');//ページャーを起動する
$pager_dsp = '<div style="text-align:right">'.$pager['pager_res'].'</div><hr />'."\n";
echo $pager_dsp;//ページャー表示
for($i = $pager['index']; ($i-$pager['index']) < $pagelength; $i++){
  if(!empty($lines[$i])){
	$lines_array[$i] = explode(",",$lines[$i]);
	$lines_array[$i][3] = rtrim($lines_array[$i][3]);
	$lines_array[$i][1] = ymd2format($lines_array[$i][1]);//日付フォーマットの適用
	if($encodingType!='UTF-8') $lines_array[$i][1]=mb_convert_encoding($lines_array[$i][1],"$encodingType",'UTF-8');
	if($encodingType!='UTF-8') $lines_array[$i][2]=mb_convert_encoding($lines_array[$i][2],"$encodingType",'UTF-8');
	$alt_text = str_replace('<br />','',$lines_array[$i][2]);
		
//ギャラリー表示部（HTML部は自由に変更可）※デフォルトはサムネイルを表示。imgタグの「 thumb_ 」を取れば元画像を表示
echo <<<EOF

<div><a href="{$img_updir}/{$lines_array[$i][0]}.{$lines_array[$i][3]}" title="{$lines_array[$i][2]}"><img src="{$img_updir}/thumb_{$lines_array[$i][0]}.{$lines_array[$i][3]}" alt="{$alt_text}" width="100" align="left" style="float:left" hspace="5" /></a>
<!-- ▽　日付表示　▽　-->
<span style="font-size:small"><font size="2">{$lines_array[$i][1]} </font></span><br />
<!-- ▽　本文表示　▽　-->
<span style="font-size:small"><font size="2">{$lines_array[$i][2]}</font></span>
</div>
<br clear="all" />
<hr />

EOF;
  }
}
?>
<?php echo $pager_dsp;//ページャー表示 ?>
<?php PHPkoubou($encodingType,$copyright,$warningMesse);}//著作権表記削除不可?>

<!-- △△△　任意のページへ埋め込み時表示したい場所へコピペここまで　△△△ -->

</body>
</html>