<?php
require_once "..\lib\bones.php";

get("/",function($app){
	echo "Home";
});

get("/signup",function($app){
	echo "SignUp!";
});
?>