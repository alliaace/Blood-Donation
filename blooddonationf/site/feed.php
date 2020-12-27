<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet"  type="text/css" href="css/feed_css.css" />

</head>
<script type="text/javascript" src="js/feed_scripts.js" >

</script>
<body onload="loadfeed(<?php echo $_SESSION["userid"]?>); ">
<div id="content" style="text-align:center">
<!--<div class="adcontainer_red">
<table style="width:900px; margin:0 auto;">
<tr>
	<td>
		<div class="dp"></div>
	</td>
    <td style="padding-left:10px">
    	<span style="font-size:24px">Sheikh Hamza</span>
    </td>
     <td style="padding-left:20px; ">
    	<span style="font-size:18px">Required blood group: O+</span>
    </td>
     <td style="padding-left:20px; ">
    	<span style="font-size:18px">People needed: 2 of 3</span>
    </td>
    <td style="padding-left:10px; ">
<button id="donate" class="but_red" >Donate</button>
    </td>
     
</tr>
</table>
</div>-->
</div>
</body>
</html>