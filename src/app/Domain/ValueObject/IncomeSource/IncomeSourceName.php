<?php
namespace App\Domain\ValueObject\IncomeSource;

class IncomeSourceName
{
  private string $name;

  public function __construct(string $name)
  {
    $this->name = $name;
  }

  public function getValue(): string
  {
    return $this->name;
  }
}