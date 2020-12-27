<?php
class gender{
	private $con;
	function __construct($con){
	$this->con=$con;
	}
	function setgender($id,$gender){
	$stmt = $this->con->prepare("Update users set gender=? where id=? ");
            $stmt->bind_param("ss", $gender,$id);
            $stmt->execute();
            //$user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
	}
	function getgender($id){
	$stmt = $this->con->prepare("SELECT gender FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $gender = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $gender['gender'];
	}
	
}
?>