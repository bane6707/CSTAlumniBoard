<?php
require_once('../common/connection.php');
include_once('../model/User.php');
include_once('../model/Forum.php');
// Initialize the session

session_start();


// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: ../view/loginPage.php");
    exit;
}

$nConn = new Connection();

$selectedForum = "";
if(!isset($_GET['forumID']) || empty($_GET['forumID'])){
    header("location: boards.php");
    exit;
}
else
{
    $selectedForum = new Forum("", "");
    $selectedForum->loadForumByID($_GET['forumID']);
}

// Create a $user and store it for session 
if(!isset($_SESSION['user']) || empty($_SESSION['user']))
{
    $email = $_SESSION['username'];
    $nQuery = "SELECT userID FROM USER WHERE email='$email'";
    $records = $nConn->getQuery($nQuery);
    $row = $records->fetch_array();
    $user = new User("", "", "", "", "");
    $id = $row["userID"];
    $user->loadUserByID($id);
    $_SESSION['user'] = $user;
    $_SESSION['userID'] = $_SESSION['user']->getUserID();
    $_SESSION['roleID'] = $_SESSION['user']->getRoleID();
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
        <h3> Forum: <?php echo $selectedForum->getTitle();?></h3>
        <h4> Posting will be available soon. </h4>
        <table id="forumTable">
            <?php
                $userID = $_SESSION["userID"];
                $forumID = $_GET["forumID"];
                $nQuery = "SELECT DISTINCT FORUM.forumID, FORUM.title, THREAD.topic, POST.timePosted,
                    POST.content, POST.originalPostID, POST.postID, THREAD.threadID
                    FROM THREAD JOIN FORUM ON THREAD.forumID=FORUM.forumID
                    LEFT JOIN FORUM_SUBSCRIPTION ON FORUM.forumID=FORUM_SUBSCRIPTION.forumID
                    LEFT JOIN USER ON FORUM_SUBSCRIPTION.userID=USER.userID
                    LEFT JOIN POST ON POST.threadID=THREAD.threadID
                    WHERE FORUM.forumID=$forumID AND originalPostID IS NULL
                    ORDER BY THREAD.threadID LIMIT $startIndex, 20 ;";
                $records = $nConn->getQuery($nQuery);
                echo "<tr><th><span>Thread</span></th>";
                echo "<th><span>Main Post</span></th>";
                echo "<th><span>Posted</span></th></tr>";
                $threadID = "";
                while($row = $records->fetch_array())
                {
                    echo "<tr>";
                    $date = date_create($row["timePosted"]);
                    $date = date_format($date, 'g:ia \o\n n/j/Y');
                    if($threadID == $row["threadID"])
                    {
                        // Do not include first and last columns for threads in same forum
                        echo "<td> </td>";
                        echo "<td>" .$row["content"]. "</td>";
                        echo "<td>" .$date. "</td>";
                    }
                    else
                    {
                        $threadID = $row["threadID"];
                        echo "<td><a href='displayThreadPosts.php?threadID=$threadID'>" .$row["topic"]. "</td>";
                        echo "<td>" .$row["content"]. "</td>";
                        echo "<td>" .$date. "</td>";
                        
                    }
                    echo "</tr>";
                }
            ?>
        </table>
        <table><tr>
            <td class="center">
                <input class="defaultBtn" type="button" value="Return to Boards" onclick="window.location.href='./boards.php'" />
            </td>
            <td class="center">
                <input class="defaultBlueBtn" type="button" value="Create Thread" onclick="window.location.href='./createThread.php?forumID=<?php echo $forumID?>'" />
            </td>
        </tr></table>
    </div>
    <br>
    <br>
    </body>
</html>