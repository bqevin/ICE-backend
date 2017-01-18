<?php
// Turn off all error reporting
// /error_reporting(0);
//including the database connection file
/*
// mysql_connect("database-host", "username", "password")
$conn = mysql_connect("localhost","root","root") 
            or die("cannot connected");

// mysql_select_db("database-name", "connection-link-identifier")
@mysql_select_db("test",$conn);
*/

/**
 * mysql_connect is deprecated
 * using mysqli_connect instead
 */

$databaseHost = 'localhost';
$databaseName = 'agrigen_emergency';
$databaseUsername = 'agrigen_kevin';
$databasePassword = 'Kevcom2015';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 

$parent = $_GET['parent'];
//Ensure user provides data before processing 
if (isset($parent)) {
    $sql = "SELECT * from `ice_contact` WHERE `parent` = '{$parent}'  ORDER BY id DESC";
    $json = array();
    $result = mysqli_query ($mysqli, $sql);
    while($row = mysqli_fetch_array ($result))     
    {
        $feed = array(
            'name' => $row['name'],
            'email' => $row['email'],
            'blood' =>  $row['blood'],
            'phone' =>  $row['phone'],
            'parent' =>  $row['parent'],
            'residence' =>  $row['residence'],
            'created_at' =>  strtotime($row['created_at']),
            'updated_at' =>  strtotime($row['updated_at'])
        );
        array_push($json, $feed);
    }

    $jsonstring = json_encode(array('contacts' => $json));
    echo $jsonstring;
    header('Content-Type: application/json');
    die();
        
}
?>  
