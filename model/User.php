<?php

require_once('../common/connection.php');
require('ModelInterface.php');
require("Subscriber.php");
/**
 *
 */

class User implements ModelInterface, Subscriber
{
  private $userID = "";
  private $tableName = "User";
  private $password = "";
  private $email = "";
  private $firstName = "";
  private $lastName = "";
  private $subscriptions = "";

  function __construct($firstName, $lastName, $pass, $email )
  {
    //echo "inside User:constructor\n";
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->password = $pass;
    $this->email = $email;
  }


  public function save()
  {
    //echo "inside User:save\n";
    $nConn = new Connection();
    $arr = array('firstName'=>$this->firstName,'lastName'=>$this->lastName, 'password'=>$this->password, 'email'=>$this->email);
    $this->userID = $nConn->save($this->tableName, $arr);
    return $this->userID;
  }

  public function delete()
  {
    if($this->userID === "")
      return;
    $nConn = new Connection();
    $nConn->delete($this->tableName, $this->userID);
  }

  public function update()
  {
    //echo "inside User:update\n";
    $nConn = new Connection();
    $arr = array('password'=>$this->password,'email'=>$this->email, 'firstName'=>$this->firstName, 'lastName'=>$this->lastName);
    $nConn->update($this->tableName, $this->userID, $arr);
  }

  public function getRecord()
  {
    if($this->userID === "")
      return;
    $nConn = new Connection();
    return $nConn->getRecord($this->tableName, $this->userID);
  }

  public function findById()
  {

  }

  public function checkUser() {
    $nConn = new Connection();
    $clause = " email = '$this->email' and password ='$this->password'";
    //echo $clause;
    return $nConn->getCount($this->tableName, $clause);
  }

  public function getUserID()
  {
    return $this->userID;
  }
  public function getEmail()
  {
    return $this->email;
  }
  public function getFirstName()
  {
    return $this->firstName;
  }
  public function getLastName()
  {
    return $this->lastName;
  }

  public function notify($forumID, $thread)
  {
    $forumTitleQuery = "SELECT title FROM FORUM WHERE forumID = $forumID";
    $nConn = new Connection();
    $records = $nConn->getQuery($forumTitleQuery);
    $row = $records->fetch_array();
    $forumTitle = $row["title"];
    $content = "'Thread -".$thread->getTopic()."- created in Forum: ". $forumTitle."'";
    $threadID = $thread->getThreadID();
    //~~~~ use Notification class
    $nQuery = "INSERT INTO NOTIFICATION (`userID`, `content`, `threadID`) VALUES ($this->userID, $content, $threadID);";
    $nConn->getQuery($nQuery);
  }

  public function loadUserByID($userID)
  {
    //echo "inside User:loadUserByID\n";
    $this->userID = $userID;
    $record = $this->getRecord();
    if(!empty($record))
    {
      $this->userID = $record['userID'];
      $this->password = $record['password'];
      $this->email = $record['email'];
      $this->firstName = $record['firstName'];
      $this->lastName = $record['lastName'];
      return true;
    }
    //echo "No record for userID=".$userID."\n";
    return false;
  }
  
}

?>
