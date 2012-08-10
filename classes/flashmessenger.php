<?

class FlashMessenger {

  function __construct() {
    if(!isset($_SESSION["flash-messenger"])):
      $_SESSION["flash-messenger"]=array();
    endif;
  }

  function set($index = null, $message = null) {
    if (isset($index) && isset($message)):
      $_SESSION["flash-messenger"][$index] = $message;
      return $message;
    endif;
  }

  function get($index) {
    if (isset($index)):
      $message = $_SESSION["flash-messenger"][$index];
      unset($_SESSION["flash-messenger"][$index]);
      return $message;
    endif;
  }

}