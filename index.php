<!DOCTYPE html>
<?php
if(!$_SESSION['login'])
{
   header("location:php/login.php");
   die;
}
?>
<head>
    <title>CST Alumni Board</title>
    <link href="./css/index.css" text="text/css" rel="stylesheet"/>
</head>
<body>
<table>
    <tr>
        <td><img src="resources/images/CSUMBsmall.png" width="100px" height="auto" alt="otter"></td>
        <td><h1>CST Alumni Board</h1></td>
    </tr>
</table>
<div id="wrap">
    <h3>Welcome!</h3>
    <h4>You are logged in.</h4>
</div>
</body>
</html>