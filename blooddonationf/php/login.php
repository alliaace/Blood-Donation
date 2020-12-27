<?php
header("Content-Type: application/json");
require_once 'includes/db_fields/usersrow.php';
$row = new users_row();
$response = array("error" => FALSE);
if ((isset($_POST['email']) && isset($_POST['device']) && isset($_POST['password']))&&!(empty($_POST['password'])||empty($_POST['email']))) {

    // receiving the post params
	$device = $_POST['device'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // get the user by email and password
    $user = $row->getUserByEmailAndPassword($email, $password);

    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["user"]["id"] = $user["id"];
        $response["user"]["fname"] = $user["fname"];
		$response["user"]["lname"] = $user["lname"];
		$response["user"]["username"] = $user["username"];
		$response["user"]["gender"] = $user["gender"];
        $response["user"]["email"] = $user["email"];
		$response["user"]["bloodgroup"] = $user["bloodgroup"];
		$response["user"]["phone"] = $user["phone"];
		$response["user"]["lastDonated"] = $user["lastDonated"];
        echo json_encode($response);
		if($device=="web"){
			session_start();
			$_SESSION["isloggedin"]=TRUE;
			$_SESSION["userid"]=$user["id"];
			$_SESSION["userfname"]=$user["fname"];
			$_SESSION["userlname"]=$user["lname"];
			$_SESSION["username"]=$user["username"];
			$_SESSION["usergender"]=$user["gender"];
			$_SESSION["useremail"]=$user["email"];
			$_SESSION["userbloodgroup"]=$user["bloodgroup"];
			$_SESSION["userphone"]=$user["phone"];
			$_SESSION["userlastDonated"]=$user["lastDonated"];
		}
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "information missing";
    echo json_encode($response);
}
?>
