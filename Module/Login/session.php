<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
// include ('../../Source/connect.php');
// Selecting Database
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$ses_sql=mysqli_query($conn,"SELECT Username, EmployeeName FROM `USER_LOGIN` a INNER JOIN `EMPLOYEE` b ON a.EmployeeID = b.EmployeeID AND Username = '".$user_check."'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['Username'];
if(!isset($login_session)){
    $ses_sql=mysqli_query($conn,"SELECT Username, ClientName FROM `USER_LOGIN` a INNER JOIN `CLIENT` b ON a.ClientID = b.ClientID AND Username = '".$user_check."'");
    $row = mysqli_fetch_assoc($ses_sql);
    $login_session = $row['Username'];
    
    if(!isset($login_session)){
        mysql_close($connection); // Closing Connection
        header('Location: index.php'); // Redirecting To Home Page
    }
}
?>