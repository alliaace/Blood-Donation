<?php
header("Content-Type: application/json");
require_once 'includes/db_fields/usersrow.php';
$row = new users_row();
$response = array('error'=>FALSE);
if((isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username'])&& isset($_POST['gender']) && isset($_POST['email']) && isset($_POST['password']))&&(!(empty($_POST['fname'])||empty($_POST['lname'])||empty($_POST['username'])||empty($_POST['email'])||empty($_POST['gender'])||empty($_POST['password'])))){
		$fname = $_POST['fname'];
		$lname=$_POST['lname'];
		$username=$_POST['username'];
		$email=$_POST['email'];
		$gender=$_POST['gender'];
		$password=$_POST['password'];
		if($row->userExists($email)){
			$response['error'] = TRUE;
    		$response['error_msg'] = "user exists";
    		echo json_encode($response);
		}else{
			$user = $row->insert($fname,$lname,$username,$gender,$email,$password);
        	if ($user) {
           		$response["error"] = FALSE;
            	$response["user"]["id"] = $user["id"];
            	$response["user"]["fname"] = $user["fname"];
				$response["user"]["lname"] = $user["lname"];
				$response["user"]["username"] = $user["username"];
				$response["user"]["gender"] = $user["gender"];
            	$response["user"]["email"] = $user["email"];
            	echo json_encode($response);
       		 } else {
            // user failed to store
            	$response["error"] = TRUE;
            	$response["error_msg"] = "internal error";
            	echo json_encode($response);
        	}
		}
	
}else{
	$response['error'] = TRUE;
    $response['error_msg'] = "information is missing";
    echo json_encode($response);
}
?>