<?php

/**
 *
 */
interface ModelInterface
{
  public function save();

  public function delete();

  public function update();

  public function getRecord();

  public function findById();
}


 ?>
