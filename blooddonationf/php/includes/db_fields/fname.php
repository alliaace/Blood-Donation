<?php
class fname{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setFname($id,$fname){
	$stmt = $this->con->prepare("Update users set fname=? where id=? ");
            $stmt->bind_param("ss", $fname,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getFname($id){
	$stmt = $this->con->prepare("SELECT fname FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $fname = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $fname['fname'];
	}
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["value"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new fname($con);
$id=$_POST["id"];
$fname=$_POST["value"];
$device=$_POST["device"];
$f->setFname($id,$fname);
if($device=="web"){
	session_start();
	$_SESSION["userfname"]=$fname;
}
echo json_encode($r);
}else if(isset($_POST["get"])&&!$_POST["get"]==""){
	$id=$_POST["get"];
	require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new fname($con);
$r["data"]=$f->getFname($id);
echo json_encode($r);
}else{
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";

//echo json_encode($r);
}
?>