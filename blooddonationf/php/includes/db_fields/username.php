<?php
class username{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setusername($id,$username){
	$stmt = $this->con->prepare("Update users set username=? where id=? ");
            $stmt->bind_param("ss", $username,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getusername($id){
	$stmt = $this->con->prepare("SELECT username FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $username = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $username['username'];
	}
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["value"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new username($con);
$id=$_POST["id"];
$username=$_POST["value"];
$device=$_POST["device"];
$f->setusername($id,$username);
if($device=="web"){
	session_start();
	$_SESSION["username"]=$username;
}
}else if(isset($_POST["get"])&&!$_POST["get"]==""){
	$id=$_POST["get"];
	require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new username($con);
$r["data"]=$f->getusername($id);
}else{
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";
}
echo json_encode($r);
?>