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
require_once("../php/timeconversions.php");
$r=array("error"=>FALSE);
//echo $_POST["reqby"];
if(isset($_POST["reqby"])&&$_POST["reqby"]!=""){
require_once("../php/adpost.php");
$timeobj=new timeconversions();
$obj=new adpost();
$r=$obj->myreqs($_POST["reqby"]);
$contact='';
//echo $r;
$l=json_decode($r,true);
if(!$l["error"]){
for($i=0;$i<count($l)-1;$i++){
	$ad= $l[$i];
	
	
	if($ad["accepted"]==1){
		$status='<button class="but_red" onclick="showcontactdialogue()">info</button>';
		$contact='<div id="contactdialogue" style="text-align:center;visibility:hidden" class="requests">
			<span style="border-bottom:1px solid #ccc;width:100%;display:inline-block;text-align:center; font-size:22px; padding:10px;">contact info</span>
			<div  style="display:inline-block">
			<table>
			<tr>
			<td>
			<span style="font-size:22px;"><b style="font-size:20px;">Email:</b>'.$ad["recepient_email"].'</span>
			<br><span style="font-size:22px;"><b style="font-size:20px;">phone:</b>'.$ad["recepient_phone"].'</span>
			</td>
			</tr>
			
			</table>
			</div>
			<div style="text-align:center;padding-top:10px;"><button class="but_red" onclick=" hidecontactdialogue()">close</button></div>
			</div><div id="overlay" style="visibility:hidden" class="requestsoverlay">ad</div>';
	}else if($ad["accepted"]==2){
		$status='<span>pending</span>';
	}else if($ad["accepted"]==0){
		$status='<span>rejected</span>';
	}
	echo $contact.'
			<div class="adcontainer" >
		<table style="width:700px; margin:0 auto;">
		<tr>
			<td>
				<div class="dp"></div>
			</td>
			<td style="padding-left:10px ; width:250px; text-align:left">
				<span style="font-size:24px">'.$ad["user_fname"].' '.$ad["user_fname"].'</span>
			</td>
			<td style="padding-left:20px;width:150px; ">
				<span style="font-size:18px">Required blood group: <b>'.$ad["bloodgroup"].'</b></span>
			</td>
			<td style="padding-left:20px;width:150px;">
				<span style="font-size:18px">Ad given: <br ><b style="font-size:16px">'.$timeobj->ago($ad["postdate"]).' ago</b></span>
			</td>
			<td style="padding-left:10px; ">
				'.$status.'
			</td>
		</tr>
	</table>
</div>';
$cls="adcontainer_red";
$status="pending";
$contact='';
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

