<?php
  session_start();
  
  // エラーメッセージ
  $errorMessage = "";
  // 画面に表示するため特殊文字をエスケープする
  $viewUserId = htmlspecialchars($_POST["userid"], ENT_QUOTES);

  // ログインボタンが押された場合      
  if (isset($_POST["login"])) {

    // 認証成功
    if ($_POST["userid"] == "admin" && $_POST["password"] == "1111") {
      // セッションIDを新規に発行する
      session_regenerate_id(TRUE);
      $_SESSION["USERID"] = $_POST["userid"];
      header("Location: main.php");
      exit;
    }
    else {
      $errorMessage = "ユーザIDあるいはパスワードに誤りがあります。";
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminAritst Community | Post your daily news">
    <meta name="author" content="YukikoHamabe">
    <title>adminAritst | Login</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap responsive -->
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    <!-- Font awesome - iconic font with IE7 support --> 
    <link href="../css/font-awesome.css" rel="stylesheet">
    <link href="../css/font-awesome-ie7.css" rel="stylesheet">
    <!-- Bootbusiness theme -->
	<link href="../css/style-business.css" rel="stylesheet">
	<link rel="shortcut icon" href="../img/favicon.ico">	
  </head>
  <!-- Start: HEADER -->
    <header>
      <!-- Start: Navigation wrapper -->
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a href="../index.php" class="brand brand-bootbus">adminAritst</a>
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
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">About<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="../our_works.html">Yukyco's Works</a></li>
                    <li><a href="../partnerships.html">Partnerships</a></li>
                  </ul>
                </li>
                 <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li class="nav-header">Products</li>
                    <li><a href="../online-shop.html">iPhone Case</a></li>
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
        <form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">
         <fieldset>
          <legend>メンバーログイン</legend>
           <div><?php echo $errorMessage ?></div>
            <label for="userid">ユーザID</label><input type="text" id="userid" name="userid" value="<?php echo $viewUserId ?>">
            <br>
            <label for="password">パスワード</label><input type="password" id="password" name="password" value="">
            <br>
            <label></label><input type="submit" id="login" name="login" value="ログイン">
         </fieldset>
        </form>
            <div class="span3">
            <ul>
             <a href="../registration.html"><i class="icon-star icon-white"></i> 新規登録</a><br />
             <a href="admin.php"><i class="icon-star icon-white"></i> 管理者ログイン</a>
             </ul>
           </div>
         <div class="campaign">
        <a href="../../cafe/"><img src="http://yukycohamabe.ciao.jp/cafe/images/logo2.png"></a>
        </div>
      </div>
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
                <li><a href="../online-shop.html">iPhone Case</a></li>
                <li><a href="../online-sellfy.html">Friends Area</a></li>
              </ul>
            </nav>
          </div>
          <div class="span2">
            <h4><i class="icon-beaker icon-white"></i> About</h4>
            <nav>
              <ul class="quick-links">
                <li><a href="../partnerships.html">Partnerships</a></li>
              <ul>
            </nav>
             <h4><i class="icon-thumbs-up icon-white"></i> Contact</h4>
            <nav>
              <ul class="quick-links">
              <a href="../contact_us.html"><i class="icon-envelope"></i></a>         
              </ul>
            </nav>             
            </div>
          <div class="span2">   
            <h4><i class="icon-legal icon-white"></i> Legal</h4>
            <nav>
              <ul class="quick-links">
                <li><a href="../pripoli.html">Privacy Policy</a></li>      
              </ul>
            </nav>            
          </div>
          <div class="span3">
            <h4><i class="icon-star icon-white"></i> Stay in touch</h4>
            <div class="social-icons-row">
              <a href="http://www.twitter.com/smartbeach"><i class="icon-twitter"></i></a>
              <a href="http://www.linkedin.com/profile/view?id=329780403&trk=nav_responsive_tab_profile"><i class="icon-linkedin"></i></a>                                         
		      <a href="https://plus.google.com/u/0/105993846508985575507/posts"><i class="icon-google-plus"></i></a>              
              <a href="https://github.com/yukyco"><i class="icon-github"></i></a>
            </div> 
          </div>   
          <div class="span3">
            <h4><i class="icon-star icon-white"></i> Access Counter</h4>
          	<script type="text/javascript" src="http://cc2.i2i.jp/bin/count?00122174&all"></script>
            <noscript><img src="http://cc2.i2i.jp/bin/mcount.x/00122174/all/" border="0" alt="無料カウンター" /></noscript>
          </div>      
           <!--<div class="span3">
            <h4>New Member</h4>
             <a href="../subform.html"><img src="../img/btn2.png" width: 230px; alt="Email" / onmouseover="this.src='../img/btn2_ov.png'" onmouseout="this.src='../img/btn2.png'"></a>
          </div>-->
         </div>
      </div>
      <hr class="footer">
      <div class="container">
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