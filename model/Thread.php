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
        global $connection;
        $sql = "SELECT *
                FROM THREAD
                WHERE threadID = ?
                ";
        $stmt = $connection -> prepare($sql);
        $stmt->bindParam(1, $threadID, PDO::PARAM_INT);
        $stmt -> execute();
        $result = $stmt->fetch();
        if(!empty($result))
        {
            $this->threadID = $result['threadID'];
            $this->topic = $result['topic'];
            $this->isPinned = $result['isPinned'];
            $this->userID = $result['userID'];
            $this->forumID = $result['forumID'];
            return true;
        }
        return false;
    }

    public function pinThread()
    {
        if(!$this->threadID)
        {
            return false;
        }
        global $connection;
        $sqli = "UPDATE THREAD SET isPinned = 1 WHERE threadID = ? ";
        $stmti = $connection->prepare($sqli);
        $stmti->bind_param("i", $this->threadID);

        // Check if isPinned value was changed to 1
        $record = $this->getRecord();
        if(!empty($record))
        {
            if($record['isPinned'] === 1)
            {
                $this->isPinned = 1;
                return true;
            }
        }
        return false;
    }

    public function unpinThread()
    {
        if(!$this->threadID)
        {
            return false;
        }
        global $connection;
        $sqli = "UPDATE THREAD SET isPinned = 0 WHERE threadID = ? ";
        $stmti = $connection->prepare($sqli);
        $stmti->bind_param("i", $this->threadID);

        
        // Check if isPinned value was changed to 0
        $record = $this->getRecord();
        if(!empty($record))
        {
            if($record['isPinned'] === 0)
            {
                $this->isPinned = 0;
                return true;
            }
        }
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
        echo "inside Thread:update\n";
        $nConn = new Connection();
        $arr = array('topic'=>$this->topic,'isPinned'=>$this->isPinned, 'userID'=>$this->userID, 'forumID'=>$this->forumID);
        $nConn->update($this->tableName, $this->threadID, $arr);
    }

    public function getRecord()
    {
        if($this->threadID === "")
            return;
        $nConn = new Connection();
        $nConn->getRecord($this->tableName, $this->threadID);
    }

    public function findById(){

    }
}

?>
