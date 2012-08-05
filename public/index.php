<?php
require_once "..\lib\bones.php";

get("/",function($app){
	$app->set("message","Welcome to Verge");
	$app->render("home");
});

get("/signup",function($app){
	$app->render("signup");
});

get("/start",function($app){
	return "Start";
});
?>