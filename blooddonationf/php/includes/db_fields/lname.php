<?php
class lname{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setlname($id,$lname){
	$stmt = $this->con->prepare("Update users set lname=? where id=? ");
            $stmt->bind_param("ss", $lname,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getlname($id){
	$stmt = $this->con->prepare("SELECT lname FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $lname = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $lname['lname'];
	}
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["value"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new lname($con);
$id=$_POST["id"];
$lname=$_POST["value"];
$device=$_POST["device"];
$f->setLname($id,$lname);
if($device=="web"){
	session_start();
	$_SESSION["userlname"]=$lname;
}
echo json_encode($r);

}else if(isset($_POST["get"])&&!$_POST["get"]==""){
	$id=$_POST["get"];
	require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new lname($con);
$r["data"]=$f->getlname($id);
echo json_encode($r);

}else{
$r["error"]	=TRUE;
$r["error_msg"]	="information missing";
}
//echo json_encode($r);

?>