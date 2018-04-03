<?php

include('User_test.php');
include('Forum_test.php');
include('Thread_test.php');
include('Post_test.php');

echo "\nRunning User tests\n";
$ut = new User_test();

echo "\n\nRunning Forum tests";
$ft = new Forum_test();

echo "\n\nRunning Thread tests";
$tt = new Thread_test();

echo "\n\nRunning Post tests";
$pt = new Post_test();
?>
