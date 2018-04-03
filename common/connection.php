<?php

require_once("../BoardSetup.php");
/**
*
*/
class Connection
{

  protected $_conn;

  function __construct($user=DB_UID, $pass=DB_PASS, $database=DB_NAME, $host=DB_HOST)
  {
    try{
      $this->_conn = new mysqli($host, $user, $pass, $database);
      echo "connected";
    }catch(Exception $e){
      echo $e->getMessage();
    }
  }

  /**
  *
  */
  function save($tableName, $arr)
  {
    echo "inside connection:save\n";
    $columns=array_keys($arr);
    $values=array_values($arr);

    $str="INSERT INTO $tableName (".implode(',',$columns).
    ") VALUES ('" . implode("', '", $values) . "' );";
    echo "$str\n";//your sql

    if ($this->_conn->query($str) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $str . "<br>" . $this->_conn->error;
    }
  }
  /**
  *
  */
  function update()
  {

  }
  /**
  *
  */
  function delete()
  {

  }
}

?>
