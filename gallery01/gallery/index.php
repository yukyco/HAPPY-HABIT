<?php
#######################################################################################
##
#  PHP画像ギャラリー　ver1.0.1 (2014.02.10)
#
#  画像ギャラリーのプログラムです。
#　任意のページに埋め込みギャラリーページとして運用できます。
#  改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
##
#######################################################################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ギャラリー一覧</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="js/lightbox/jquery.lightbox-0.5.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>   
<script type="text/javascript" src="js/lightbox/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript">
<!--
function openwin(url) {//PC用ポップアップ。ウインドウの幅、高さなど自由に編集できます
 wn = window.open(url, 'win','width=700,height=600,status=no,location=no,scrollbars=yes,directories=no,menubar=no,resizable=no,toolbar=no');wn.focus();
}
-->
</script>

</head>
<body id="index">
<?php
//設定ファイルインクルード
include_once("config.php");
$lines = newsListSortUser(file($file_path),$copyright);
if(!function_exists('PHPkoubou')){ echo $warningMesse; exit;}else{
$pager = pagerOut($lines,$pagelength,$pagerDispLength);//ページャーを起動する
?>
<div id="gallery_wrap">
<div class="pager_link"><?php echo $pager['pager_res'];?></div>
<ul id="gallery_list" class="clearfix">
<?php
for($i = $pager['index']; ($i-$pager['index']) < $pagelength; $i++){
  if(!empty($lines[$i])){
	$lines_array[$i] = explode(",",$lines[$i]);
	$lines_array[$i][1] = ymd2format($lines_array[$i][1]);//日付フォーマットの適用
	$lines_array[$i][3] = rtrim($lines_array[$i][3]);
	$alt_text = str_replace('<br />','',$lines_array[$i][2]);
		
//ギャラリー表示部（HTML部は自由に変更可）※デフォルトはサムネイルを表示。imgタグの「 thumb_ 」を取れば元画像を表示
echo <<<EOF
<li>{$lines_array[$i][1]} <a class="photo" href="javascript:openwin('popup.php?id={$lines_array[$i][0]}')" title="{$lines_array[$i][1]}<br />{$lines_array[$i][2]}"><img src="{$img_updir}/thumb_{$lines_array[$i][0]}.{$lines_array[$i][3]}" height="135" alt="{$alt_text}" title="{$alt_text}" /></a>
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
</body>
</html>