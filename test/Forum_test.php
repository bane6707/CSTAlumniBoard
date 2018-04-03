<?php
require('../model/Forum.php');

/**
 *
 */
class Forum_test
{

  function __construct()
  {
    $nForum = new Forum("1st Forum", 1);
    echo "\nForum test 1:\n";
    $nForum->save();
    echo "\nForum test 2:\n";
    $nForum->update();
    echo "\nForum test 3:\n";
    $nForum->getRecord();
    echo "\nForum test 4:\n";
    $nForum->delete();
  }
}


?>
