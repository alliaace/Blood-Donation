<?php
$login="none";
$reg="block";
$out = "Have an acoount? Sign In";
session_start();
if($_SESSION["isloggedin"]){
header("Location: http://localhost/blooddonationf/site/dashboard.php");
die();
}
if($_SESSION){
$login="block";
$reg="none";
$out = "Dont have an account? Register";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>life care - registration</title>
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<link rel="stylesheet"  type="text/css" href="css/styles.css" />
<link rel="stylesheet"  type="text/css" href="css/generic.css" />
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet"> 

</head>

<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">
var check=true;

</script>
<body>
<!---<div class="header containers">
	
</div>
-->
<div id="logo">
    <img src="img/logo.png" width="100px">
    </div>
<div class="containers reg-box" >
<!--Register form-->
<form id="reg" style="display:<?php echo $reg; ?>" onsubmit="return false;" >
<table>
<tr>
<td>
<p class="reg-head">
Register yourself
</p>
</td>
</tr>
<tr>
<td>
<input type="text" id="reg_fname" class="formFielddsDim" placeholder="First name" style="width:190px"/>
</td>
<td><input type="text" id="reg_lname"  class="formFielddsDim" placeholder="Last name" style="width:190px; margin-left:-197px; "/></td>
</tr>
<tr>
<td><input type="text" id="reg_username"  class="formFielddsDim" placeholder="Username"/></td>
</tr>
<tr>
<td><input type="text" id="reg_email"  class="formFielddsDim" placeholder="Email Address"/></td>
</tr>
<tr>
<td><select class="formFielddsDim" id="reg_gender"  name="gender">
<option hidden="true">Genders</option>
<option value="m">Male</option>
<option value="f">Female</option>
</select></td>
</tr>
<tr>
<td><input type="password" id="reg_password"  class="formFielddsDim" placeholder="Password"/></td>
</tr>
<tr>
<td>
<button  id="register" class="but_red reg" onclick="reg()">Register</button>
</td>
</tr>
</table>
</form>
<!--login form-->
<form id="login" style="display:<?php echo $login; ?>" onsubmit="return false;" >
<table>
<tr>
<td>
<p class="reg-head">
LogIn
</p>
</td>
</tr>
<tr>
<td><input type="text" id="login_email" class="formFielddsDim" placeholder="email "/></td>
</tr>
<tr>
<td><input type="password" id="login_password" class="formFielddsDim" placeholder="Password"/></td>
</tr>
<tr>
<td>
<button id="login"  class="but_red reg" onClick="log_in()">Login</button>
</td>
</tr>
</table>
</form>
<div >
<!--button that toggles between forms
<button id="switch" style="margin:-3px auto; display:block"  onclick="toggle()" class="but_blue reg">Login</button>-->
<div class="switchContainer"><a id="switch" class="switchlink" onclick="toggle()" style="cursor: pointer"><?php echo $out?></a></div>
</div>
</div>
<div class="footer">
<p>© <a href="#"  >Umda</a></p>
</div>
</body>
</html>