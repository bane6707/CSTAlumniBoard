<?php
/**
*
*/
class Connection
{

  protected $_conn;

  function __construct(/*$user, $pass, $database='bb', $host='localhost' */)
  {
    /*try{
      $this->_conn = new PDO("mysql:host={$host};dbname={$database}"
                      , $user , $pass);
      echo "connected";
    }catch(Exception $e){
      echo $e->getMessage();
    }*/

    echo "inside connection:constructor\n";
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
