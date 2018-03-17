<?php
//----------------------------------------------------------------------
// 　関数定義 (START)　※基本的に変更不可（日本語、htmlタグ部分は可）
//----------------------------------------------------------------------
//ログイン認証
function authAdmin($userid,$password){
	
	$_SESSION['miss_count'] = isset($_SESSION['miss_count']) ? $_SESSION['miss_count'] : 0;
	
	//action先をセット
	//$thisFile = $_SERVER['SCRIPT_NAME'];//2017/5/25無効化（共有SSLでaction先のパスが間違うことがあるためaction先を空にした）
	
	//ログアウト処理
	if(isset($_GET['logout'])){
		$_SESSION = array();
		session_destroy();//セッションを破棄
		
		header("Location: ./");
		exit();
	}
	
	$error = '';
	# セッション変数を初期化
	if (!isset($_SESSION['auth'])) {
	  $_SESSION['auth'] = FALSE;
	}
	
	if (isset($_POST['userid']) && isset($_POST['password'])){
	  foreach ($userid as $key => $value) {
		if ($_POST['userid'] === $userid[$key] &&
			$_POST['password'] === $password[$key]) {
		  $oldSid = session_id();
		  session_regenerate_id(TRUE);
		  if (version_compare(PHP_VERSION, '5.1.0', '<')) {
			$path = session_save_path() != '' ? session_save_path() : '/tmp';
			$oldSessionFile = $path . '/sess_' . $oldSid;
			if (file_exists($oldSessionFile)) {
			  unlink($oldSessionFile);
			}
		  }
		  $_SESSION['auth'] = TRUE;
		  $_SESSION['miss_count'] = 0;
		  break;
		}
	  }
	  if ($_SESSION['auth'] === FALSE) {
		  $error = '<div style="text-align:center;color:red">ユーザーIDかパスワードに誤りがあります。</div>';
		  
		  //不正ログインクラック防止処理
		  if(!isset($_SESSION['miss_count']) || !is_num($_SESSION['miss_count'])) exit();
		  
		  $_SESSION['miss_count']++;
		  if($_SESSION['miss_count'] > 10){
			  exit('<p align="center" style="color:#555;line-height:160%;">ログイン認証が連続で失敗したため強制終了しました。パスワードをお忘れですか？<br />設定ファイルconfig.phpで確認下さい。</p>');
		  }
		
		
	  }
	}
	if ($_SESSION['auth'] !== TRUE) {
echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../../../css/snow.css" type="text/css" media="screen">
<title>管理画面ログイン認証</title>

<style>
/*　AuthPageStyle　*/
body#auth{
	margin-top:15px;
        width: 100％;
        height:100%;
        background-color: #dc143c;
        background-image: url('http://jsrun.it/assets/u/i/4/I/ui4IF.png'),
          url('http://jsrun.it/assets/m/f/u/U/mfuUa.png'),
          url('http://jsrun.it/assets/M/z/Z/Y/MzZY8.png');
      -webkit-animation: snow 20s linear infinite;
       animation: snow 20s linear infinite;
     @-webkit-keyframes snow {
       0% {background-position: 0 0, 0 0, 0 0;}
       100% {background-position: 0 500px, 0 300px, 0 400px;}
  }
    @keyframes snow {
       0% {background-position: 0 0, 0 0, 0 0;}
       100% {background-position: 0 500px, 0 300px, 0 400px;}
    }
}



body#auth #login_form{
        display:block;
	width:227px;
	height:366px;
	background-color: orange;
	margin:45px auto;
        border: 1px none #fff;
        border-radius: 10px;
        box-shadow: 0 0px 7px ;
        font-weight: normal;
        padding: 96px 96px 20px;
	color:none;
	line-height:1.3;
	font-size:90%; 
}

body#auth form .input {
    font-size: 20px;
    margin: 10px 4px 10px 0;
    padding: 3px;
    width: 97%;
}
body#auth input[type="text"], body#auth input[type="password"], body#auth input[type="file"], body#auth input[type="button"], body#auth input[type="submit"], body#auth input[type="reset"] {
    background-color: #faf0e6;
    border: 1px none ;
}
body#auth .button-primary {    
     display: block;  
     cursor: pointer;
     font-size: 12px;
     padding: 3px 10px;
     width:150px;
     height:32px;
     padding:  0.3em 1em;
     text-decoration: none;
     color: #000;
     border: solid 2px #ffe4e1;
     border-radius: 7px;
     transition: .4s;
}
.taC{
    padding: 0.5em 1em;
    margin: 0.3em 0;
    font-weight: bold;
    color: #6091d3;/*文字色*/
    background: #FFF;
    border: solid 3px #6091d3;/*線*/
    border-radius: 10px;/*角の丸み*/
}
.taC p {
    margin: 0; 
    padding: 0;
    text-align:center
}

.BacA {
    padding: 0.5em 1em;
    margin: 6.3em 0;
    font-weight: bold;
    color: #fff;
    background: #6091d3;
    border: solid 1px #FFF;/*線*/
    border-radius: 10px;/*角の丸み*/
    }
a:link {
  color:#cd5c5c;
  text-decoration: none;
}
a:visited {
  color:#fff;
  text-decoration: none;
}

</style>
</head>
<body id="auth">{$error}
<div id="login_form">
<p class="taC"> Welcome to Art Box Standard <br />You are the best !</p>
<form action="" method="post">
<label for="userid">ユーザーID</label>
<input class="input" type="text" name="userid" id="userid" value="" style="ime-mode:disabled" />
<label for="password">パスワード</label>      
<input class="input" type="password" name="password" id="password" value="" size="30" />
<p class="taC">
<input class="button-primary" type="submit" name="login_submit" value="　ログイン　" />
</p>
</form>
<p>Forgot Password ?</p>
<a href="../../../new-password.html">Reset your E-mail !</a>

