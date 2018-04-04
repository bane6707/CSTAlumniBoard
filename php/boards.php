<?php
require_once('../common/connection.php');
// Initialize the session

session_start();


// If session variable is not set it will redirect to login page

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit;
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
        <h3> List of Forums </h3>
        <h4> Posting will be available soon. </h4>
        <table>
            <?php
                $nQuery = "SELECT FORUM.title, THREAD.topic, THREAD.timeCreated FROM THREAD JOIN FORUM ON THREAD.forumID=FORUM.forumID";
                $nConn = new Connection();
                $records = $nConn->getQuery($nQuery);
                echo "<th><span>Forum</span></th>";
                echo "<th><span>Thread</span></th>";
                echo "<th><span>Created</span></th>";
                foreach($records as $record)
                {
                    echo "<tr>";
                    $record = $records->fetch_assoc();
                    foreach($record as $col)
                    {
                        echo "<td>" .$col. "</td>";
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