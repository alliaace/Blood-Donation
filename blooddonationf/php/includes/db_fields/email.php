<?php
class email{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setemail($id,$email){
	$stmt = $this->con->prepare("Update users set email=? where id=? ");
            $stmt->bind_param("ss", $email,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getemail($id){
	$stmt = $this->con->prepare("SELECT email FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $email = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $email['email'];
	}
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["value"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new email($con);
$id=$_POST["id"];
$email=$_POST["value"];
$device=$_POST["device"];
$f->setemail($id,$email);
if($device=="web"){
	session_start();
	$_SESSION["useremail"]=$email;
}
}else if(isset($_POST["get"])&&!$_POST["get"]==""){
	$id=$_POST["get"];
	require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new email($con);
$r["data"]=$f->getemail($id);
}else{
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";
}
echo json_encode($r);
?>