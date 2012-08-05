<?php
ini_set("display_errors","On");
error_reporting(E_ERROR | E_PARSE);

function get($route,$callback){
	Bones::register($route,$callback);
}
/** framework **/
class Bones{
	protected static $instance;
	public static $route_found =false;
	public $route="";
	/** singleton **/
	public static function get_instance(){
		if(!isset(self::$instance)):
			self::$instance=new Bones();
		endif;
		return self::$instance;
	}
	protected function __construct(){
		$this->route=$this->get_route();
	}
	protected function get_route(){
		/*
		parse_str — Parses the string into variables
		void parse_str ( string $str [, array &$arr ] ) 
		*/
		parse_str($_SERVER['QUERY_STRING'],$route);
		if($route){
			return "/".$route["request"];
		}else{
			return "/";
		}
	}
	public static function register($route,$callback){
		$bones=static::get_instance();
		if($route==$bones->route && !static::$route_found){
			static::$route_found=true;
			echo $callback($bones);
		}else{
			return false;
		}
	}
}