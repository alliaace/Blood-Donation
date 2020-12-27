<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet"  type="text/css" href="css/form_css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript" src="js/form_scripts.js"></script>
<script type="text/javascript" src="js/feed_scripts.js"></script>

<body onload="optionnavigator(0,1)">
<div id="requestsdialogue" style="visibility:hidden" class="requests">
</div><div id="overlay" style="visibility:hidden" class="requestsoverlay">ad</div>
<div class="form_container">
<table style="margin:0 auto">
<tr>
	<td>
		<div class="dp"></div>
	</td>
<td>
	<table style="padding-left:20px;padding-bottom:20px; width:500px; display:inline-block" class="mintable">
		<tr>
			<td>
				<span style="font-size:28px; font-weight:bold;color:#333;"><?php echo $_SESSION["userfname"]." ".$_SESSION["userlname"] ?></span>
			</td>
		</tr>
		<tr>
			<td>
				<span style="font-size:18px; color:#333;"><?php echo '<b>email:  </b>'. $_SESSION["useremail"] ?></span>
			</td>
            <td>
				<span style="font-size:18px; color:#333;"><b>Required type:</b></span>
                <select id="bloodgroup" >
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
			<td >
				<span style="font-size:18px; color:#333;"><?php echo '<b>phone:  </b>'.$_SESSION["userphone"] ?></span>
			</td>
            <td>
				<span style="font-size:18px; color:#333;"><b>Required people:</b></span>
                <select id="peoplerequired" >
				<option value="1">1</option>
				<option value="2" >2</option>
				<option value="3" >3</option>
				<option value="4" >4</option>
				<option value="5" >5</option>
				</select>
			</td>
		</tr>
	</table>
</td>
<td>
	<button class="but_red" onclick="post(<?php echo $_SESSION["userid"] ?>)" style="float:right;" id="post">post</button>
</td>
</tr>
</table>
</div>
<div class="choicecontaner">
<div class="optionscontainer">
<span id="myads" onclick="optionnavigator(0,<?php echo $_SESSION["userid"];?>)">Your ads</span><div style="width:2px; display:inline-block; height:20px; background:#ccc;"></div><span id="myrequests" onclick="optionnavigator(1,<?php echo $_SESSION["userid"];?>)">Ads you applied for</span>
</div>
</div>

<div id="mycontentbod">

</div>

</body>
</html>