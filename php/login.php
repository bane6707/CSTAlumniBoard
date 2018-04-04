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
        //login successful
        header("location: ./boards.php");
      }
      else
      {
          $unsuccessful=1;
      }
    }
?>

<!DOCTYPE html>
<head>
    <title>CST Alumni Board</title>
    <link href="../css/index.css" text="text/css" rel="stylesheet"/>
</head>
<body>
<table>
    <tr>
        <td><img src="../resources/images/CSUMBsmall.png" width="100px" height="auto" alt="otter"></td>
        <td><h1>CST Alumni Board</h1></td>
    </tr>
</table>
<div id="wrap">
    <h3> Sign In to CST Alumni Board </h3>
    <?php
        if($unsuccessful==1)
            echo "<h4>INCORRECT EMAIL OR PASSWORD</h4>";
    ?>
    <h4>Please enter your email and password.</h4>
    <table>
        <form action="" method="post">
        <tr>
            <td>
                <label for "email" class="require"> CSUMB Email: </label>
            </td>
            <td>
                <input type="text" size="20" name="email" value="" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label for "pass" class="require"> Password: </label>
            </td>
            <td>
                <input type="password" size="20" name="pass" value="" required/>
            </td>
        </tr>
        <tr>
            <td class="center" colspan="1">
                <input type="submit" class="submitBtn" value="Sign In"/>
            </td>
            <td class="center" colspan="1">
                <input type="button" value="Create an account" onclick="window.location.href='./register.php'" />
            </td>
        </tr>
        </form>
    </table>
</div>
</body>
</html>
