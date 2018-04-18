<?php
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://localhost/CSTAlumniBoard/controller/loginController.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, true);

  $data = array(
    'email' => 'dbanerjee1@csumb.edu',
    'pass' => 'password'
  );

  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $output = curl_exec($ch);
  $info = curl_getinfo($ch);


  if (strpos($info["redirect_url"], "ERRNO") != false)
    echo "Login failed\n";
  else
    echo "Login passed\n";
  curl_close($ch);
?>