<p class="BacA">
  <a href="../../../index.html">Back to Top
</p>
</div>
</body>
</html>
EOF;
exit();
	}
}
//登録日プルダウン
function registYmdList($up_ymd = ''){
	
	$up_ymd_array = array();
	if(!empty($up_ymd)){
		$up_ymd_array = explode("-",$up_ymd);
	}

	$start = date('Y') -10;
	$end = date('Y') +1;
	?>
    <select name="data[up_y]">
	<?php for($i=$start;$i <= $end;$i++){ ?>
	<?php if((isset($_POST['data']['up_y']) && $i == $_POST['data']['up_y']) || (!empty($up_ymd_array[0]) && $up_ymd_array[0] == $i) ){ ?>
	<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
	<?php }elseif(!isset($_POST['data']['up_y']) && $i == date('Y') && empty($up_ymd)){ ?>
	<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
    <?php }else{ ?>
	<option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php } ?>
	<?php } ?>
	</select>
	
    <?php	
	$start = 1;
	$end = 12;
	?>
    <select name="data[up_m]">
	<?php for($i=$start;$i <= $end;$i++){ ?>
	<?php if((isset($_POST['data']['up_m']) && $i == $_POST['data']['up_m']) || (!empty($up_ymd_array[1]) && $up_ymd_array[1] == $i) ){ ?>
	<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
	<?php }elseif(!isset($_POST['data']['up_m']) && $i == date('n') && empty($up_ymd)){ ?>
	<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
    <?php }else{ ?>
	<option value="<?php echo $i;?>"><?php echo $i;?></option>
    <?php } ?>
	<?php } ?>
	</select>
    
    
    <?php	
	$start = 1;
	$end = 31;
	?>
    <select name="data[up_d]">
	<?php for($i=$start;$i <= $end;$i++){ ?>
	<?php if((isset($_POST['data']['up_d']) && $i == $_POST['data']['up_d']) || (!empty($up_ymd_array[2]) && $up_ymd_array[2] == $i) ){ ?>
	<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
	<?php }elseif(!isset($_POST['data']['up_d']) && $i == date('j') && empty($up_ymd)){ ?>
	<option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
    <?php }else{ ?>
 	<option value="<?php echo $i;?>"><?php echo $i;?></option>
	<?php } ?>
	<?php } ?>
	</select>

<?php
}
function cffRs2gu($warningMesse02,$cfilePath){
	if(filesize($cfilePath) != 415 && filesize($cfilePath) != 410 && filesize($cfilePath) != 122 && filesize($cfilePath) != 117) exit($warningMesse02);//ASCIIモードでの転送にも対応
}
cffRs2gu($warningMesse02,$cfilePath);
//バックアップ生成
function backup_gen($file_path){
	global $backupDataDir;
	
	$file_path_array = explode("/",$file_path);
	$fileName = end($file_path_array);
	
	$backup_file_name = $backupDataDir."/backup".date('YmdHis')."_".$fileName;
	if(!copy($file_path,$backup_file_name)){
		
	}else{
		@chmod($backup_file_name, 0666);
	}
}
//バックアップ削除
function backup_del($file_path){
	global $del_month,$backupDataDir;
	$res_dir = opendir( $backupDataDir );//ディレクトリ・ハンドルをオープン
	
	$file_path_array = explode("/",$file_path);
	$fileName = end($file_path_array);
	
	//ディレクトリ内のファイル名を取得
	while( $getFileNname = readdir( $res_dir ) ){
		
		if(strpos($getFileNname,"backup") !== false && strpos($getFileNname,$fileName) !== false){
			
			//取得したファイル名を表示
			$fileName2 = str_replace(array($fileName,'backup','_'),'',$getFileNname);
			
			//指定日以前のファイルを削除
			if( strtotime($fileName2) < strtotime(date("YmdHis",strtotime("-{$del_month} month"))) ){
				unlink("{$backupDataDir}/{$getFileNname}");
			}
		}
	}
	closedir( $res_dir );
}
//登録文字のエスケープ
function strToCommonReplace($str){
	$str = str_replace(array("\n","\r",","),array("","","__kanma__"),$str);
	if (get_magic_quotes_gpc()) $str = stripslashes($str);
	return $str;
	
}
//ニュースリストの並び順（日付順）管理画面用
function listSortAdmin($lines){
	$jj = 0;
	$index=array();
	$index2=array();
	foreach($lines as $val){
		$lines_array = explode(",",$val);
		$index[] = strtotime($lines_array[1]);
		$index2[] = $jj++;
	}
	array_multisort($index,SORT_DESC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$lines);
	return $lines;
}
//brタグを改行コードに変換
function brToBrcode($str){
	return str_replace(array("\n","\r","<br>","<br />"),array("","","\n","\n"),$str);
}
//AUTO INCREMENT
function getAutoIncreNum($file_path){
	$lines = file($file_path);
	if(count($lines) < 1){
		$nextID = 1;
	}else{
		$numArr = array();
		foreach($lines as $val){
			$linesArr = explode(',',$val);
			$numArr[] = $linesArr[0];
		}
		$nextID = max($numArr) + 1;
		
		//念のため重複ID無いかチェック　あったらマジやばいのでｗ
		if(in_array($nextID,$numArr)) exit('ID重複エラー');
	}
	return $nextID;
}

//----------------------------------------------------------------------
// 　関数定義 (END)
//----------------------------------------------------------------------
?>
