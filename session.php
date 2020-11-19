<?php
   include 'koneksi.php';
   // session_start();
   
   // $user_check = $_SESSION['username'];
   
   // $ses_sql = mysqli_query($pdo,"select username from user where username = '$user_check' ");
   // $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   // $login_session = $row['username'];
   
   // $ses_sql = mysqli_query($pdo,"select access from user where username = '$user_check' ");
   // $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   // $user_access = $row['access'];
   
   // if(!isset($login_session)){
   //    header("location:user.php");
   // }
   session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: user.php");
    exit;
}
