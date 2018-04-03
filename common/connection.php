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
      echo "CONNECTED: ";
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
      echo "Record created successfully\n";
    } else {
      echo "Error: " . $str . "\n" . $this->_conn->error;
    }
    return $this->_conn->insert_id;
  }
  /**
  *
  */
  function update($tableName, $ID, $arr)
  {
    echo "inside connection:update\n";
    $columns=array_keys($arr);
    $values=array_values($arr);
    foreach($arr as $key => $value)
    {
      $value = mysqli_real_escape_string($this->_conn, $value);
      $value = "'$value'";
      $updates[] = "$key = $value";
    }
    $eqArray = implode(', ', $updates);
    $str="UPDATE $tableName SET $eqArray WHERE $tableName"."ID=$ID";
    echo "$str\n";//your sql

    if ($this->_conn->query($str) === TRUE) {
      echo "New record updated successfully\n";
    } else {
      echo "Error: " . $str . "\n" . $this->_conn->error;
    }
  }

  /**
  *
  */
  function delete($tableName, $ID)
  {
    echo "inside connection:delete\n";

    $str="DELETE FROM $tableName WHERE $tableName" . "ID = $ID";
    echo "$str\n";//your sql

    if ($this->_conn->query($str) === TRUE)
    {
      if(empty($this->getRecord($tableName, $ID)))
      {
        echo "Record deleted successfully";
        return;
      }
    }
    echo "Error: " . $str . "<br>" . $this->_conn->error;
  }

  /**
  *
  */
  function getRecord($tableName, $ID)
  {
    echo "inside connection:getRecord\n";

    $str="SELECT * FROM $tableName WHERE $tableName" . "ID = $ID";
    echo "$str\n";//your sql

    $results = $this->_conn->query($str);
    $record = $results->fetch_assoc();
    if (!empty($record))
    {
      echo "Record retrieved successfully\n";
      foreach($record as $value)
        echo "| ".$value;
      echo "|";
      return $record;
    } else {
      echo "Error: " . $str . ". No record exists.\n" . $this->_conn->error;
    }
  }
}

?>
