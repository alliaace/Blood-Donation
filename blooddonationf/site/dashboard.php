<?php
session_start();
if(!$_SESSION["isloggedin"]){
header("Location: http://localhost/blooddonationf/site/");
die();
}
//$user =  json_decode($_SESSION["userdata"],false);
//echo "you logged in: " .$user->id;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<link rel="stylesheet"  type="text/css" href="css/dashboard_css.css" />
<link rel="stylesheet"  type="text/css" href="css/generic.css" />
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet"> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Wellcome - <?php echo $_SESSION["userfname"] ?></title>
</head>
<script type="text/javascript" src="js/form_scripts.js"></script>
<script type="text/javascript" src="js/dashboard_scripts.js"></script>
<script type="text/javascript" src="js/profile_scripts.js"></script>
<script type="text/javascript" src="js/feed_scripts.js"></script>
<script type="text/javascript" src="js/myads_scripts.js"></script>

<body onload="navigator(1,<?php echo $_SESSION["userid"] ?>);">
<div class="headbar">
<div class="logo">
<img src="img/logo.png"  width="25px" height="34px"  />
</div>
</div>

<div class="body" id="contentBody">


</div>

<div class="nav_container">
<div title="need blood?" id="adform" class="navs" onclick="navigator(0,<?php echo $_SESSION["userid"] ?>) ">
<img src="img/navblood.fw.png" width="35px" height="48px" />
</div>
<div title="needy feed" id="feed" onclick="navigator(1,<?php echo $_SESSION["userid"] ?>)" class="navs ">
<img src="img/feed.fw.png" width="47px" height="39px" />
</div>
<div title="profile" id="profile" onclick="navigator(2)" class="navs">
<img src="img/profile.fw.png" width="47px" height="47px" />
</div>
<div title="logout" id="logout" class="navs">
<a href="../php/logout.php">
<img src="img/logout.fw.png" width="45px" height="42px" />
</a>
</div>
</div>
</body>
</html>