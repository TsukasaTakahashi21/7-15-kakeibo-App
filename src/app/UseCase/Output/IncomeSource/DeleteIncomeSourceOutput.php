<?php
namespace App\UseCase\Output\IncomeSource;

class DeleteIncomeSourceOutput
{
  private $id;

  public function __construct($id)
  {
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }
}

