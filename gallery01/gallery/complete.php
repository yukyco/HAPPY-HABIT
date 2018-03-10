<?php
#設定ファイルインクルード
require_once('./config.php');
$getMode = '';
if(!empty($_GET['mode'])){
	$getMode = h($_GET['mode']);
}
$getpage = '';
if(!empty($_GET['page'])){
	$getpage = h($_GET['page']);
}

if($getMode == 'registComp'){
	header("Location: ./admin.php?mode=registComp&page={$getpage}");
	exit();
}
elseif($getMode == 'editComp'){
	header("Location: ./admin.php?mode=editComp&page={$getpage}");
	exit();
}
