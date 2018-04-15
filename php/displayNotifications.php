<?php
require_once('../common/connection.php');
include_once('../model/User.php');
include_once('../model/Notification.php');

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
}

$nConn = new Connection();

// Create a $user and store it for session 
if(!isset($_SESSION['user']) || empty($_SESSION['user']))
{
    $email = $_SESSION['username'];
    $nQuery = "SELECT userID FROM USER WHERE email='$email'";
    $records = $nConn->getQuery($nQuery);
    $row = $records->fetch_array();
    $user = new User("", "", "", "");
    $id = $row["userID"];
    $user->loadUserByID($id);
    $_SESSION['user'] = $user;
    $_SESSION['userID'] = $_SESSION['user']->getUserID();
}

$subscribed = false;
$unsubscribed = false;
$forum = "";
$startIndex = 0;

// Subscribe to forum selected
if(isset($_POST['sub']) && !empty($_POST['sub'])){
    $forum = new Forum("", "");
    $forum->loadForumByID($_POST['sub']);
    $forum->subscribe($_SESSION['user']);
    $subscribed = true;
}

// Unsubscribe from forum selected
if(isset($_POST['unsub']) && !empty($_POST['unsub'])){
    $forum = new Forum("", "");
    $forum->loadForumByID($_POST['unsub']);
    $forum->unsubscribe($_SESSION['user']);
    $unsubscribed = true;
}

?>
<!DOCTYPE html>
    <head>
        <title>CST Alumni Board</title>
        <link href="../css/index.css" text="text/css" rel="stylesheet"/>
    </head>

    <body>
        <table id="topTable">
            <tr>
                <td>
                    <input type="button" class="defaultBtn" value="Logout" onclick="window.location.href='./logout.php'" />
                </td>
                <td width="97%">
                    <h3>Signed in as <b><?php echo $_SESSION['user']->getFirstName() . " ".$_SESSION['user']->getLastName()."</b>.";?></h3>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="button" class="defaultBlueBtn" value="Notifications" onclick="window.location.href='./displayNotifications.php'" />
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td><img src="../resources/images/CSUMBsmall.png" width="100px" height="auto" alt="otter"></td>
                <td><h1>CST Alumni Board</h1></td>
            </tr>
        </table>
    <div id="wrap">
        <h3> Notifications </h3>

        <h4> Here are the recently added threads to your subscribed Forums. </h4>
        <table id="forumTable">
            <?php
                $userID = $_SESSION["userID"];
                $nQuery = "SELECT notificationID, content, THREAD.threadID, timeNotified
                    FROM NOTIFICATION JOIN THREAD
                    ON NOTIFICATION.threadID=THREAD.threadID
                    WHERE NOTIFICATION.userID=$userID
                    ORDER BY timeNotified DESC LIMIT $startIndex, 20;";
                $records = $nConn->getQuery($nQuery);
                echo "<tr><th><span>Message</span></th>";
                echo "<th><span>Notified</span></th></tr>";
                while($row = $records->fetch_array())
                {
                    echo "<tr>";
                    $date = date_create($row["timeNotified"]);
                    $date = date_format($date, 'g:ia \o\n n/j/Y');
                    $threadID=$row["threadID"];
                    echo "<td><a href='displayThreadPosts.php?threadID=$threadID'>" .$row["content"]. "</td>";
                    echo "<td>" .$date. "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <table><tr>
            <td class="center" colspan="1">
                <input class="defaultBtn" type="button" value="Return to Boards" onclick="window.location.href='./boards.php'" />
            </td>
        </tr></table>
    </div>
    </body>
</html>