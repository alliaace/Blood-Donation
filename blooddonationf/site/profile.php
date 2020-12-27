<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet"  type="text/css" href="css/profile_css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript" src="js/profile_scripts.js"></script>


<body>
<table style="margin:0 auto; padding-top:30px;">
<tr>
<td>
<div class="dp">
<div class="overlay"><span>change</span></div>
</div>
</td>
</tr>
<tr>
<td>
<input onblur="save(0,<?php echo "'".$_SESSION["userfname"]."',".$_SESSION["userid"] ?>)" type="text" style="float:left;  color:#333;	font-size:34px;" id="fname" size="<?php echo strlen($_SESSION["userfname"]) ?>" value="<?php echo $_SESSION["userfname"] ?>" />
<input onblur="save(1,<?php echo "'".$_SESSION["userlname"]."',".$_SESSION["userid"] ?>)" type="text" style="font-size:34px;text-align:left; color:#333;"  id="lname" size="<?php echo strlen($_SESSION["userlname"]) ?>" value="<?php echo $_SESSION["userlname"] ?>" />
</td>
</tr>
<tr>
<td>
<span>username:</span>
<input onblur="save(2,<?php echo "'".$_SESSION["username"]."',".$_SESSION["userid"] ?>)" type="text"  id="username" size="<?php echo strlen($_SESSION["username"]) ?>" value="<?php echo $_SESSION["username"] ?>" />
</td>
</tr>
<tr>
<td>
<span>blood group:</span>
<select <?php if(!($_SESSION["userbloodgroup"]===NULL)){echo "disabled";}?> onchange="save(4,<?php echo "'".$_SESSION["userbloodgroup"]."',".$_SESSION["userid"] ?>)"  class="blood" name="bloodgroup" id="bloodgroup" >
<option hidden="true">Blood group</option>
<option value="a+" <?php if($_SESSION["userbloodgroup"]=="a+"){echo "selected";} ?>>A+</option>
<option value="a-" <?php if($_SESSION["userbloodgroup"]=="a-"){echo "selected";} ?>>A-</option>
<option value="b+" <?php if($_SESSION["userbloodgroup"]=="b+"){echo "selected";} ?>>B+</option>
<option value="b-" <?php if($_SESSION["userbloodgroup"]=="b-"){echo "selected";} ?>>B-</option>
<option value="ab+" <?php if($_SESSION["userbloodgroup"]=="ab+"){echo "selected";} ?>>AB+</option>
<option value="ab-" <?php if($_SESSION["userbloodgroup"]=="ab-"){echo "selected";} ?>>AB-</option>
<option value="o+" <?php if($_SESSION["userbloodgroup"]=="o+"){echo "selected";} ?>>O+</option>
<option value="o-" <?php if($_SESSION["userbloodgroup"]=="o-"){echo "selected";} ?>>O-</option>
</select>
</td>
</tr>
<tr>
<td>
<span>email:</span>
<input type="text" onblur="save(3,<?php echo "'".$_SESSION["useremail"]."',".$_SESSION["userid"] ?>)"  id="email" size="<?php echo strlen($_SESSION["useremail"]) ?>" value="<?php echo $_SESSION["useremail"] ?>" />
</td>
</tr>
<tr>
<td>
<span>Phone#:</span>
<input type="text" onblur="save(5,<?php echo "'".$_SESSION["userphone"]."',".$_SESSION["userid"] ?>)"  id="phone" size="<?php echo strlen($_SESSION["userphone"]) ?>" value="<?php echo $_SESSION["userphone"] ?>" />
</td>
</tr>
<tr>
<td>
<button  class="but_red" onclick="showpassword()" id="passChange"> Change password</button>
<div id="passwordform" style="visibility:hidden" class="passwordform">
<form onsubmit="return false;">
<table style="margin:0 auto;">
<tr>
<td>
<span>Change Password</span>
</td>
</tr>
<tr>
<td>
<input type="password" id="oldpassword" placeholder="old password" />
</td>
</tr>
<tr>
<td>
<input type="password" id="newpassword" placeholder="new password" />
</td>
</tr>
<tr>
<td>
<input type="password" id="repeatnewpassword" placeholder="repeat new password" />
</td>
</tr>
<tr>
<td>
<button id"changepassword" onclick="changepass(<?php echo $_SESSION["userid"] ?>)" class="but_red">Change password</button>
<button id"cancelchangepassword" onclick="hidepassword()" class="but_red">Cancel</button>
</td>
</tr>
</table>
</form>
</div><div id="overlay" style="visibility:hidden" class="passwordoverlay"></div>
</td>
</tr>
</table>
</body>
</html>