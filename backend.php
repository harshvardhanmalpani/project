<?php
require_once("common.class.php");
require_once("user.class.php");
if(empty($_POST))
{
    header("Location: index.htm");die;
}
session_start();
if(isset($_POST['register']))
{
    // registration proceeds
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    #$name="asdsad";
    #$email="hello@soft.com";
    #$password="123456";
    $newuserobj= new Commonfunctions;
    $newuser=$newuserobj->checkInfo($name,$email,$password);
    if(!$newuser[0]) die("name is required");
    if(!$newuser[1]) die("email required");
    if(!$newuser[2]) die("password required min length 6");
    $registration= new Registration;
    echo $registration->tryRegister($newuser[0],$newuser[1],$newuser[2]);
}
else if(isset($_POST['login']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];
    $newuserobj= new Commonfunctions;
    $newuser=$newuserobj->checkLoginInfo($email,$password);
    if(!$newuser[0]) die("email is required");
    if(!$newuser[1]) die("password required");
    $registration= new Registration;
    $result=$registration->tryLogin($newuser[0],$newuser[1]);
    if($result)
    {
        $_SESSION['loggedin']="success";
        $_SESSION['uname']=$result[1];
        $newuserobj->forceBackend();
    }
    else {echo "<meta http-equiv=refresh content='5;url=index.htm'/><h1>Login failed, redirecting you to login page</h1>";}
}
else header("Location: index.htm");
?>