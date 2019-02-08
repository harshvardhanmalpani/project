<?php
session_start();
require_once("common.class.php");
$obj=new Commonfunctions;
$obj->forceLogin();
?>