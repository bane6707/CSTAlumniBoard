<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');

/**
 *
 */
class Post implements ModelInterface
{
    private $tableName = "Post";
    private $postID;
    private $content;
    private $isPinned;
    private $userID;
    private $threadID;

    public function __construct($content, $userID, $threadID)
    {
        $this->content = $content;
        $this->isPinned = 0;
        $this->userID = $userID;
        $this->threadID = $threadID;
    }

    public function loadPostByID($postID)
    {
        self::outputToConsole("inside Post:loadPostByID");
        $this->postID = $postID;
        $record = $this->getRecord();
        if(!empty($record))
        {
            $this->content = $record['content'];
            $this->isPinned = $record['isPinned'];
            $this->userID = $record['userID'];
            $this->threadID = $record['threadID'];
            return true;
        }
        self::outputToConsole("No record for postID=".$postID);
        return false;
    }

    public function pinPost()
    {
        self::outputToConsole("inside Post:pinPost");
        if(!$this->postID)
        {
            self::outputToConsole("Error- no postID associated with Post, cannot pin.");
            return false;
        }
        $nConn = new Connection();
        $arr = array('isPinned'=>'1');
        $nConn->update($this->tableName, $this->postID, $arr);

        // Check if isPinned value was changed to 1
        $record = $this->getRecord();
        if(!empty($record))
        {
            if($record['isPinned'] == 1)
            {
                $this->isPinned = 1;
                self::outputToConsole("Record pinned");
                return true;
            }
        }
        self::outputToConsole("Record not pinned");
        return false;
    }

    public function unpinPost()
    {
        self::outputToConsole("inside Post:unpinPost");
        if(!$this->postID)
        {
            self::outputToConsole("Error- no postID associated with Post, cannot unpin.");
            return false;
        }

        $nConn = new Connection();
        $arr = array('isPinned'=>'0');
        $nConn->update($this->tableName, $this->postID, $arr);

        // Check if isPinned value was changed to 0
        $record = $this->getRecord();
        if(!empty($record))
        {
            if($record['isPinned'] == 0)
            {
                $this->isPinned = 0;
                self::outputToConsole("Record unpinned");
                return true;
            }
        }
        self::outputToConsole("Record not unpinned");
        return false;
    }

    public function getPostID()
    {
        return $this->postID;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTimeCreated()
    {
        return $this->timeCreated;
    }
    public function getIsPinned()
    {
        return $this->isPinned;
    }
    public function getUserID()
    {
        return $this->userID;
    }
    public function getThreadID()
    {
        return $this->threadID;
    }

    public function save()
    {
        $nConn = new Connection();
        $arr = array('content'=>$this->content,'isPinned'=>$this->isPinned, 'userID'=>$this->userID, 'threadID'=>$this->threadID);
        $this->postID = $nConn->save($this->tableName, $arr);
    }

    public function delete()
    {
        if($this->postID === "")
            return;
        $nConn = new Connection();
        $nConn->delete($this->tableName, $this->postID);
    }

    public function update()
    {
        self::outputToConsole("inside Post:update");
        $nConn = new Connection();
        $arr = array('content'=>$this->content,'isPinned'=>$this->isPinned, 'userID'=>$this->userID, 'threadID'=>$this->threadID);
        $nConn->update($this->tableName, $this->postID, $arr);
    }

    public function getRecord()
    {
        if($this->postID === "")
            return;
        $nConn = new Connection();
        return $nConn->getRecord($this->tableName, $this->postID);
    }

    public function findById(){

    }

    public static function outputToConsole($message)
    {
        echo "<script>console.log('" . $message . "');</script>";
    }
}

?>
