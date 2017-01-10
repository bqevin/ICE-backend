<?php
error_reporting(E_ALL);
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['blood']) && isset($_POST['problem']) && isset($_POST['phone']) && isset($_POST['allergy']) && isset($_POST['email'])) {
 
    // receiving the post params
    $blood = $_POST['blood'];
    $problem = $_POST['problem'];
    $phone = $_POST['phone'];
    $allergy = $_POST['allergy'];
    $email = $_POST['email'];
 
    // Update the user info
    $user = $db->updateUser($email, $blood, $phone, $allergy, $problem);
    if ($user) {
        // user stored successfully
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["user"]["name"] = $user["name"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["created_at"] = $user["created_at"];
        $response["user"]["updated_at"] = $user["updated_at"];
        $response["user"]["blood"] = $user["blood"];
        $response["user"]["phone"] = $user["phone"];
        $response["user"]["allergy"] = $user["allergy"];
        $response["user"]["problem"] = $user["problem"];
        echo json_encode($response);
    } else {
        // user failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "Unknown error occurred during info update!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (blood type, phone, condition or allergy) is missing!";
    echo json_encode($response);
}
?>