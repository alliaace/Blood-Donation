<?php
require_once 'db_con/connection.php';
require_once 'password.php';
class users_row{
	private $con,$password;
	function __construct(){
	$db=new connection();
	$this->con=$db->connect();
	$this->password=new password($db->connect());
	}
	function insert($fname,$lname,$username,$gender,$email,$password){
		$stmpt=$this->con->prepare("insert into users(id,fname,lname,username,gender,email,password_enc,salt) values(0,?,?,?,?,?,?,?)");
		$hash=$this->password->hashSSHA($password);
	$stmpt->bind_param("sssssss",$fname,$lname,$username,$gender,$email,$hash['password_enc'],$hash['salt']);
	$result=$stmpt->execute();
	$stmpt->close();
	if ($result) {
            $stmt = $this->con->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $user;
        } else {
            return false;
        }
}
 public function userExists($email) {
        $stmt = $this->con->prepare("SELECT email from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // user exists 
            $stmt->close();
            return true;
        } else {
            // user not exists
            $stmt->close();
            return false;
        }
    }
	public function getUserById($id){
		$stmt = $this->con->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);
		if($stmt->execute()){
		$user = $stmt->get_result()->fetch_assoc();
         $stmt->close();
		 return $user;
		}else{
		return NULL;	
		}
			
	}
	public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->con->prepare("SELECT * FROM users WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['password_enc'];
            $hash = $this->password->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

}
/*$a= new users_row();
$result= $a->getUserById(3);
if($result!=NULL){
		echo $result['username'];
	}else{
		echo'err';
	}
*/
?>