<?php

require_once "base.php";

class Post extends Base {

  protected $date_created;
  protected $content;
  protected $user;

  function __construct() {
    parent::__construct("post");
  }

  function create() {
    $bones = new Bones();
    $this->_id = $bones->couch->generateIDs(1)->body->uuids[0];
    $this->date_created = date('r');
    $this->user = User::current_user();
    //commit
    try {
      $bones->couch->put($this->_id, $this->to_json());
      return true;
    } catch (SagCouchException $e) {
      $bones->error500($e);
    }
  }

}