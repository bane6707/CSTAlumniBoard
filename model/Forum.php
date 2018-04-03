<?php

require_once('../common/connection.php');
require_once('ModelInterface.php');

/**
 *
 */
class Forum implements ModelInterface
{

  private $title = "";
  private $tableName = "Forum";
  private $createdTime = "";

  function __construct($forName)
  {
    $this->title = $forName;
  }

  public function save()
  {
    echo "inside Forum:save\n";
    $nConn = new Connection();
    $arr = array('title'=>$this->title);
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
