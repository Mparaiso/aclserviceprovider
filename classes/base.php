<?php

abstract class Base{
    protected $type;
    protected $_id;
    public function __construct($type) {
        $this->type=$type;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name=$value;
    }

    public function to_json(){
        return json_encode(get_object_vars($this));
    }
}