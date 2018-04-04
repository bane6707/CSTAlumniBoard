<?php

require_once('../common/connection.php');
require('ModelInterface.php');
/**
 *
 */

class User implements ModelInterface
{
  private $userID = "";
  private $tableName = "User";
  private $password = "";
  private $email = "";
  private $firstName = "";
  private $lastName = "";


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
    $nConn->getRecord($this->tableName, $this->userID);
  }

  public function findById(){

  }

  public function checkUser() {
    $nConn = new Connection();
    $clause = " email = '$this->email' and password ='$this->password'";
    //echo $clause;
    return $nConn->getCount($this->tableName, $clause);
  }
}

?>
