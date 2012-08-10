<?php

require_once '../lib/bones.php';

class User extends Base {

  protected $name;
  protected $email;
  protected $full_name;
  protected $salt;
  protected $password_sha;
  protected $roles;

  public function __construct() {
    parent::__construct("user");
  }

  /**
   * returns true is user is signed up
   * @param string $username
   * @param string $password
   * @return boolean
   */
  function signup($username, $password) {
    $app = new Bones();
    $user = $this;
    $user->roles = array();
    $user->name = preg_replace('/[^a-z0-9-]/', '', strtolower($username));
    $user->_id = 'org.couchdb.user:' . $username;
    /** salt généré par la base couchdb * */
    $user->salt = $app->couch->generateIDs(1)->body->uuids[0];
    $user->password_sha = sha1($password . $user->salt);
    $app->couch->setDatabase('_users', true);
    $app->couch->login(USER, PASSWORD);
    try {
      $app->couch->put($user->_id, $user->to_json());
      return true;
    } catch (SagCouchException $e) {
      if ($e->getCode() == "409") {

      }
    }
  }

  function login($password) {
    $bones = new Bones();
    $bones->couch->setDatabase('_users');
    try {
      $bones->couch->login($this->name, $password, Sag::$AUTH_COOKIE);
      session_start();
      $_SESSION["username"] = $bones->couch->getSession()->body->userCtx->name;
      session_write_close();
      } catch (SagCouchException $e) {
      if ($e->getCode() == "401") {
        $bones->set("error", "Incorrect login credentials");
        $bones->render('user/login');
      }
    }
  }

  static function logout(){
    $bones = new Bones();
    $bones->couch->login(null, null);
    session_start();
    session_destroy();
  }

  static  function current_user(){
    session_start();
    return $_SESSION['username'];
    session_write_close();
  }

  static function is_authenticated(){
    if(self::current_user()){
      return true;
    }  else {
      return false;
    }
  }

  /** obtient un user par son username
   * @param string $username
   * @return User
   */
  static function get_by_username($username=null){
    $bones = new Bones();
    $bones->couch->setDatabase('_users');
    $bones->couch->login(USER,PASSWORD);
    $user = new User();
    /** obtenir un document par id **/
    $document=$bones->couch->get('org.couchdb.user:'.$username)->body;
    $user->_id=$document->_id;
    $user->name=$document->name;
    $user->email=$document->email;
    $user->full_name=$document->full_name;
    return $user;
  }
}

