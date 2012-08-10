<?php

require_once "..\lib\bones.php";

get("/", function($app) {
          $app->set("message", "Welcome to Verge");
          $app->render("home");
        });

get("/signup", function($app) {
          $app->render("user/signup");
        });

/** créer un user , inserer user dans la base de donnée **/
post("/signup", function(Bones $app) {
          $user = new User();
          $user->full_name = $app->form('full_name');
          $user->email = $app->form("email");
          $signed = $user->signup($app->form("username"), $app->form("password"));
          if($signed==true){
            $app->set("success","Thanks for Signing Up".$user->fullname);
            $app->render("home");
          }else{
            $app->set("error","A user with this name already exists. ");
            $app->render('user/signup');
          }
        });

get("/start", function($app) {
          return "Start";
        });

get("/say/:message", function($app) {
          $app->set('message', $app->request('message'));
          $app->render("home");
        });

get("/hello", function($app) {
          return "hello Bones";
        });

/** USERS **/

/** login **/
        get('/login',function(Bones $app){
          $app->render('user/login');
        });

        post('/login',function(Bones $app){
          $user=new User();
          $user->name=$app->form('username');
          $user->login($app->form('password'));
          $app->set('success','You are now logged in!');
          $app->render("home");
        });

        get('/logout',function(Bones $app){
          User::logout();
          $app->redirect('/');
        });
 /** PROFILE **/
        get("/user/:username",function(Bones $app){
          $app->set('user',User::get_by_username($app->request("username")));
          $app->render('user/profile');
        });

