<?php
require_once 'db_con/connection.php';
class bloodgroup{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setbloodgroup($id,$bloodgroup){
	$stmt = $this->con->prepare("Update users set bloodgroup=? where id=? ");
            $stmt->bind_param("ss", $bloodgroup,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getbloodgroup($id){
	$stmt = $this->con->prepare("SELECT bloodgroup FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $bloodgroup = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $bloodgroup['bloodgroup'];
	}
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["value"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new bloodgroup($con);
$id=$_POST["id"];
$bloodgroup=urlencode($_POST["value"]);
$device=$_POST["device"];
$f->setbloodgroup($id,$bloodgroup);
if($device=="web"){
	session_start();
	$_SESSION["userbloodgroup"]=$bloodgroup;
}
}else if(isset($_POST["get"])&&!$_POST["get"]==""){
	$id=$_POST["get"];
	require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new bloodgroup($con);
$r["data"]=$f->getbloodgroup($id);
}else{
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";
}
echo json_encode($r);
?>