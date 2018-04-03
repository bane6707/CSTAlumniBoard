<?php
require('../model/Forum.php');

/**
 *
 */
class Forum_test
{

  function __construct()
  {
    $nForum = new Forum("1st Forum");
    $nForum->save();
  }
}


?>
