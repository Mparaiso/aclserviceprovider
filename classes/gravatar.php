<?php

/*
 * Gravatar helper
 *
 */
class Gravatar{
  /**
   *
   * @var string
   */
  protected static $url = "http://www.gravatar.com/avatar/";

  /**
   * returns a gravatar url
   * @param string $email
   * @param string $size
   * @return string
   */
  static function getGravatar($email,$size=50){
    return self::$url."?gravatar_id=".md5(strtolower($email))."&size=$size";
  }
}
