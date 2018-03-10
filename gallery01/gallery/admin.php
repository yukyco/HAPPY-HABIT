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

header("Content-Type: text/html;charset=UTF-8");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

#設定ファイルインクルード
require_once('./config.php');
//----------------------------------------------------------------------
//  ログイン処理 (START)
//----------------------------------------------------------------------
session_start();
authAdmin($userid,$password);
//----------------------------------------------------------------------
//  ログイン処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  データ保存用ファイル、画像保存ディレクトリのパーミッションチェック (START)
//----------------------------------------------------------------------
$messe = permissionCheck($file_path,$img_updir,$perm_check01,$perm_check02,$perm_check03);
//----------------------------------------------------------------------
//  データ保存用ファイルのパーミッションチェック (END)
//----------------------------------------------------------------------

//モードを取得
$mode = '';
if(!empty($_GET['mode'])){
	$mode = h($_GET['mode']);
}
//ページャーセット
$pager = pagerOut(file($file_path),$pagelengthAdmin,$pagerDispLength);

//----------------------------------------------------------------------
//  書き込み・編集処理 (START)
//----------------------------------------------------------------------

if ( (isset($_POST['submit']) || isset($_POST['edit_submit']) ) && !isset($_POST['del'])){
	  
	//各記事にユニークなIDを付与　uniqid（PHP3以下）が無ければ年月日時分秒
	$id = generateID();
		
	//----------------------------------------------------------------------
	//  画像縮小保存処理 GD必須 (START)
	//----------------------------------------------------------------------
	
		if(is_uploaded_file($_FILES["upfile"]["tmp_name"])){
			if ($_FILES["upfile"]["size"] < $maxImgSize) {
				$imgType = $_FILES['upfile']['type'];
				if ($imgType == 'image/gif') {
					$extension = 'gif';
					$image = ImageCreateFromGIF($_FILES['upfile']['tmp_name']); //GIFファイルを読み込む
				} else if ($imgType == 'image/png' || $imgType == 'image/x-png') {
					$extension = 'png';
					$image = ImageCreateFromPNG($_FILES['upfile']['tmp_name']); //PNGファイルを読み込む
				} else if ($imgType == 'image/jpeg' || $imgType == 'image/pjpeg') {
					$extension = 'jpg';
					$image = ImageCreateFromJPEG($_FILES['upfile']['tmp_name']); //JPEGファイルを読み込む
				} else if ($extension == '') {
					exit("<center>【許可されていない拡張子です。jpg、gif、pngのいずれかのみです】<br /><br /><a href='admin.php'>戻る&gt;&gt;</a></center>");
				}
					
				if(strpos($id,'no_disp') !== false) {
				  $file_id = str_replace('no_disp','',$id);
				  $filename = $file_id.".".$extension;//ファイル名を指定
				}else{
				  $filename = $id.".".$extension;//ファイル名を指定
				}
				
				//拡張子違いのファイルを削除
				fileDelFunc($img_updir,$id);
				
				$img_file_path = $img_updir.'/'.$filename;//ファイルパスを指定
				$img_file_path_thumb = $img_updir.'/'.'thumb_'.$filename;//サムネイルファイルパスを指定
				  
				//読み込んだ画像のサイズ
				$width = ImageSX($image); //横幅（ピクセル）
				$height = ImageSY($image); //縦幅（ピクセル）
				
				if($width>$imgWidthHeight or $height>$imgWidthHeight){//画像の縦または横が$imgWidthHeightより大きい場合は縮小して保存
					if ($height < $width){//横写真の場合の処理
						$new_width = $imgWidthHeight; //幅指定px
						$rate = $new_width / $width; //縦横比を算出
						$new_height = $rate * $height;
						
						//サムネイル用処理
						$new_width_thumb = $imgWidthHeightThumb;//高さ指定px
						$rate_thumb = $new_width_thumb / $width;//縦横比を算出
						$new_height_thumb = $rate_thumb * $height;
					
					}else{//縦写真の場合の処理
						$new_height = $imgWidthHeight; //高さ指定px
						$rate = $new_height / $height; //縦横比を算出
						$new_width = $rate * $width;
						
						//サムネイル用処理
						$new_height_thumb = $imgWidthHeightThumb; //高さ指定px
						$rate_thumb = $new_height_thumb / $height; //縦横比を算出
						$new_width_thumb = $rate_thumb * $width;
					}
					
					$new_image = ImageCreateTrueColor($new_width, $new_height);
					$new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);//サムネイル作成
					
					ImageCopyResampled($new_image,$image,0,0,0,0,$new_width,$new_height,$width,$height);
					ImageCopyResampled($new_image_thumb,$image,0,0,0,0,$new_width_thumb,$new_height_thumb,$width,$height);//サムネイル作成
				  
					if($imgType == 'image/jpeg' || $imgType == 'image/pjpeg'){
						if(!@is_int($img_quality)) $img_quality = 80;//画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
						ImageJPEG($new_image, $img_file_path, $img_quality); //3つ目の引数はクオリティー（0～100）
						ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); //サムネイル作成
					}
					elseif ($imgType == 'image/gif') {
						ImageGIF($new_image, $img_file_path);//環境によっては使えない
						ImageGIF($new_image_thumb, $img_file_path_thumb);//サムネイル作成
					}
					elseif ($imgType == 'image/png' || $imgType == 'image/x-png') {
						ImagePNG($new_image, $img_file_path);
						ImagePNG($new_image_thumb, $img_file_path_thumb);//サムネイル作成
					}
					  
				  //メモリを解放
				  imagedestroy ($image); //イメージIDの破棄
				  imagedestroy ($new_image); //元イメージIDの破棄
				  imagedestroy ($new_image_thumb); //サムネイル元イメージIDの破棄
				  
					}else{//画像が$imgWidthHeightより小さい場合はそのまま保存
					move_uploaded_file($_FILES['upfile']['tmp_name'],$img_file_path);
					  
						//----------------------------------------------------------------------
						//  サムネイル生成処理  (START)
						//----------------------------------------------------------------------
						if($width>$imgWidthHeightThumb or $height>$imgWidthHeightThumb){//画像の縦または横がサムネイル指定サイズより大きい場合は生成
						  if ($height < $width){//横写真の場合の処理
						  
							  $new_width_thumb = $imgWidthHeightThumb;//高さ指定px
							  $rate_thumb = $new_width_thumb / $width;//縦横比を算出
							  $new_height_thumb = $rate_thumb * $height;
						  
						  }else{//縦写真の場合の処理
						  
							  $new_height_thumb = $imgWidthHeightThumb; //高さ指定px
							  $rate_thumb = $new_height_thumb / $height; //縦横比を算出
							  $new_width_thumb = $rate_thumb * $width;
						  }
						  $new_image_thumb = ImageCreateTrueColor($new_width_thumb, $new_height_thumb);//サムネイル作成
						  ImageCopyResampled($new_image_thumb,$image,0,0,0,0,$new_width_thumb,$new_height_thumb,$width,$height);//サムネイル作成
						  
							if($imgType == 'image/jpeg' || $imgType == 'image/pjpeg'){
								if(!@is_int($img_quality)) $img_quality = 80;//画質に数字以外の無効な文字列が指定されていた場合のデフォルト値
								ImageJPEG($new_image_thumb, $img_file_path_thumb, $img_quality); //サムネイル作成
							}
							elseif($imgType == 'image/gif') {
								ImageGIF($new_image_thumb, $img_file_path_thumb);//サムネイル作成
							}
							elseif($imgType == 'image/png' || $imgType == 'image/x-png') {
								ImagePNG($new_image_thumb, $img_file_path_thumb);//サムネイル作成
							}
						  imagedestroy ($new_image_thumb); //サムネイル元イメージIDの破棄
						}else{
							//サムネイルが設定サイズより小さい場合はそのまま保存
							copy($img_file_path,$img_file_path_thumb);
						}
						//----------------------------------------------------------------------
						//  サムネイル生成処理  (END)
						//----------------------------------------------------------------------
					  
					}
					  @chmod($img_file_path, 0666);
					  @chmod($img_file_path_thumb, 0666);
			
			}else{
			  $maxImgSize = number_format($maxImgSize);
			  exit("<center>【画像がファイルサイズオーバーです。{$maxImgSize}バイト以下にして下さい】<br /><br /><a href='admin.php'>戻る&gt;&gt;</a></center>");
			}
		}
	//----------------------------------------------------------------------
	//  画像縮小保存処理 GD必須 (END)
	//----------------------------------------------------------------------
	  
		$up_ymd=mb_convert_kana($_POST['year'], 'n',"UTF-8")."/".mb_convert_kana($_POST['month'], 'n',"UTF-8")."/".mb_convert_kana($_POST['day'], 'n',"UTF-8");
		$up_ymd = str_replace(",","",$up_ymd);
		if(isset($_POST['title'])){
		  $title = replace_func($_POST['title']);
		}
		
		if($extension == ""){
			$extension = $_POST['extension_type'];
		}
		//並び順。デフォルトは空にする
		$dspno = "";
		if(isset($_POST['dspno'])){
		  $dspno = $_POST['dspno'];
		}
		
		$lines = file($file_path);
		
		$fp = @fopen($file_path, "r+b") or die("fopen Error!!DESUYO--!!!");
		$writeData = $id  . "," .$up_ymd. "," .$title. "," .$extension. ",".$dspno.",". "\n";
		  // 俳他的ロック
		if(flock($fp, LOCK_EX)){
			ftruncate($fp,0);
			rewind($fp);
			// 書き込み
			if (isset($_POST['submit'])){
				fwrite($fp, $writeData);
				if($max_line!='') $max_line --;
			}
			if ($max_line!='' and count($lines) > $max_line) {
				$max_i = $max_line;
			} else {
				$max_i = count($lines);
			}
			for ($i = 0; $i < $max_i; $i++) {
				if (isset($_POST['edit_submit'])){
					$lines_array[$i] = explode(",",$lines[$i]);
					if($lines_array[$i][0] != $id){
						 fwrite($fp, $lines[$i]);
					}else{
						fwrite($fp, $writeData);
					}
				}else{			
					fwrite($fp, $lines[$i]);
				}
			}
		}
	fclose($fp);
	//再送信防止リダイレクト
	if(isset($_POST['submit'])) header("Location: ./complete.php?mode=registComp&page={$pager['pageid']}");
	if(isset($_POST['edit_submit'])) header("Location: ./complete.php?mode=editComp&page={$pager['pageid']}");
	exit();
