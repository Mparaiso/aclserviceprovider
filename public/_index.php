<?php

require_once "..\lib\bones.php";

get("/", function($app) {
          $app->set("message", "Welcome to Verge");
          $app->render("home");
        });

get("/signup", function($app) {
          $app->render("user/signup");
        });

/** créer un user , inserer user dans la base de donnée * */
post("/signup", function(Bones $app) {
          $user = new User();
          $user->full_name = $app->form('full_name');
          $user->email = $app->form("email");
          $signed = $user->signup($app->form("username"), $app->form("password"));
          if ($signed == true) {
            $app->set("success", "Thanks for Signing Up" . $user->fullname);
            $app->render("home");
          } else {
            $app->set("error", "A user with this name already exists. ");
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

#USERS
# login
get('/login', function(Bones $app) {
          $app->render('user/login');
        });

post('/login', function(Bones $app) {
          $user = new User();
          $user->name = $app->form('username');
          if ($user->login($app->form('password'))):
            $app->set('success', 'You are now logged in!');
            $app->render("home");
          else:
            $app->render('user/login');
          endif;
        });

get('/logout', function(Bones $app) {
          User::logout();
          $app->redirect('/');
        });
#PROFILE
get("/user/:username", function(Bones $app) {
          $app->set('user', User::get_by_username($app->request("username")));
          $app->set('is_current_user', ($app->request("username") == User::current_user() ? true : false));
          $app->set("posts", Post::get_posts_by_user($app->request("username")));
          $app->set("post_count", Post::get_post_count_by_user($app->request("username")));
          $app->render('user/profile');
        });
#POSR
get('/post/delete/:id/:rev', function(Bones $app) {
          $post = new Post();
          $post->_id = $app->request("id");
          $post->_rev = $app->request("rev");
          if ($post->delete()):
            $app->flash_messenger->set("success", "Your post has been deleted");
          else:
            $app->flash_messenger->set("error", "Error deleting post");
          endif;
          $app->redirect("/user/" . User::current_user());
        });

post('/post', function(Bones $app) {
          if (User::is_authenticated()):
            $post = new Post();
            $post->content = $app->form('content');
            if ($post->create()):
              $app->set("success", "New post created");
              $app->flash_messenger->set("success", "New post created");
              $app->redirect("/user/" . User::current_user());
            endif;
          else:
            $app->set('error', "You must be logged in to do that.");
            $app->render('user/login');
          endif;
        });

#Routes not found
resolve();