<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ギャラリー一覧</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />


<!-- ▽▽▽　埋め込み時以下head部にコピペ（lightbox、CSS等）ここから（lightboxフォルダも必須）　▽▽▽ -->

<link rel="stylesheet" type="text/css" href="lightbox/jquery.lightbox-0.5.css"/>
<style type="text/css">
/*--- CSSは設置ページ合わせて自由に編集ください --*/
/*---------------------------------
	        Base CSS 
---------------------------------*/
body,ul{ 
	margin:0;padding:0;list-style:none;
}
img{border:0}
/* clearfix(削除不可) */
.clearfix:after { content:"."; display:block; clear:both; height:0; visibility:hidden; }
.clearfix { display:inline-block; }
/* for macIE \*/
* html .clearfix { height:1%; }
.clearfix { display:block; }

#gallery_wrap {
	width:600px;
	margin:0 auto;
}
#gallery_list li{
	width:180px;
	height:150px;
	border:1px solid #ccc;
	float:left;
	margin:0 5px 5px 0;
	overflow:hidden;
	padding:5px;
	text-align:center;
	font-size:12px;
}
#gallery_list a.photo{
	width:180px;
	height:135px;
	margin:0 auto;
	overflow:hidden;
	display:block;
}
/*---------------------------------
	       /Base CSS 
---------------------------------*/

/*---------------------------------
	      Pager style
---------------------------------*/
.pager_link{
	text-align:right;
	padding:10px;
}
/*ページャーボタン*/
.pager_link a {
    border: 1px solid #aaa;
    border-radius: 5px 5px 5px 5px;
    color: #333;
    font-size: 12px;
    padding: 3px 7px 2px;
    text-decoration: none;
	margin:0 1px;
}
/*現在のページ、オーバーボタン*/
.pager_link a.current,.pager_link a:hover{
    background: #999;
    color: #FFFFFF;
}
.overPagerPattern{
	padding:0 2px ;	
}
/*---------------------------------
	      /Pager style
---------------------------------*/
</style>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>   
<script type="text/javascript" src="lightbox/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript">
$(function() {
	$('#gallery_list a.photo').lightBox();//lightbox
});
</script>

<!-- △△△　埋め込み時head部にコピペ（lightbox、CSS等）ここまで　△△△ -->

</head>
<body>

<!-- ▽▽▽　任意のページへ埋め込み時表示したい場所へコピペここから　▽▽▽ -->
<div id="gallery_wrap">
<?php
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(START)
//----------------------------------------------------------------------
include_once("gallery/config.php");//設定ファイルインクルード
$img_updir = "gallery/upimg";//画像の保存先相対パス

//埋め込み設置するページの文字コード
//Shift-jisは「SJIS」、EUC-JPは「EUC-JP」と指定してください。デフォルトはUTF-8。
$encodingType = 'UTF-8';
//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定　※必要に応じて変更下さい(END)
//----------------------------------------------------------------------
	$lines = newsListSortUser(file($file_path),$copyright);//ファイル内容を取得
	if(!function_exists('PHPkoubou')){ echo $warningMesse; exit;}else{
	$pager = pagerOut($lines,$pagelength,$pagerDispLength);//ページャーを起動する
?>
<div class="pager_link"><?php echo $pager['pager_res'];?></div>
<ul id="gallery_list" class="clearfix">
<?php
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
<li>{$lines_array[$i][1]} <a class="photo" href="{$img_updir}/{$lines_array[$i][0]}.{$lines_array[$i][3]}" title="{$lines_array[$i][1]}<br />{$lines_array[$i][2]}"><img src="{$img_updir}/thumb_{$lines_array[$i][0]}.{$lines_array[$i][3]}" alt="{$alt_text}" height="135" title="{$alt_text}" /></a>
<!--本文を表示するにはこのコメントを解除ください<p class="detail_text">{$lines_array[$i][2]}</p>-->
</li>
EOF;
  }
}
?>
</ul>
<div class="pager_link"><?php echo $pager['pager_res'];?></div>
<?php PHPkoubou($encodingType,$copyright,$warningMesse);}//著作権表記削除不可?>
</div>
<!-- △△△　任意のページへ埋め込み時表示したい場所へコピペここまで　△△△ -->

</body>
</html>