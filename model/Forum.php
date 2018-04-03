<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');

/**
 *
 */
class Forum implements ModelInterface
{
  private $forumID = "";
  private $title = "";
  private $tableName = "Forum";
  private $createdTime = "";
  private $userID = "";

  function __construct($title, $userID)
  {
    $this->title = $title;
    $this->userID = $userID;
  }

  public function save()
  {
    echo "inside Forum:save\n";
    $nConn = new Connection();
    $arr = array('title'=>$this->title, 'userID'=>$this->userID);
    $this->forumID = $nConn->save($this->tableName, $arr);
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
    echo "inside Forum:update\n";
    $nConn = new Connection();
    $arr = array('title'=>$this->title, 'userID'=>$this->userID);
    $nConn->update($this->tableName, $this->forumID, $arr);
  }

  public function getRecord()
  {
    if($this->forumID === "")
      return;
    $nConn = new Connection();
    $nConn->getRecord($this->tableName, $this->forumID);
  }

  public function findById()
  {

  }

}


?>
