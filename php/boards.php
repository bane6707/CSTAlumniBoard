<?php
require_once('../common/connection.php');
include_once('../model/User.php');
include_once('../model/Forum.php');
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
                <td><h3>Signed in as <b><?php echo $_SESSION['user']->getFirstName() . " ".$_SESSION['user']->getLastName()."</b>.";?></h3></td>
            </tr>
        </table>
        <table>
            <tr>
                <td><img src="../resources/images/CSUMBsmall.png" width="100px" height="auto" alt="otter"></td>
                <td><h1>CST Alumni Board</h1></td>
            </tr>
        </table>
    <div id="wrap">
        <h3> List of Forums </h3>
        <h4> Posting will be available soon. </h4>
        <table id="forumTable">
            <?php
                $userID = $_SESSION["userID"];
                $nQuery = "SELECT FORUM.forumID, FORUM.title, THREAD.topic, THREAD.timeCreated, SUM(IF(USER.userID=$userID, 1, 0)) AS subbed
                    FROM THREAD JOIN FORUM ON THREAD.forumID=FORUM.forumID
                    JOIN FORUM_SUBSCRIPTION ON FORUM.forumID=FORUM_SUBSCRIPTION.forumID
                    JOIN USER ON FORUM_SUBSCRIPTION.userID=USER.userID
                    GROUP BY THREAD.threadID ORDER BY FORUM.title LIMIT $startIndex, 20";
                $records = $nConn->getQuery($nQuery);
                echo "<tr><th><span>Forum</span></th>";
                echo "<th><span>Thread</span></th>";
                echo "<th><span>Created</span></th><th width='120px'></th></tr>";
                $forumTitle = "";
                while($row = $records->fetch_array())
                {
                    echo "<tr>";
                    $date = date_create($row["timeCreated"]);
                    $date = date_format($date, 'g:ia \o\n n/j/Y');
                    if($forumTitle == $row["title"])
                    {
                        // Do not include first and last columns for threads in same forum
                        echo "<td> </td>";
                        echo "<td>" .$row["topic"]. "</td>";
                        echo "<td>" .$date. "</td>";
                        echo "<td> </td>";
                    }
                    else
                    {
                        $forumTitle = $row["title"];
                        echo "<td>" .$forumTitle. "</td>";
                        echo "<td>" .$row["topic"]. "</td>";
                        echo "<td>" .$date. "</td>";
                        echo '<td><form method="POST">';
                        // Checked subscribed to determine appropriate button
                        if($row['subbed']==0)
                            echo '<button type="submit" id="sub" name="sub" value="'. $row["forumID"] .'">Subscribe</button>';
                        else
                            echo '<button type="submit" id="unsub" name="unsub" value="'. $row["forumID"] .'">Unsubscribe</button>';
                        echo '</form></td>';
                    }
                    echo "</tr>";
                }
            ?>
        </table>
        <table><tr>
            <td class="center" colspan="1">
                <input type="button" value="Logout" onclick="window.location.href='./logout.php'" />
            </td>
        </tr></table>
    </div>
    </body>
</html>