<?php
namespace App\UseCase\Input\IncomeSource;

class EditIncomeSourceInput
{
  private $id;
  private $name;
  private $userId;

  public function __construct(int $id, string $name, int $userId)
  {
    $this->id = $id;
    $this->name = $name;
    $this->userId = $userId;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getUserId()
  {
    return $this->userId;
  }
}