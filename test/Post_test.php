<?php
require('../model/Post.php');

/**
 *
 */
class Post_test
{
  function __construct()
  {
    $nPost = new Post('Test Create', 1, 31);
    echo "\nPost test 1:\n";
    $nPost->save();
    echo "\nPost test 2:\n";
    $nPost->update();
    echo "\nPost test 3:\n";
    $nPost->pinPost();
    $nPost->unpinPost();
    echo "\nPost test 4:\n";
    $nPost->getRecord();
    echo "\nPost test 5:\n";
    $nPost->delete();
  }
}

?>