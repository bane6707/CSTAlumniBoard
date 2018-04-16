<?php

/**
 *
 */
interface Subscriber
{
  public function notify($ID, $obj);
  public function getUserID();
}


 ?>
