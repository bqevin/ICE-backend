<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['bio']) && isset($_POST['phone']) && isset($_POST['location']) && isset($_POST['email'])) {
 
    // receiving the post params
    $bio = $_POST['bio'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $email = $_POST['email'];
 
    // Update the user info
    $user = $db->updateUser($email, $bio, $phone, $location);
    if ($user) {
        // user stored successfully
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["user"]["name"] = $user["name"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["created_at"] = $user["created_at"];
        $response["user"]["updated_at"] = $user["updated_at"];
        $response["user"]["bio"] = $user["bio"];
        $response["user"]["phone"] = $user["phone"];
        $response["user"]["location"] = $user["location"];
        echo json_encode($response);
    } else {
        // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred during info update!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (bio, phone or location) is missing!";
    echo json_encode($response);
}
?>