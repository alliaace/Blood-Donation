<?php
//header("Content-Type: application/json");
require_once 'includes/db_fields/db_con/connection.php'; 
require_once("includes/db_fields/fname.php");
require_once("includes/db_fields/lname.php");
require_once("timeconversions.php");
class adpost{
	private $con,$ln,$fn,$timeobj ;
	function __construct(){
	$db=new connection();
	$this->con=$db->connect();
	$this->timeobj =new timeconversions();
	$this->ln = new lname($db->connect());
	$this->fn = new fname($db->connect());
	}
	function insert($recipient_id,$bloodgroup,$reqpeople){
		$date=date("Y-m-d H:i:s");

		$stmpt=$this->con->prepare("insert into blood_ad(id,recipient_userid,bloodgroup,totalneed,adactive,postdate,disabled) values(0,?,?,?,1,?,0)");
	$stmpt->bind_param("ssss",$recipient_id,$bloodgroup,$reqpeople,$date);
	$result=$stmpt->execute();
	$stmpt->close();
	/*if ($result) {
            $stmt = $this->con->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }*/
}
function getactiveads($reqby){
	$r=array("error"=>FALSE);
	$stmt=$this->con->prepare("SELECT id FROM blood_ad ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	$maxrows =$stmt->get_result()->fetch_assoc();
	$applied;
	$stmt=$this->con->prepare("SELECT * FROM blood_ad where id =? ORDER BY id DESC LIMIT 1");
	if($maxrows>0){
	for($i=$maxrows["id"],$j=0;$i>=1;$i--){
		$stmt->bind_param("s",$i);
		$stmt->execute();
        $ad = $stmt->get_result()->fetch_assoc();
		if(!($ad===NULL)&&($ad["adactive"]==1&&$ad["disabled"]==0)){
		
		////////////////////
		$stmpt=	$this->con->prepare("select * from donators where ad_id=? and donor_userid=? ");
		$stmpt->bind_param("ss", $ad["id"],$reqby);
        $stmpt->execute();
        $stmpt->store_result();
		if ($stmpt->num_rows > 0) {
			$applied=1; 
		}else{
			$applied=0; 
		}
		//////////////////
		
		$stmpt=	$this->con->prepare("select * from donators where ad_id=? and accepted>0 ");
		$stmpt->bind_param("s", $ad["id"]);
        $stmpt->execute();
        $stmpt->store_result();
		$remaningpeople=$stmpt->num_rows;
		
		
		///////////////
		$r[$j]["id"]=$ad["id"];
		$r[$j]["recipient_userid"]=$ad["recipient_userid"];
		$r[$j]["recipient_fname"]=$this->fn->getFname($ad["recipient_userid"]);
		$r[$j]["recipient_lname"]=$this->ln->getlname($ad["recipient_userid"]);
		$r[$j]["bloodgroup"]=$ad["bloodgroup"];
		$r[$j]["totalneed"]=$ad["totalneed"];
		//$r[$j]["adactive"]=$ad["adactive"];
		$r[$j]["postdate"]=$this->timeobj->ago($ad["postdate"]);
		$r[$j]["remaningpeople"]=$remaningpeople;
		//$r[$j]["disabled"]=$ad["disabled"];
		$r[$j++]["apllied"]=$applied;
		}
	}
	return json_encode($r);
	}else{
		$r["error"]=TRUE;
		$r["error_msg"]="feed empty, no ads to show";
		return json_encode($r);
	}
}
function getadbyid($id){
	$stmt=$this->con->prepare("SELECT * FROM blood_ad where id =? ");
		$stmt->bind_param("s",$id);
		$stmt->execute();
        $ad = $stmt->get_result()->fetch_assoc();
		return $ad;

}
function getallads(){
	$r=array("error"=>FALSE);
	$stmt=$this->con->prepare("SELECT id FROM blood_ad ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	$maxrows =$stmt->get_result()->fetch_assoc();
	$stmt=$this->con->prepare("SELECT * FROM blood_ad where id =? ORDER BY id DESC LIMIT 1");
	if($maxrows>0){
	for($i=$maxrows["id"];$i>=1;$i--){
		$stmt->bind_param("s",$i);
		$stmt->execute();
        $ad = $stmt->get_result()->fetch_assoc();
		if(!($ad===NULL)){
		$r[]=$ad;
		}
	}
	return json_encode($r);
	}else{
		$r["error"]=TRUE;
		$r["error_msg"]="feed empty";
		return json_encode($r);
	}
}
function getmyads($uid){
	$r=array("error"=>FALSE);
	$stmt=$this->con->prepare("SELECT id FROM blood_ad where recipient_userid=? ORDER BY id DESC LIMIT 1");
	$stmt->bind_param("s",$uid);
	$stmt->execute();
	$maxrows =$stmt->get_result()->fetch_assoc();
	$stmt=$this->con->prepare("SELECT * FROM blood_ad where id =? and recipient_userid=? ORDER BY id DESC LIMIT 1");
	if($maxrows>0){
	for($i=$maxrows["id"],$j=0;$i>=1;$i--){
		$stmt->bind_param("ss",$i,$uid);
		$stmt->execute();
        $ad = $stmt->get_result()->fetch_assoc();
		if(!($ad===NULL)){
		///////////////
		$stmpt=	$this->con->prepare("select * from donators where ad_id=? and accepted>0  ");
		$stmpt->bind_param("s", $ad["id"]);
        $stmpt->execute();
        $stmpt->store_result();
		$remaningpeople=$stmpt->num_rows;
		/////////////////////
		$r[$j]["id"]=$ad["id"];
		$r[$j]["recipient_userid"]=$ad["recipient_userid"];
		$r[$j]["bloodgroup"]=$ad["bloodgroup"];
		$r[$j]["totalneed"]=$ad["totalneed"];
		//$r[$j]["adactive"]=$ad["adactive"];
		$r[$j]["postdate"]=$this->timeobj->ago($ad["postdate"]);
		$r[$j]["adactive"]=$ad["adactive"];
		$r[$j]["disabled"]=$ad["disabled"];
		$r[$j++]["remaningpeople"]=$remaningpeople;
		//$r[$j]["disabled"]=$ad["disabled"];
		//$r[$j++]["apllied"]=$applied;
		}
	}
	return json_encode($r);
	}else{
		$r["error"]=TRUE;
		$r["error_msg"]="feed empty";
		return json_encode($r);
	}
}
function deletead($id,$uid){
			$ad =$this->getadbyid($id);
			$r=array("error"=>FALSE);
			$stmt=$this->con->prepare("DELETE FROM blood_ad WHERE id=?");
		if($ad!==NULL){
			if($ad["recipient_userid"]==$uid){
				$stmt->bind_param("s",$id);
				$stmt->execute();
				
			}else{
				$r["error"]=TRUE;
				$r["error_msg"]="you dont have the authority to delete this ad";
			}
			}else{
				$r["error"]=TRUE;
				$r["error_msg"]="ad does not exist";
		}
			echo json_encode($r);
}
function requestson($ad_id){
	$r=array("error"=>FALSE);
	$stmt=$this->con->prepare("SELECT id FROM donators where ad_id=? and accepted>0 ORDER BY id DESC LIMIT 1");
	$stmt->bind_param("s",$ad_id);
	$stmt->execute();
	$maxrows =$stmt->get_result()->fetch_assoc();
	$stmt=$this->con->prepare("SELECT * FROM donators where id =? and accepted>0 ORDER BY id DESC LIMIT 1");
	if($maxrows>0){
	for($i=$maxrows["id"],$j=0;$i>=1;$i--){
		$stmt->bind_param("s",$i);
		$stmt->execute();
        $req = $stmt->get_result()->fetch_assoc();
		//echo json_encode($req);;
		if(!($req===NULL)){
		///////////////
		$stmpt=	$this->con->prepare("select * from users where id=?");
		$stmpt->bind_param("s", $req["donor_userid"]);
        $stmpt->execute();
        $user = $stmpt->get_result()->fetch_assoc();
		$stmpt->close();
		/////////////////////
		$r[$j]["id"]=$req["id"];
		$r[$j]["user_fname"]=$user["fname"];
		$r[$j]["user_lname"]=$user["lname"];
		$r[$j]["status"]=$req["accepted"];
		$r[$j]["contact_mail"]=$user["email"];
		$r[$j]["contact_phone"]=$user["phone"];
		$r[$j++]["postdate"]=$this->timeobj->ago($req["requestedon"]);
		//$r[$j]["adactive"]=$ad["adactive"];
		//$r[$j]["disabled"]=$ad["disabled"];
		//$r[$j++]["remaningpeople"]=$remaningpeople;
		//$r[$j]["disabled"]=$ad["disabled"];
		//$r[$j++]["apllied"]=$applied;
		}
	}
	return json_encode($r);
	}else{
		$r["error"]=TRUE;
		$r["error_msg"]="feed empty";
		return json_encode($r);
	}
}
function acceptreq($req_id){
	$stmt=$this->con->prepare("select * from donators where id=".$req_id);
	$stmt->execute();
	$req = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$stmt=$this->con->prepare("select * from blood_ad where id=".$req["ad_id"]);
	$stmt->execute();
	$ad = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$stmt=$this->con->prepare("select * from users where id=".$ad["recipient_userid"]);
	$stmt->execute();
	$user = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$stmpt=	$this->con->prepare("select * from donators where ad_id=".$req["ad_id"]." and accepted=1");
    $stmpt->execute();
    $stmpt->store_result();
	$remaningpeople=$stmpt->num_rows;
	if($remaningpeople+1==$ad["totalneed"]){
	$stmt=$this->con->prepare("Update blood_ad set disabled=1 where id=".$req["ad_id"]);
	$stmt->execute();
	$stmt->close();
	}
	$stmt=$this->con->prepare("Update donators set accepted=1 where id=".$req_id);
	$stmt->execute();
	$stmt->close();
	$stmt=$this->con->prepare("select * from users where id=".$req["donor_userid"]);
	$stmt->execute();
	$donor = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$r["contact_email"]=$donor["email"];
	$r["contact_phone"]=$donor["phone"];
	return json_encode($r);
	//echo "done";
}
function rejectreq($req_id){
	$stmt=$this->con->prepare("select * from donators where id=".$req_id);
	$stmt->execute();
	$req = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$stmt=$this->con->prepare("select * from blood_ad where id=".$req["ad_id"]);
	$stmt->execute();
	$ad = $stmt->get_result()->fetch_assoc();
	$stmt->close();
	$stmt=$this->con->prepare("Update donators set accepted=0 where id=".$req_id);
	$stmt->execute();
	$stmt->close();
	$stmt=$this->con->prepare("Update blood_ad set adactive=1 where id=".$ad["id"]);
	$stmt->execute();
	$stmt->close();
	$r=array("error"=>FALSE);
	echo json_encode($r);
}
function myreqs($user_id){
	$r=array("error"=>FALSE);
	$stmt=$this->con->prepare("SELECT id FROM donators where donor_userid=? ORDER BY id DESC LIMIT 1");
	$stmt->bind_param("s",$user_id);
	$stmt->execute();
	$maxrows =$stmt->get_result()->fetch_assoc();
	$stmt=$this->con->prepare("SELECT * FROM donators where id=? and donor_userid =? ORDER BY id DESC LIMIT 1");
	
	if($maxrows>0){
	for($i=$maxrows["id"],$j=0;$i>=1;$i--){
		$stmt->bind_param("ss",$i,$user_id);
		$stmt->execute();
        $req = $stmt->get_result()->fetch_assoc();
		if(!($req===NULL)){
			
		///////////////
		$stmpt=	$this->con->prepare("select * from users where id=?");
		$stmpt->bind_param("s", $req["recipient_userid"]);
        $stmpt->execute();
        $user = $stmpt->get_result()->fetch_assoc();
		$stmpt->close();
		/////////////////////
		$stmpt=	$this->con->prepare("select * from blood_ad where id=?");
		$stmpt->bind_param("s", $req["ad_id"]);
        $stmpt->execute();
        $ad = $stmpt->get_result()->fetch_assoc();
		$stmpt->close();
		/////////////////////
		$r[$j]["id"]=$req["id"];
		$r[$j]["user_fname"]=$user["fname"];
		$r[$j]["user_lname"]=$user["lname"];
		$r[$j]["bloodgroup"]=$ad["bloodgroup"];
		$r[$j]["accepted"]=$req["accepted"];
		$r[$j]["recepient_email"]=$user["email"];
		$r[$j]["recepient_phone"]=$user["phone"];
		$r[$j++]["postdate"]=$this->timeobj->ago($ad["postdate"]);
		//$r[$j]["adactive"]=$ad["adactive"];
		//$r[$j]["disabled"]=$ad["disabled"];
		//$r[$j++]["remaningpeople"]=$remaningpeople;
		//$r[$j]["disabled"]=$ad["disabled"];
		//$r[$j++]["apllied"]=$applied;
		}
	}
	return json_encode($r);
	}else{
		$r["error"]=TRUE;
		$r["error_msg"]="feed empty";
		return json_encode($r);
	}
}
}
$r= array("error"=>FALSE);
if(isset($_POST["recipient_id"])&&isset($_POST["bloodgroup"])&&isset($_POST["reqpeople"])&&isset($_POST["device"])&&($_POST["recipient_id"]!=""||$_POST["bloodgroup"]!=""||$_POST["reqpeople"]!=""||$_POST["device"]!="")){
	$recipient_id=$_POST["recipient_id"];
	$bloodgroup=urlencode($_POST["bloodgroup"]);
	$reqpeople=$_POST["reqpeople"];
	$obj=new adpost();
	$obj->insert($recipient_id,$bloodgroup,$reqpeople);
	echo json_encode($r);
	
}else if((isset($_POST["getads"])&&$_POST["getads"]!="")&&(isset($_POST["reqby"])&&$_POST["reqby"]!="")){
$obj=new adpost();
$reqby=$_POST["reqby"];
if($_POST["getads"]=="active"){
$r=$obj->getactiveads($reqby);
}else if($_POST["getads"]=="all"){
$r=$obj->getallads();
}else if($_POST["getads"]=="mine"){
	$r=$obj->getmyads($reqby);
}
echo $r;
}else if((isset($_POST["deletead"])&&isset($_POST["reqby"]))&&($_POST["deletead"] !=""||$_POST["reqby"] !="")){
$obj=new adpost();
$id=$_POST["deletead"];
$uid=$_POST["reqby"];
$obj->deletead($id,$uid);
}else if((isset($_POST["actiononreq"])&&isset($_POST["req_id"]))&&($_POST["actiononreq"] !=""||$_POST["req_id"] !="")){
$obj=new adpost();
if($_POST["actiononreq"]=="acc"){
$r=$obj->acceptreq($_POST["req_id"]);
}else if($_POST["actiononreq"]=="rej"){
$r=$obj->rejectreq($_POST["req_id"]);
}
echo $r;
}
else if(((isset($_POST["actiononreq"])&&isset($_POST["req_id"]))&&($_POST["actiononreq"] ==""||$_POST["req_id"] ==""))||(isset($_POST["recipient_id"])&&isset($_POST["bloodgroup"])&&isset($_POST["reqpeople"])&&isset($_POST["device"])&&($_POST["recipient_id"]==""||$_POST["bloodgroup"]==""||$_POST["reqpeople"]==""||$_POST["device"]==""))||(isset($_POST["getads"])&&$_POST["getads"]=="")||((isset($_POST["deletead"])&&isset($_POST["reqby"]))&&($_POST["deletead"] ==""||$_POST["reqby"] ==""))){
	$r["error"]=TRUE;
	$r["error_msg"]="information missing";
	echo json_encode($r);
}

?>