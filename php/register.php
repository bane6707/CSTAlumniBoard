<!DOCTYPE html>
<head>
    <title>CST Alumni Board</title>
    <link href="../css/index.css" text="text/css" rel="stylesheet"/>
    <?php
        include("../model/User.php");
        include("../model/UserFactory.php");
        
        function matchesEnd($str, $end)
        {
            return substr($str, -strlen($end)) == $end ? true : false;
        }

        $csumbEmail = "@csumb.edu";
        $user = "";
        $msgs = [];
        $success = false;
        
        if(isset($_POST["fName"]) && isset($_POST["lName"])
            && isset($_POST["email"]) && isset($_POST["password"])
            && isset($_POST["confirmPass"]))
        {
            if($_POST["password"] != $_POST["confirmPass"])
                array_push($msgs, "Passwords do not match");
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                array_push($msgs, "Invalid Email");
            else
            {
                if(!matchesEnd($_POST["email"], $csumbEmail))
                    array_push($msgs, "Not a Valid CSUMB Email");
            }

            if(empty($msgs))
            {
                $userFactory = new UserFactory();
                $userType = $userFactory->getUserType($_POST["userType"]);
                $user = $userType->getUser($_POST["fName"], $_POST["lName"], $_POST["password"], $_POST["email"]);
                if(!is_null($user))
                    $success = true;
            }
        }
        
    ?>
</head>
<body>
<table>
    <tr>
        <td><img src="../resources/images/CSUMBsmall.png" width="100px" height="auto" alt="otter"></td>
        <td><h1>CST Alumni Board</h1></td>
    </tr>
</table>
<?php
    if($success)
    {   
        header("location:./registerSuccess.php");
        die;
    }
    else if(isset($_POST["fName"]) && empty($msgs))
        array_push($msgs, "An account already exists with this email");
    
    if(!empty($msgs))
    {   
        echo '<div id="msgs"><table>';
        foreach($msgs as $msg)
            echo "<tr><td><p>*". $msg ."</p></td></tr>";
        echo '</table></div>';
    }
?>
<div id="wrap">
    <h3> Create an Account </h3>
    <h4>Please enter your information to create your account</h4>
    <table>
        <form action="" method="post">
        <tr>
            <td>
                <label for "fName" class="require"> First Name: </label>
            </td>
            <td>
                <input type="text" size="20" name="fName" value="<?php if (isset($_POST['fName'])) echo $_POST['fName']?>" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label for "lName" class="require"> Last Name: </label>
            </td>
            <td>
                <input type="text" size="20" name="lName" value="<?php if (isset($_POST['lName'])) echo $_POST['lName']?>" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label for "email" class="require"> CSUMB Email: </label>
            </td>
            <td>
                <input type="text" size="20" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']?>" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label for "password" class="require"> Password: </label>
            </td>
            <td>
                <input type="password" size="20" name="password" value="" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label for "confirmPass class="require""> Password Confirmation: </label>
            </td>
            <td>
                <input type="password" size="20" name="confirmPass" value="" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="container"><i>Standard </i>
                <input type="radio" name="userType" value="Standard" checked>
                </label>
            </td><td>
                <label class="container"><i>Moderator </i>
                <input type="radio" name="userType" value="Moderator">
                </label>
            </td><td>
                <label class="container"><i>Admin </i>
                <input type="radio" name="userType" value="Admin">
                </label>
            </td>
        </tr>
        <tr>
            <td class="center" colspan="1">
                <input type="submit" class="submitBtn" value="Register"/>
            </td>
            <td class="center" colspan="1">
                <input type="button" value="I have an account" onclick="window.location.href='../view/loginPage.php'" />
            </td>
        </tr>
        </form>
    </table>
</div>
</body>
</html>