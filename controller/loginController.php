<?php
    include("../model/User.php");
    if(isset($_POST["email"]) && isset($_POST["pass"]))
    {
      //echo $_POST["pass"]." ,".$_POST["email"];
      $usr = new User("","", $_POST["pass"], $_POST["email"]);
      $res = $usr->checkUser();

      //echo "--$res--";
      if($res == "1")
      {
        session_start();
        $_SESSION['username'] = $_POST["email"];
        $_SESSION['login'] = "Y";
        //login successful
        header("location: ../php/boards.php");
      }
      else
      {
          header("location: ../view/loginPage.php?ERRNO=ERR101");
      }
    }
?>
