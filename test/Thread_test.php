<?php
require('../model/Thread.php');

/**
 *
 */
class Thread_test
{
  function __construct()
  {
    $nThread = new Thread('Test Create', 1, 1);
    echo "\nThread test 1:\n";
    $nThread->save();
    echo "\nThread test 2:\n";
    $nThread->update();
    echo "\nThread test 3:\n";
    $nThread->pinThread();
    $nThread->unpinThread();
    echo "\nThread test 4:\n";
    $nThread->getRecord();
    echo "\nThread test 5:\n";
    $nThread->delete();
  }
}

?>