<?php //▼▼ 既存ページヘ埋め込み時はまるっとコピペ下さい （この行も含みページ最上部に）※.phpでかつUTF-8のページのみ可▼▼
//※このページに対して既存のページのhtmlを記述する形でももちろんOKです。
//----------------------------------------------------------------------
// 【スマホ用】トップページ表示用ページ（パスやリンク設定（全体を囲む）、CSSの一部を除き基本的にはPCとほぼ同じです）
// 設定ファイルの読み込みとページ独自設定
//----------------------------------------------------------------------
include_once("../pkobo_news/admin/include/config.php");//（必要に応じてパスは適宜変更下さい）
$img_updir = '../pkobo_news/upload';//画像保存パス（必要に応じてパスは適宜変更下さい）
$config['popupFlag'] = $config['popupFlagSP'];

/* ▽オプション設定▽ */

//表示件数
$config['dspNum'] = 10;

//本文の抜粋を表示するかどうか（0=しない、1=する）
$commentDsp = 1;

//本文を抜粋表示する場合の表示文字数 （単位はバイト。全角文字は「2バイト」で1文字となります。また末尾の文字「...」も含みます）
//※htmlタグは削除されます「0」にすれば全文をhtmlもそのままで表示します。（レイアウトに問題が出る可能性があるのでオススメしません）
$commentNum = 100;

//サムネイルを表示するか（0=しない、1=する）※アップファイルの1枚目が画像の場合のみ有効
$dspThumbNail = 1;

//表示するカテゴリを指定（指定なし（空）の場合は全件表示 ※デフォルト）
//このページで特定カテゴリのみ表示したい場合、0からの番号を指定下さい。 （1番目が0，2番目が1になるので注意）
//要するに複数のカテゴリがある場合でそれぞれ別々のファイルで表示したい場合用です
//このファイルを複製すればOKです（カテゴリごとにデザインを変えたい場合など）
//例　$category = '1'; ※この場合カテゴリ番号「1」（設定ファイルでの2番目）の記事のみが表示されます
$category = '';
//またはURLのパラメータでも指定可能です。番号ルールは↑と同じです。例　URLに ?cat=0 や ?cat=1 を追加するだけです
//1ファイルでパラメータを変えるだけでそれぞれのカテゴリを表示できるので便利です。（全カテゴリでデザインは共通で良い場合）

//----------------------------------------------------------------------
// 設定ファイルの読み込みとページ独自設定
//----------------------------------------------------------------------
//▲▲ コピペここまで ▲▲（この行も含む）?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>トップページの新着情報、お知らせ</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">

<!--▼▼CSSとポップアップ用JS。トップページ埋め込み時　要コピペ（head部分）▼▼-->
<style type="text/css">
/* CSSは必要最低限しか指定してませんのでお好みで（もちろん外部化OK） */

/* clearfix */
.clearfix:after { content:"."; display:block; clear:both; height:0; visibility:hidden; }
.clearfix { display:inline-block; }

/* for macIE \*/
* html .clearfix { height:1%; }
.clearfix { display:block; }

ul#newsList{
	margin:0 0 15px;
	padding:0;
	font-family:"メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
}
ul#newsList li{
	color:#666;
	font-size:11px;
	margin:0;
	padding:5px 0;
	margin-bottom:3px;
	border-bottom:1px dotted #ccc;
	line-height:120%;
	list-style-type:none;
}
a{color:#36F;text-decoration:underline;}
a:hover{color:#039;text-decoration:none;}

.catName{
	display:inline-block;
	padding:3px 8px;
	border:1px solid #ccc;
	border-radius:6px;
	font-size:11px;
	line-height:100%;
	margin:0 2px;
}
.newMark{
	display:inline-block;
	border:1px solid #F00;
	padding:1px 4px;
	font-size:11px;
	line-height:100%;
	background:#F00;
	color:#fff;
	box-shadow:1px 1px 1px #999;
	border-radius:8px;
	font-style:italic;
}
.comment{
	display:block;
	padding:3px 0;
	float:left;
	overflow:hidden;
	width:60%;
}
.thumbNailWrap{
	display:block;
	width:75px;
	float:left;
	overflow:hidden;
}
.linkTag,.title{
	display:block;
	margin:3px 0;
}
</style>

<script type="text/javascript">
<!--
function openwin(url) {//詳細ページ用ポップアップ。ウインドウの幅、高さなど自由に編集できます（ポップアップで開く場合のみコピペ下さい）
 wn = window.open(url, 'win','width=680,height=550,status=no,location=no,scrollbars=yes,directories=no,menubar=no,resizable=no,toolbar=no');wn.focus();
}
-->
</script>
<!--▲▲CSSとポップアップ用JS。トップページ埋め込み時　要コピペ（head部分）▲▲-->

</head>
<body>

<!--▼▼トップページ埋め込み時はここから以下をコピーして任意の場所に貼り付けてください（html部は編集可）▼▼-->
<div id="newsWrap">
<ul id="newsList">

<?php if(!$copyright){echo $warningMesse;exit;}else{$getFormatDataArr = getLines2DspData($file_path,$img_updir,$config,'',$category);foreach($getFormatDataArr as $key => $data){?>

<li id="postID_<?php echo $data['id'];?>" class="cat-<?php echo $data['categoryNum'];?> clearfix">
<span class="up_ymd"><?php echo $data['up_ymd'];//日付表示?></span>
<?php if(!empty($data['category'])) echo '<span class="catName">'.$data['category'].'</span>';//カテゴリ名表示?>
<?php if($data['newmark'] == 1) echo ' <span class="newMark">New!</span>';//New表示。タグ変更可（表示期間は設定ファイルで）?>

<?php if($link = getHrefLink($data['title'])) echo $link;//スマホの場合はリンクタグで全体を囲む?>

<span class="title"><?php echo $data['title_text'];//タイトル表示?></span>

<!--　サムネイルと本文表示（不要な場合削除OK）-->
<?php if(dspThumb($data) || ($commentDsp == 1 && !empty($data['comment'][0]))){ ?> 
<div class="clearfix">
<span class="thumbNailWrap"><?php echo (dspThumb($data)) ? dspThumb($data,100) : '　';//サムネイル表示（数字は表示幅）サムネイルが無い場合には空白を入れておく（NoPhotoなどのimg画像でもOKです）?></span>
<span class="comment"><?php if($commentDsp == 1) echo str2Format($data['comment'],$commentNum,$config['encodingType']);//本文抜粋表示。表示する設定の場合のみ?></span>
</div>
<?php } ?>
<!--　/サムネイルと本文表示（不要な場合削除OK）-->

<?php if($link) echo '</a>';//スマホの場合はリンクタグで全体を囲む（終了タグ）?>

</li>

<?php } ?>
</ul>
</div>
<?php echo $copyright;}//著作権表記削除不可?>

<!--▲▲トップページ埋め込み時　コピーここまで▲▲-->

</body>
</html>