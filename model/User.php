<?php

require_once('../common/connection.php');
require('ModelInterface.php');
/**
 *
 */

class User implements ModelInterface
{

  private $tableName = "User";
  private $password = "";
  private $email = "";
  private $firstName = "";
  private $lastName = "";
  

  function __construct($firstName, $lastName, $pass, $email )
  {
    echo "inside User:constructor\n";
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->password = $pass;
    $this->email = $email;

  }


  public function save()
  {
    echo "inside User:save\n";
    $nConn = new Connection();
    $arr = array('firstName'=>$this->firstName,'lastName'=>$this->lastName, 'password'=>$this->password, 'email'=>$this->email);
    $nConn->save($this->tableName, $arr);
  }

  public function delete()
  {

  }

  public function update(){

  }

  public function findById(){

  }
}

?>
