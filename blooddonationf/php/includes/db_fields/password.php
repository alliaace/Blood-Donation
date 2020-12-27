<?php
class password{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setpassword($id,$password){
	$stmt = $this->con->prepare("Update users set password_enc=?,salt=? where id=? ");
	$hash=$this->hashSSHA($password);
            $stmt->bind_param("sss", $hash['password_enc'], $hash['salt'],$id);
			$stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getpasswordEnc($id){
	$stmt = $this->con->prepare("SELECT password_enc FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $pass_enc = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $pass_enc['password_enc'];
	}
	function getsalt($id){
	$stmt = $this->con->prepare("SELECT salt FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $salt = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $salt['salt'];
	}
	public function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "password_enc" => $encrypted);
		return $hash;
    }
    public function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }
	
}
$r = array("error"=>FALSE);
if(isset($_POST["id"])&&isset($_POST["old"])&&isset($_POST["new"])&&isset($_POST["device"])){
require_once 'db_con/connection.php';
$db=new connection();
$con = $db->connect();
$f = new password($con);
$id=$_POST["id"];
$old=$_POST["old"];
$new=$_POST["new"];
$device=$_POST["device"];
if($f->getpasswordEnc($id)==$f->checkhashSSHA(($f->getsalt($id)),$old)){
$f->setpassword($id,$new);
echo json_encode($r);
}else{
	$r["error"]=TRUE;
	$r["error_msg"]="old password did not match";
echo json_encode($r);	
}
}

?>