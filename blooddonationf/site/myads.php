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
//echo $_GET["reqby"];
if(isset($_POST["reqby"])&&$_POST["reqby"]!=""){
require_once("../php/adpost.php");
$timeobj=new timeconversions();
$obj=new adpost();
$r=$obj->getmyads($_POST["reqby"]);
$cls="adcontainer_red";
$l=json_decode($r,true);
if(!$l["error"]){
for($i=0;$i<count($l)-1;$i++){
	$ad= $l[$i];
	$action='<button id="delete" class="but_red" onclick="deletead('.$ad["id"].','.$ad["recipient_userid"].')" >  Delete </button>';
	if(($ad["adactive"]==0)&&($ad["disabled"]==0)){
	$cls="adcontainer_yellow";
	$action='<button id="delete" class="but_red" onclick="showreqs('.$ad["id"].')" > Donors </button>';
	}else if(($ad["disabled"]==1)){
		$cls="adcontainer_green";
		$action='<span style="padding: 0px 20px;font-size:18px;"><b>Donated</b></span>';
	}
	 $donors=$ad["totalneed"]-$ad["remaningpeople"];
	echo '<div class="'.$cls.'" onclick="showreqs('.$ad["id"].')">
		<table style="width:900px; margin:0 auto;">
		<tr>
			<td>
				<div class="dp"></div>
			</td>
			<td style="padding-left:10px ; width:300px;">
				<span style="font-size:24px">you</span>
			</td>
			<td style="padding-left:20px;width:150px; ">
				<span style="font-size:18px">Required blood group: <b>'.$ad["bloodgroup"].'</b></span>
			</td>
			<td style="padding-left:20px; width:150px;">
				<span style="font-size:18px">People needed: <br><b>'. $donors.' of '.$ad["totalneed"].'</b></span>
			</td>
			<td style="padding-left:20px;width:150px;">
				<span style="font-size:18px">Ad given: <br ><b style="font-size:16px">'.$timeobj->ago($ad["postdate"]).' ago</b></span>
			</td>
			<td style="padding-left:10px; ">
				'.$action.'
			</td>
		</tr>
	</table>
</div>';
$cls="adcontainer_red";
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

