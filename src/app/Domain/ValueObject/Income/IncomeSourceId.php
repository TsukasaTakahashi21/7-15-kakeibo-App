<?php
namespace App\Domain\ValueObject\Income;

class IncomeSourceId
{
    private int $value;

    public function __construct(int $value)
    {
      $this->value = $value;
    }

    public function getValue(): int
    {
      return $this->value;
    }
}