<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');

/**
 *
 */
class Thread implements ModelInterface
{
    private $tableName = "Thread";
    private $threadID;
    private $topic;
    private $isPinned;
    private $userID;
    private $forumID;

    public function __construct($topic, $userID, $forumID)
    {
        $this->topic = $topic;
        $this->isPinned = 0;
        $this->userID = $userID;
        $this->forumID = $forumID;
    }

    public function loadThreadByID($threadID)
    {
        //echo "inside Thread:loadThreadByID\n";
        $this->threadID = $threadID;
        $record = $this->getRecord();
        if(!empty($record))
        {
            $this->threadID = $record['threadID'];
            $this->topic = $record['topic'];
            $this->isPinned = $record['isPinned'];
            $this->userID = $record['userID'];
            $this->forumID = $record['forumID'];
            return true;
        }
        //echo "No record for threadID=".$threadID."\n";
        return false;
    }

    public function pinThread()
    {
        //echo "inside Thread:pinThread\n";
        if(!$this->threadID)
        {
            //echo "Error- no threadID associated with Thread, cannot pin.";
            return false;
        }
        $nConn = new Connection();
        $arr = array('isPinned'=>'1');
        $nConn->update($this->tableName, $this->threadID, $arr);

        // Check if isPinned value was changed to 1
        $record = $this->getRecord();
        if(!empty($record))
        {
            if($record['isPinned'] == 1)
            {
                $this->isPinned = 1;
                //echo "\nRecord pinned\n";
                return true;
            }
        }
        //echo "\nRecord not pinned\n";
        return false;
    }

    public function unpinThread()
    {
        //echo "inside Thread:unpinThread\n";
        if(!$this->threadID)
        {
            //echo "Error- no threadID associated with Thread, cannot unpin.";
            return false;
        }

        $nConn = new Connection();
        $arr = array('isPinned'=>'0');
        $nConn->update($this->tableName, $this->threadID, $arr);

        // Check if isPinned value was changed to 0
        $record = $this->getRecord();
        if(!empty($record))
        {
            if($record['isPinned'] == 0)
            {
                $this->isPinned = 0;
                //echo "\nRecord unpinned\n";
                return true;
            }
        }
        //echo "\nRecord not unpinned\n";
        return false;
    }

    public function getThreadID()
    {
        return $this->threadID;
    }

    public function getTopic()
    {
        return $this->topic;
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
    public function getForumID()
    {
        return $this->forumID;
    }

    public function save()
    {
        $nConn = new Connection();
        $arr = array('topic'=>$this->topic,'isPinned'=>$this->isPinned, 'userID'=>$this->userID, 'forumID'=>$this->forumID);
        $this->threadID = $nConn->save($this->tableName, $arr);
        return $this->threadID;
    }

    public function delete()
    {
        if($this->threadID === "")
            return;
        $nConn = new Connection();
        $nConn->delete($this->tableName, $this->threadID);
    }

    public function update()
    {
        //echo "inside Thread:update\n";
        $nConn = new Connection();
        $arr = array('topic'=>$this->topic,'isPinned'=>$this->isPinned, 'userID'=>$this->userID, 'forumID'=>$this->forumID);
        $nConn->update($this->tableName, $this->threadID, $arr);
    }

    public function getRecord()
    {
        if($this->threadID === "")
            return;
        $nConn = new Connection();
        return $nConn->getRecord($this->tableName, $this->threadID);
    }

    public function findById(){

    }
}

?>
