<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\IncomeSource\IncomeSourceName;

class IncomeSource
{
  private ?int $id;
  private IncomeSourceName $name;
  private $userId;

  public function __construct(?int $id, IncomeSourceName $name, int $userId)
  {
    $this->id = $id;
    $this->name = $name;
    $this->userId = $userId;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): IncomeSourceName
  {
    return $this->name;
  }

  public function getUserId(): int
  {
    return $this->userId;
  }
}