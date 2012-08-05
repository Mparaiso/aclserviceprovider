<?php
require_once "..\lib\bones.php";

get("/",function($app){
	$app->set("message","Welcome to Verge");
	$app->render("home");
});

get("/signup",function($app){
	$app->render("signup");
});

post("/signup",function($app){
	$app->set("message","Thanks for signing up ".
	$app->form("name")."!");
	$app->render("home");
});
get("/start",function($app){
	return "Start";
});
?>