<?php
session_start();
/**
 * One needs to define connection settings in a connection.php file :
 *
 * define("USER","user");
 * define("PASSWORD","pass");
 * define("COUCHDB_SERVER","server");
 * define("DATABASE","database");
 *
 */
ini_set("display_errors", "On");
error_reporting(E_ERROR | E_PARSE | E_WARNING | E_USER_ERROR | E_STRICT);

define('ROOT', __DIR__ . '/..');
require_once ROOT . '/lib/sag/src/Sag.php';
require_once ROOT . '/lib/connection.php';
require_once ROOT . '/lib/bootstrap.php';

function __autoload($classname) {
  include_once(ROOT . "/classes/" . strtolower($classname) . ".php");
}

function get($route, $callback) {
  Bones::register($route, $callback, "GET");
}

function post($route, $callback) {
  Bones::register($route, $callback, "POST");
}

function put($route, $callback) {
  Bones::register($route, $callback, "PUT");
}

function delete($route, $callback) {
  Bones::register($route, $callback, 'DELETE');
}

function resolve() {
  Bones::resolve();
}

/** framework * */
class Bones {

  protected static $instance;
  public static $route_found = false;
  public $route = "";
  public $method = "";

  /**
   *
   * @var array
   */
  public $vars = array();

  /**
   *
   * @var array
   */
  public $route_segments = array();

  /**
   *
   * @var array
   */
  public $route_variables = array();

  /**
   *
   * @var Sag
   */
  public $couch;

  /**
   * @var FlashMessenger
   */
  public $flash_messenger;

  /**
   * singleton
   *
   * @return Bones
   */
  public static function get_instance() {
    if (!isset(self::$instance)):
      self::$instance = new Bones();
    endif;
    return self::$instance;
  }

  /** créer un nouveau Bone object* */
  function __construct() {
    $this->route = $this->get_route();
    $this->route_segments = explode('/', trim($this->route, '/'));
    $this->method = $this->get_method();
    $this->couch = new Sag(COUCHDB_SERVER);
    $this->couch->login(USER, PASSWORD);
    $this->couch->setDatabase(DATABASE, true);
    $this->flash_messenger = new FlashMessenger();
  }

  protected function get_route() {
    /*
      parse_str — Parses the string into variables
      void parse_str ( string $str [, array &$arr ] )
     */
    parse_str($_SERVER['QUERY_STRING'], $route);
    if ($route) {
      return "/" . $route["request"];
    } else {
      return "/";
    }
  }

  public function get_method() {
    return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
  }

  public function set($index, $value) {
    $this->vars[$index] = $value;
  }

  public function render($view, $layout = "layout") {
    $this->content = ROOT . '/views/' . $view . '.php';
    foreach ($this->vars as $key => $value) {
      $$key = $value;
    }
    if ($layout == null) {
      require($this->content);
    } else {
      ob_start();
      require(ROOT . '/views/' . $layout . '.php');
      $result = ob_get_flush();
      return $result;
    }
  }

  public function form($key) {
    return $_POST[$key];
  }

  public function make_route($path = "") {
    $url = explode("/", $_SERVER["PHP_SELF"]);
    if ($url[1] == "index.php") {
      return $path;
    } else {
      return "/" . $url[1] . $path;
    }
  }

  public function request($key) {
    return $this->route_variables[$key];
  }

  function redirect($path = "/") {
    header('Location: ' . $this->make_route($path));
  }

  public static function resolve() {
    if (!static::$route_found) {
      $bones = static::get_instance();
      $bones->error404();
    }
  }

  /**
   * enregistre une route ,
   * un callback et une méthode http dans bones
   */
  public static function register($route, $callback, $method) {
    if (!self::$route_found):
      $bones = self::get_instance();
      $url_parts = explode("/", trim($route, "/"));
      $matched = null;

      if (count($bones->route_segments) == count($url_parts)):
        foreach ($url_parts as $key => $part):
          if (strpos($part, ':') !== false):
            //contains a route variable
            $bones->route_variables[substr($part, 1)] =
                    $bones->route_segments[$key];
          else:
            //doesnt contains a route variable
            if ($part == $bones->route_segments[$key]):
              if (!$matched):
                $matched = true;
              endif;
            else:
              //routes dont match
              $matched = false;
            endif;
          endif;
        endforeach;
      else:
        //routes are different lengths
        $matched = false;
      endif;

      if (!$matched || $bones->method != $method):
        return false;
      else:
        static::$route_found = true;
        echo $callback($bones);
      endif;
    endif;
  }

  /** helpers * */

  /** affiche un message flash * */
  function display_alert($variable) {
    if (isset($this->vars[$variable])) {
      return "<div class='alert alert-$variable'><a class='close' data-dismiss='alert'>x</a>" . $this->vars[$variable] . "</div>";
    }
  }

  function displayFlashMessage($variable) {
    $message = $this->flash_messenger->get($variable);
    if ($message):
      return "<div class='alert alert-$variable'><a class='close' data-dismiss='alert'>x</a>" . $message . "</div>";
    endif;
  }

  function error500($exception) {
    $this->set("exception", $exception);
    $this->render('error/500');
    exit;
  }

  function error404() {
    $this->render('error/404');
    exit;
  }

}