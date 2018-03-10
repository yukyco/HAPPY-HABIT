<?php
$img_tmp = $_FILES["img_path"]["tmp_name"];
$img_name = $_FILES["img_path"]["name"];
$img_size = $_FILES["img_path"]["size"];
if($_REQUEST["up"] != ""){
if($img_tmp != "" and $img_size <= 100000){
$img_message = "名前は： $img_name <br>サイズは： $img_size <br>MIMEタイプは： $img_type <br>一時的に保存されているパスは： $img_tmp <br>";
$FilePath = "../img/".date("Ymdhis").".".GetExt($img_name);
move_uploaded_file($img_tmp,$FilePath);
$fp = fopen("../img/data.txt","a");
fputs($fp,$FilePath."\n");
fclose($fp);
}else{
$size_error = "サイズが大きすぎます。ファイルサイズは100キロバイト以下です。";

}
}
// GetExt
// ファイルの拡張子を取得します。
function GetExt($FilePath){
$f=strrev($FilePath);
$ext=substr($f,0,strpos($f,"."));
return strrev($ext);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Adminaritst " content="Adminaritst  Community | Post your daily news">
    <meta name="Yukyco" content="Adminaritst ">
    <title>Art Box | Login</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap responsive -->
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    <!-- Font awesome - iconic font with IE7 support --> 
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/font-awesome-ie7.css" rel="stylesheet">
    <!-- Bootbusiness theme -->
	<link href="../css/style-business.css" rel="stylesheet">
	<link rel="shortcut icon" href="img/favicon.ico">	
  </head>
  <body>
    <!-- Start: HEADER -->
    <header>
      <!-- Start: Navigation wrapper -->
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a href="../index.html" class="brand brand-bootbus">Art Box</a>
            <!-- Below button used for responsive navigation -->
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- Start: Primary navigation -->
             <div class="nav-collapse collapse">        
              <ul class="nav pull-right">
               <li class="dropdown">
                  <a href="#" class="dropdown-toggle active-link" data-toggle="dropdown">Home</a>
                </li>    
                </li>
                 <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li class="nav-header">Products</li>
                    <li><a href="online-shop.html">iPhone Case</a></li>
                  </ul>                  
                </li>
                <li class="dropdown">
                  <a href="admin/" class="dropdown-toggle" data-toggle="dropdown">Blog</a>
                </li>
                <li><a href="login.php">Log in</a></li>
              </ul>
            </div>
           </div>
        </div>
      </div>
      <!-- End: Navigation wrapper -->  
    </header>
    <!-- End: HEADER -->
  <body>
 <!-- Start: MAIN CONTENT -->
    <div class="content">
      <div class="container">
        <div class="page-header">
          <h5>Create Your Photo Space</h5>
            <h3>Your Picture</h3>
           <font color="#FF0000"><strong><?= $size_error ?></strong></font><?= $img_message ?> 
           <form name="form" action="<?php print $_SERVER['PHP_SELF']; ?>" method="POST"
ENCTYPE="MULTIPART/FORM-DATA">
	   <label for="file_photo">
	    ＋写真を選択
           <input type="file" name="img_path" style="display:none;"></label><input class="square_btn" name="up" type="submit" value="アップロード"><hr>
         <table border="0">
       <tr>
     <?php
       $array_img = file("../img/data.txt");
       for($i=1; $i<sizeof($array_img); $i++){
       $array_img[$i] = ereg_replace("\n","",$array_img[$i]);
       print "<td style=\"border:1px solid #000000\"><img src=\"$array_img[$i]\" width=\"150\" height=\"150\"></td>";
       }
      ?>

</tr>
</table>
</form>
 <div class="logout">
     <ul>
      <li><a class="button" href="../logout.php">ログアウト</a></li>
     </ul>
   </div>
 </div>
 </div>
    <!-- Start: FOOTER -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="span2">
            <h4><i class="icon-star icon-white"></i> Products</h4>
            <nav>
              <ul class="quick-links">
                <li><a href="online-shop.html">iPhone Case</a></li>
                <li><a href="online-sellfy.html">Yukyco's works </a></li>
              </ul>
            </nav>
          </div>
          <div class="span2">
            <h4><i class="icon-beaker icon-white"></i>About</h4>
            <nav>
              <ul class="quick-links">
                <li><a href="partnerships.html">Partnerships</a></li>
              <ul>
            </nav>
             <h4><i class="icon-thumbs-up icon-white"></i>Contact</h4>
            <nav>
              <ul class="quick-links">
              <a href="contact_us.html"><i class="icon-envelope"></i></a>         
              </ul>
            </nav>             
            </div>
          <div class="span2">   
            <h4><i class="icon-legal icon-white"></i> Legal</h4>
            <nav>
              <ul class="quick-links">
                <li><a href="pripoli.html">Privacy Policy</a></li>      
              </ul>
            </nav>            
          </div>
          <div class="span3">
            <h4>Stay in touch</h4>
            <div class="social-icons-row">
              <a href="http://www.twitter.com/smartbeach"><i class="icon-twitter"></i></a>
              <a href="http://www.linkedin.com/profile/view?id=329780403&trk=nav_responsive_tab_profile"><i class="icon-linkedin"></i></a>                                         
		      <a href="https://plus.google.com/u/0/105993846508985575507/posts"><i class="icon-google-plus"></i></a>              
              <a href="https://github.com/yukyco"><i class="icon-github"></i></a>
            </div> 
          </div>      
           <div class="span3">
            <h4>Subscribe</h4>
             <a href="subscribe.html"><img src="../img/btn2.png" width: 230px; alt="Email" / onmouseover="this.src='../img/btn2_ov.png'" onmouseout="this.src='../img/btn2.png'"></a>
          </div>
         </div>
      </div>
      <hr class="footer">
      <div class="container">
        <p>
        <h6>
          &copy; 2015 <a href="#">adminAritst</a> &nbsp;&nbsp;&nbsp;</h6>
      </div>
    </footer>
    <!-- End: FOOTER -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/boot-business.js"></script>
  </body>
</html>