<?php

class Bootstrap{
  static function make_input($id,$label,$type="text",$value=''){
    return "<label for='$id'>$label</label><input class='input-large' id='$id' name='$id' type='$type' value='$value' />";
  }
}