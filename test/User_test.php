<?php

require('../model/User.php');

/**
 *
 */
class User_test
{

  function __construct()
  {
    $nUser = new User("D", "B", "password", "dbanerjee@csumb.edu");
    $nUser->save();
  }
}

?>
