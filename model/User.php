<?php

require_once('../common/connection.php');
require('ModelInterface.php');
/**
 *
 */

class User implements ModelInterface
{

  private $tableName = "User";
  private $username = "";
  private $password = "";
  private $email = "";

  function __construct($user, $pass, $email )
  {
    echo "inside User:constructor\n";
    $this->username = $user;
    $this->password = $pass;
    $this->email = $email;

  }


  public function save()
  {
    echo "inside User:save\n";
    $nConn = new Connection();
    $arr = array('username'=>$this->username, 'password'=>$this->password);
    $nConn->save($tableName, $arr);
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
