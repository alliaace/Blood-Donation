<?php
class phone{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setphone($id,$phone){
	$stmt = $this->con->prepare("Update users set phone=? where id=? ");
            $stmt->bind_param("ss", $phone,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getphone($id){
	$stmt = $this->con->prepare("SELECT phone FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $phone = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $phone['phone'];
	}
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["value"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new phone($con);
$id=$_POST["id"];
$phone=$_POST["value"];
$device=$_POST["device"];
$f->setphone($id,$phone);
if($device=="web"){
	session_start();
	$_SESSION["userphone"]=$phone;
}
}else if(isset($_POST["get"])&&!$_POST["get"]==""){
	$id=$_POST["get"];
	require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new phone($con);
$r["data"]=$f->getphone($id);
}else{
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";
}
echo json_encode($r);
?>