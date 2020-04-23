<?php 
include '../../Source/connect.php';
session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (empty($_POST['userID']) || empty($_POST['pwd'])) {
$error = "Username or Password is invalid";
echo "<script type='text/javascript'>alert('$error');window.location='index.php';</script>";
}

else {
// Define $username and $password
$username=$_POST['userID'];
$password=$_POST['pwd'];
// To protect MySQL injection for Security purpose

// SQL query to fetch information of registerd users and finds user match.
$sql = "CALL user_auth('$username',SHA1('$password'))";
$result = $conn->query($sql);

if ($row = $result->fetch_array()){

    if($row[0]=="Login incorrect"){
        $error = "Username or Password is invalid";
    }

    else {
        $_SESSION['login_user']=$username; // Initializing Session
        header("location:../../home.php"); // Redirecting To Other Page
    }
    echo"<script type='text/javascript'>alert('$error');window.location = 'index.php';</script>";
}

}

?>