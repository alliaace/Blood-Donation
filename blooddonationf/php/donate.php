<?php
require_once 'adpost.php'; 
class donate{
	private $con,$ad;
	function __construct(){
	$db=new connection();
	$this->con=$db->connect();
	$this->ad = new adpost();
	}
function insert($ad_id,$donor_id){
	$date=date("Y-m-d H:i:s");
	$ad=$this->ad->getadbyid($ad_id);
	$recipient_id=$ad["recipient_userid"];
	$stmpt=$this->con->prepare("insert into donators(id,ad_id,recipient_userid,donor_userid,requestedon) values(0,?,?,?,?)");
	////
	$stmt=	$this->con->prepare("select id from donators where ad_id=? and donor_userid=?");
		$stmt->bind_param("ss", $ad_id,$donor_id);
        $stmt->execute();
        $stmt->store_result();
		if ($stmt->num_rows > 0) {
			$r["error"]=TRUE;
			$r["error_msg"]="already requested";
			echo json_encode($r);
		}else{
		$stmt=	$this->con->prepare("select id from donators where ad_id=?");
		$stmt->bind_param("s", $ad_id);
        $stmt->execute();
        $stmt->store_result();
			if(($ad["totalneed"]-$stmt->num_rows)==1 ){
				$stmt=	$this->con->prepare("update blood_ad set adactive=0 where id=?");
				$stmt->bind_param("s", $ad_id);
        		$stmt->execute();
			}
			$stmpt->bind_param("ssss",$ad_id,$recipient_id,$donor_id,$date);
			$result=$stmpt->execute();
			$stmpt->close();
		}
	///////
	
}	
}
$r=array("error"=>FALSE);
if(isset($_POST["ad_id"])&&isset($_POST["requestby"])&&($_POST["ad_id"]!=""||$_POST["$requestby"]!="")){
	$ad_id=$_POST["ad_id"];
	$uid=$_POST["requestby"];
	$obj=new donate();
	$obj->insert($ad_id,$uid);
	
}else if((isset($_POST["ad_id"])&&isset($_POST["requestby"])&&($_POST["ad_id"]==""||$_POST["$requestby"]==""))){
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";
echo json_encode($r);
}
?>