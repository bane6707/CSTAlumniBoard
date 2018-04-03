<?php

require('../model/User.php');

/**
 *
 */
class User_test
{

  function __construct()
  {
    $nUser = new User("bane6707", "password", "dbanerjee@csumb.edu");
    $nUser->save();
  }
}

?>
