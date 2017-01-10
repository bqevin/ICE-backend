<?php
error_reporting(0);
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['blood'])) {
 
    // receiving the post params
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood = $_POST['blood'];
 
    // check if user is already existed with the same email
    if ($db->isICEExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "ICE already exists with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeICE($name, $email, $phone, $blood);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["blood"] = $user["blood"];
            $response["user"]["phone"] = $user["phone"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email, blood or phone) is missing!";
    echo json_encode($response);
}
?>