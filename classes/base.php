<?php

abstract class Base {

  protected $type;
  protected $_id;
  protected $_rev;

  public function __construct($type) {
    $this->type = $type;
  }

  public function __get($name) {
    return $this->$name;
  }

  public function __set($name, $value) {
    $this->$name = $value;
  }

  public function to_json() {
    if (!isset($this->_rev)):
      unset($this->_rev);
    endif;
    return json_encode(get_object_vars($this));
  }

}