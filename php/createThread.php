<?php
require_once('../common/connection.php');
include_once('../model/User.php');
include_once('../model/Forum.php');
include_once('../model/Thread.php');
include_once('../model/Post.php');

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

// Create thread
if(isset($_POST["topic"]) && isset($_POST["content"]))
{
    $postTopic = addslashes($_POST["topic"]);
    $postContent = addslashes($_POST["content"]);
    $forumID=$_GET["forumID"];
    $thread = new Thread($postTopic, $_SESSION['userID'], $forumID);
    $threadID = $thread->save();
    if($threadID!=0)
    {
        $post = new Post($postContent, $_SESSION['userID'], $threadID);
        $postID = $post->save();
        // Subscribe to forum
        $forum = new Forum("", "");
        $forum->loadForumByID($forumID);
        $forum->subscribe($_SESSION['user']);

        // Notify all subscribers
        $forum->notifySubscribers($thread);
        header("location: displayForumThreads.php?forumID=$forumID");
    }
}

$forum = "";
$startIndex = 0;

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
        <h3> Create New Thread </h3>

        <h4> A thread is a series of posts related to a topic. An initial post is created to describe the thread topic.</h4>
        <table id="forumTable">
            <form action="" method="post">
            <tr><th>Forum</th></tr>
            <tr><td>Title: <i><b><?php echo $selectedForum->getTitle()?></b></i></td></tr>
            <tr><th>Create Thread</th></tr>
            <tr><td>Topic: <input type="text" size="20" name="topic" required/></td></tr>
            <tr><td>
            Description:<br>
            <textarea name="content" rows="15" cols="100" style="width:98%;" required></textarea>    
            </td></tr>
            <tr><th>Submit</th></tr>
            <tr><td class="center" colspan="1">
                <input type="submit" class="submitBtn" value="Submit"/>
            </td></tr>
            </form>
        </table>
        <br>
        <table><tr>
            <td class="center" colspan="1">
                <input class="defaultBtn" type="button" value="Return to Boards" onclick="window.location.href='./boards.php'" />
            </td>
        </tr></table>
    </div>
    <br>
    <br>
    </body>
</html>