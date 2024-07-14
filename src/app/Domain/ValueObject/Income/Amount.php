<?php
namespace App\Domain\ValueObject\Income;

use InvalidArgumentException;

class Amount
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
