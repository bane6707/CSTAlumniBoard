<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');
require_once("Publisher.php");

/**
 *
 */
class Forum implements ModelInterface, Publisher
{
  private $forumID = "";
  private $title = "";
  private $tableName = "Forum";
  private $createdTime = "";
  private $userID = "";
  private $subscribers = [];

  function __construct($title, $userID)
  {
    $this->title = $title;
    $this->userID = $userID;
  }

  public function save()
  {
    //echo "inside Forum:save\n";
    $nConn = new Connection();
    $arr = array('title'=>$this->title, 'userID'=>$this->userID);
    $this->forumID = $nConn->save($this->tableName, $arr);
    return $this->forumID;
  }

  public function delete()
  {
    if($this->forumID === "")
      return;
    $nConn = new Connection();
    $nConn->delete($this->tableName, $this->forumID);
  }

  public function setTitle()
  {
    if($this->forumID === "")
      return;
    $nConn = new Connection();
    $nConn->delete($this->tableName, $this->forumID);
  }

  public function update()
  {
    //echo "inside Forum:update\n";
    $nConn = new Connection();
    $arr = array('title'=>$this->title, 'userID'=>$this->userID);
    $nConn->update($this->tableName, $this->forumID, $arr);
  }

  public function getRecord()
  {
    if($this->forumID === "")
      return;
    $nConn = new Connection();
    return $nConn->getRecord($this->tableName, $this->forumID);
  }

  public function findById()
  {
    
  }

  public function subscribe($user)
  {
      $userID = $user->getUserID();
      $subscribers[$userID] = $user;
      $nQuery = "INSERT INTO FORUM_SUBSCRIPTION (forumID, userID) VALUES ($this->forumID, $userID)";
      $nConn = new Connection();
      $nConn->getQuery($nQuery);
  }

  public function unsubscribe($user)
  {
      unset($subscribers[$user->getUserID()]);
      $userID = $user->getUserID();
      $nQuery = "DELETE FROM FORUM_SUBSCRIPTION WHERE forumID=$this->forumID AND userID=$userID";
      $nConn = new Connection();
      $nConn->getQuery($nQuery);
  }

  public function notifySubscribers()
  {
      foreach($subscribers as $subscriber)
      {
          $subscriber->notify($forumID);
      }
  }

  public function loadForumByID($forumID)
  {
    //echo "inside Forum:loadForumByID\n";
    $this->forumID = $forumID;
    $record = $this->getRecord();
    if(!empty($record))
    {
        $this->forumID = $record['forumID'];
        $this->title = $record['title'];
        $this->userID = $record['userID'];
        $nQuery = "SELECT USER.userID FROM USER
          JOIN FORUM_SUBSCRIPTION ON USER.userID = FORUM_SUBSCRIPTION.userID
          JOIN FORUM ON FORUM.forumID = FORUM_SUBSCRIPTION.forumID
          WHERE FORUM.forumID = $forumID";
        $nConn = new Connection();
        $records = $nConn->getQuery($nQuery);
        
        while($row = $records->fetch_array())
        {
          $subscriber = new User("", "", "", "");
          $subscriber->loadUserByID($row["userID"]);
          $subscribers[$subscriber->getUserID()] = $subscriber;
        }
        return true;
    }
    //echo "No record for forumID=".$forumID."\n";
    return false;
  }

  public function getForumID()
  {
    return $this->forumID;
  }
  public function getTitle()
  {
    return $this->title;
  }
  public function getUserID()
  {
    return $this->userID;
  }
}


?>