//----------------------------------------------------------------------
//  書き込み・編集処理 (END)
//----------------------------------------------------------------------
}

//----------------------------------------------------------------------
//  データ削除処理 (START)
//----------------------------------------------------------------------
if(isset($_POST['del'])){
	$messe = delDetaToImg($file_path,$max_line,$img_updir);
}
//----------------------------------------------------------------------
//  データ削除処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  再表示処理 非表示処理 (START)
//----------------------------------------------------------------------
if($mode == 'disp' or $mode == 'no_disp'){
	$messe = dispModeChange($mode,$file_path,$max_line);
}
//----------------------------------------------------------------------
//  再表示処理 非表示処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  並び順変更処理 (START)
//----------------------------------------------------------------------
if(isset($_POST['order_submit'])){
	$messe = orderChange($file_path);
}
//----------------------------------------------------------------------
//  並び順変更処理 (END)
//----------------------------------------------------------------------

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow" />
<title>ギャラリー管理画面</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">
<link rel="stylesheet" type="text/css" href="js/lightbox/jquery.lightbox-0.5.css"/>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>   
<script type="text/javascript" src="//code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/lightbox/jquery.lightbox-0.5.min.js"></script>
</head>
<body id="admin">
<div id="wrapper">
<?php if(!$copyright){ echo $warningMesse; exit;}else{
if(!empty($messe)) echo '<p class="fc_red message_com">'.$messe.'</p>';
$compMesse = compMesse($mode);
if(!empty($compMesse)) echo '<p class="fc_red message_com">'.$compMesse.'</p>';
?>
<div class="logout_btn"><a href="?logout=true">ログアウト</a></div>
<h1>ギャラリー 管理画面</h1>
<h2>画像登録・編集フォーム</h2>
<form method="post" action="admin.php<?php echo "?page={$pager['pageid']}";?>" enctype="multipart/form-data" name="form">
<?php
//----------------------------------------------------------------------
// 　編集フォーム表示処理 (START)
//----------------------------------------------------------------------
if($mode == 'edit'){
	$id = h($_GET['id']);
    $lines = file($file_path);
	foreach($lines as $linesVal){
		$lines_array = explode(",",$linesVal);
		if($lines_array[0] == $id){
			break; 
		}
	}
	$lines_array[3] = rtrim($lines_array[3]);
	$lines_array[2] = str_replace(array("<br />","<br>"),"\n",$lines_array[2]);//改行（<br />）を改行コードに変換
?>
<p style="color:red;font-size:16px;">下記内容を編集後「変更」ボタンを押してください。<a href="admin.php<?php echo "?page={$pager['pageid']}";?>">編集をキャンセル⇒</a></p>

<input type="hidden" name="id" value="<?php echo $id;?>" />
<input type="hidden" name="extension_type" value="<?php echo $lines_array[3];?>" />
<input type="hidden" name="dspno" value="<?php if(!empty($lines_array[4])) echo $lines_array[4];?>" />
<?php if(strpos($id,'no_disp') !== false) $id = str_replace('no_disp','',$id); ?>
<p class="taC target_photo"><a href="<?php echo $img_updir.'/'.$id.'.'.$lines_array[3];?>" class="photo"><img src="<?php echo $img_updir.'/'.$id.'.'.$lines_array[3];?>" height="200" /></a></p>
<?php $up_ymd_array = explode("/",$lines_array[1]);?>
<p>日付：<input type="text" name="year" size="5" maxlength="4" value="<?php echo $up_ymd_array[0];?>" /> 年 <input type="text" name="month" size="2" maxlength="2" value="<?php echo $up_ymd_array[1];?>" /> 月 <input type="text" name="day" size="2" maxlength="2" value="<?php echo $up_ymd_array[2];?>" /> 日　※半角数字のみ</p>

<h3>写真タイトル、説明など（htmlタグ不可） ※未入力も可</h3><p>※画像拡大時、及びaltに反映されます。<br /><textarea name="title" cols="60" rows="3"><?php echo $lines_array[2];?></textarea><br />

<p>■削除チェック　<input type="checkbox" name="del" value="true" /> <span style="font-size:13px;color:#666">※削除する場合はこちらにチェックを入れて「変更」ボタンを押してください。データ（画像データ含む）は完全に削除されます。</span></p>

<h3>■画像アップロード（jpg、gif、pngのみ）</h3><p>※事前に縮小の必要はありません。横写真または縦写真とも設定ファイル（config.php）で設定した幅、または高さに自動縮小されます。現在は<span style="color:red"><?php $imgWidthHeight;?></span>px<br />※日本語ファイル名でも問題ありません。自動で半角英数字にリネームされます。アニメーションgifは不可。
<br />

<input type="file" name="upfile" size="50" /> （MAX 5MB）<br /></p>
<p align="center"><input type="submit" class="submit_btn" name="edit_submit" value="　変更、または削除実行　" /></p>
<?php
//----------------------------------------------------------------------
// 　編集フォーム表示処理 (END)
//----------------------------------------------------------------------
}else{
//----------------------------------------------------------------------
// 　新規登録フォーム表示処理 (START)
//----------------------------------------------------------------------
?>
<p>日付：<input type="text" name="year" size="5" maxlength="4" value="<?php echo @date("Y",time());?>" /> 年 <input type="text" name="month" size="2" maxlength="2" value="<?php echo @date("n",time());?>" /> 月 <input type="text" name="day" size="2" maxlength="2" value="<?php echo @date("j",time());?>" /> 日　※半角数字のみ</p>
<h3>写真タイトル、説明など（htmlタグ不可） </h3><p>※未入力も可　※画像拡大時、及びaltに反映されます。<br /><textarea name="title" cols="60" rows="3"></textarea>
</p>
<h3>画像アップロード（jpg、gif、pngのみ）</h3><p>
※事前に縮小の必要はありません。横写真または縦写真とも設定ファイル（config.php）で設定した幅、または高さに自動縮小されます。現在は<span style="color:red"><?php echo $imgWidthHeight;?></span>px<br />※日本語ファイル名でも問題ありません。自動で半角英数字にリネームされます。アニメーションgifは不可<br />

<input type="file" name="upfile" size="50" /> （MAX 5MB）</p>
<p align="center"><input type="submit" class="submit_btn" name="submit" value="　新規登録　" onclick="return check()"/></p>
<?php
//----------------------------------------------------------------------
// 　新規登録フォーム表示処理 (END)
//----------------------------------------------------------------------
}
?>
</form>
<div class="positionBase">
<h2>登録画像一覧　<?php if($mode == 'img_order') echo '【並び替えモード】';?></h2>
<div id="acrbtn">【取り扱い説明書】</div>
<div id="commentDescription" style="display:none">
<p>※デフォルトは登録順です。「並び替えモード」にて並び順の変更が可能です。ドラッグ＆ドロップし、「並び替えを反映する」ボタンを押して下さい。<br />
※画像の変更が反映されない場合はブラウザのキャッシュが原因です。→のボタンまたはF5キーで更新してください。
<button onclick="f5()">更新する</button>
<br />※アップ画像は幅、または高さが現在サムネイルのサイズとして設定されている<span class="col19"><?php echo $imgWidthHeightThumb;?>px</span>以上である必要があります。（設定ファイルで変更可）
</p>
</div>

<?php if($mode == 'img_order'){//並び替えモード時?>
<div class="orderButton"><a href="?">通常モードへ</a></div>
<?php }else{ ?>
<div class="orderButton"><a href="?mode=img_order">並び替えモードへ</a></div>
<?php } ?>
</div><!-- /positionBase -->
<?php 
$lines = newsListSort(file($file_path));
$max_i = count($lines);
?>
<p class="taR pr10 pt10">[ 登録数：<?php echo $max_i;?> ]</p>
<div id="gallery_wrap">
<?php if($mode != 'img_order') echo '<div class="pager_link">'.$pager['pager_res'].'</div>';//ページャー表示?>

<?php if($mode == 'img_order'){//並び替えモード時?>
<form method="post" action="admin.php?mode=img_order" enctype="multipart/form-data">
<ul id="gallery_list" class="clearfix gallery_list_order">
<?php }else{ ?>
<ul id="gallery_list" class="clearfix">
<?php } ?>

<?php
//----------------------------------------------------------------------
//  リスト表示処理 (START)
//----------------------------------------------------------------------

//並び替えモード時全表示
if($mode == 'img_order'){
	$pager['index'] = 0;
	$pagelengthAdmin = $max_i;
}

for($i = $pager['index']; ($i-$pager['index']) < $pagelengthAdmin; $i++){
	if(!empty($lines[$i])){
		$lines_array[$i] = explode(",",$lines[$i]);
		$id=$lines_array[$i][0];
		$lines_array[$i][3] = rtrim($lines_array[$i][3]);
		$lines_array[$i][1] = ymd2format($lines_array[$i][1]);//日付フォーマットの適用
		$alt_text = str_replace('<br />','',$lines_array[$i][2]);
		
		if(strpos($lines_array[$i][0], 'no_disp') !== false){
			$img_id = str_replace('no_disp','',$lines_array[$i][0]);

echo <<<EOF

<li class="no_disp"> {$lines_array[$i][1]} <a class="photo" href="{$img_updir}/{$img_id}.{$lines_array[$i][3]}" title="{$lines_array[$i][1]}<br />{$lines_array[$i][2]}"><img src="{$img_updir}/thumb_{$img_id}.{$lines_array[$i][3]}" height="75" alt="{$lines_array[$i][2]}" title="{$alt_text}" /></a><a class="button" href="?mode=disp&id={$id}&page={$pager['pageid']}">表示する</a><a class="button" href="?mode=edit&id={$id}&page={$pager['pageid']}">[編集・削除]</a><div class="hidden_text">非表示中</div><input type="hidden" name="sort[]" value="{$id}" /></li>

EOF;
		}else{
echo <<<EOF

<li>{$lines_array[$i][1]}  <a class="photo" href="{$img_updir}/{$id}.{$lines_array[$i][3]}" title="{$lines_array[$i][1]}<br />{$lines_array[$i][2]}"><img src="{$img_updir}/thumb_{$id}.{$lines_array[$i][3]}" alt="{$lines_array[$i][2]}" height="75" title="{$alt_text}" /></a><a class="button" href="?mode=no_disp&id={$id}&page={$pager['pageid']}">非表示にする</a><a class="button" href="?mode=edit&id={$id}&page={$pager['pageid']}">編集・削除</a><input type="hidden" name="sort[]" value="{$id}" /></li>

EOF;
		}
	}
}
//----------------------------------------------------------------------
//  リスト表示処理 (END)
//----------------------------------------------------------------------
?>
</ul>
<?php if($mode == 'img_order'){//並び替えモード時 ?>
<div class="taC mt10"><input type="submit" class="submit_btn" name="order_submit" value="　並び替え反映　" /></div>
</form>
<?php }else{ ?>
<div class="taC mt10"><input type="button" disabled="disabled"  value="並び替えは「並び替えモード」に切り替えて下さい" /></div>
<?php } ?>
<?php if($mode != 'img_order') echo '<div class="pager_link">'.$pager['pager_res'].'</div>';//ページャー表示?>

</div>
<br />
<br />
<?php echo $copyright;}//著作権表記リンク無断削除禁止?>
</div>
</body>
</html>