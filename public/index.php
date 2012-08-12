<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . "/../lib/sag/src/Sag.php";

require_once __DIR__ . "/../lib/bootstrap.php";

function __autoload($classname) {
  include_once(__DIR__ . "/../classes/" . strtolower($classname) . ".php");
}


$app = new Silex\Application();

/** activer twig * */
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));

$app["debug"] = true;

#BOOTSTRAP HELPER
$app["bootstrap"]=$app->share(function(){
  return new Bootstrap();
});

#COUCHDB service
$app["couch"] = $app->share(function() {
          return new Sag();
        });

#HOME
$app->get("/", function(Silex\Application $app) {
          return $app["twig"]->render('home.twig', array('message' => "Welcome to Verge !!"));
        });
#SIGNUP
$app->get("/signup",function(Silex\Application $app){
  return $app["twig"]->render("user/signup.twig");
});
#POST SIGN UP
$app->post('/signup',function(Silex\Application $app){

});

$app->run();