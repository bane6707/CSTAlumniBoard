<?php

require('User_test.php');
require('Forum_test.php');
require('Thread_test.php');

echo "\nRunning User tests\n";
$ut = new User_test();

echo "\n\nRunning Forum tests";
$ft = new Forum_test();

echo "\n\nRunning Thread tests";
$tt = new Thread_test();
?>
