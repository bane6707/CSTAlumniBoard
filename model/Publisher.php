<?php
require_once('Subscriber.php');
/**
 *
 */
interface Publisher
{
  public function subscribe($subscriber);
  public function unsubscribe($subscriber);
  public function notifySubscribers($obj);
}


?>
