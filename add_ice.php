<?php
require_once 'include/rb.php';
require_once 'include/DB_Functions.php';

$db = new DB_Functions();

R::setup('mysql:host=localhost; dbname=agrigen_emergency','agrigen_kevin','Kevcom2015');
R::setAutoResolve( TRUE );

$response = array("error" => FALSE);
 
if ( isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['blood']) ) {
    $bean = R::dispense('ice_contact');
 
    // receiving the post params
    $email = $_POST['email'];
    $parent = $_POST['parent'];

    $bean->email = $email;
    $bean->parent = $parent;
    $bean->name = $_POST['name'];
    $bean->phone = $_POST['phone'];
    $bean->blood = $_POST['blood'];

    // check if user is already existed with the same email
    if ($db->isICEExisted($email, $parent)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "You have already registered an ICE with similar email ";
        echo json_encode($response);
    } else {
        // create a new user
        if ($id = R::store($bean)) {
            // user stored successfully
            $response = R::load('ice_contact',$id);
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occured in adding ICE";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email, blood or phone) is missing!";
    echo json_encode($response);
}
?>