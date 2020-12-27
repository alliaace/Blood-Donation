<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet"  type="text/css" href="css/feed_css.css" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript" src="js/form_scripts.js"></script>
<script type="text/javascript" src="js/feed_scripts.js"></script>

<body onload=""><div id="myads" style="text-align:center">
<?php
header("Content-Type: text/html");
require_once("../php/timeconversions.php");
$r=array("error"=>FALSE);
//echo $_POST["reqby"];
if(isset($_POST["ad_id"])&&$_POST["ad_id"]!=""){
require_once("../php/adpost.php");
$timeobj=new timeconversions();
$obj=new adpost();
$r=$obj->requestson($_POST["ad_id"]);
//echo $r;
$l=json_decode($r,true);
$action='';
if(!$l["error"]){
for($i=0;$i<count($l)-1;$i++){
	$req= $l[$i];
	if($req["status"]==0){
		$action='<span style="text-align:center">rejectd</span>';
	}else if($req["status"]==1){
		$action='<span style="text-align:center;font-size:18px;">email:'.$req["contact_mail"].'<br>phone:'.$req["contact_phone"].'</span>';
	}else {
		$action='<button class="but_red" onclick="accpetreq('.$req["id"].',this)">Accept</button>
				<button class="but_red" onclick="rejectreq('.$req["id"].',this)">Reject</button>';
	}
	echo '<div class="adcontainer" >
		<table style="width:700px; margin:0 auto;">
		<tr>
			<td style="width:55px">
				<div class="dp" ></div>
			</td>
			<td style="padding-left:10px ; width:120px; text-align:left;">
				<span style="font-size:24px">'.$req["user_fname"].' '.$req["user_lname"].'</span>
			</td>
			<td style="padding-left:15px;width:100px;">
				<span style="font-size:18px">requested: <br ><b style="font-size:16px">'.$timeobj->ago($req["postdate"]).' ago</b></span>
			</td>
			<td style="padding-left:10px;text-align:right;width:200px; " id="info">
				'.$action.'
			</td>
		</tr>
	</table>
</div>';
$cls="adcontainer_red";
$action='';
}
}else{
	echo '<span style="font-size:22px;padding-top:50px;">'.$l["error_msg"].'</span>';
	//echo json_encode($l);
}


}else{
	$r["error"]=TRUE;
	$r["error_msg"]="information missing";
echo json_encode($r);
}

?></div>
</body>
</html>

