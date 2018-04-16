<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');

/**
 *
 */
class Notification implements ModelInterface
{
    private $tableName = "Notification";
    private $notificationID = "";
    private $userID = "";
    private $content = "";
    private $threadID = "";

    public function __construct($userID, $content, $threadID)
    {
        $this->userID = $userID;
        $this->content = $content;
        $this->threadID = $threadID;
    }

    public function loadNotificationByID($notificationID)
    {
        //echo "inside Notification:loadNotificationByID\n";
        $this->notificationID = $notificationID;
        $record = $this->getRecord();
        if(!empty($record))
        {
            $this->notificationID = $record['notificationID'];
            $this->userID = $record['userID'];
            $this->content = $record['content'];
            $this->threadID = $record['threadID'];
            return true;
        }
        //echo "No record for notificationID=".$notificationID."\n";
        return false;
    }

    public function getNotificationID()
    {
        return $this->notificationID;
    }
    public function getUserID()
    {
        return $this->userID;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getThreadID()
    {
        return $this->threadID;
    }

    public function save()
    {
        $nConn = new Connection();
        $arr = array('userID'=>$this->userID,'content'=>$this->content, 'threadID'=>$this->threadID);
        $this->notificationID = $nConn->save($this->tableName, $arr);
        return $this->notificationID;
    }

    public function delete()
    {
        if($this->notificationID === "")
            return;
        $nConn = new Connection();
        $nConn->delete($this->tableName, $this->notificationID);
    }

    public function update()
    {
        //echo "inside Notification:update\n";
        $nConn = new Connection();
        $arr = array('userID'=>$this->userID,'content'=>$this->content, 'threadID'=>$this->threadID);
        $nConn->update($this->tableName, $this->notificationID, $arr);
    }

    public function getRecord()
    {
        if($this->notificationID === "")
            return;
        $nConn = new Connection();
        return $nConn->getRecord($this->tableName, $this->notificationID);
    }

    public function findById(){

    }
}

?>
