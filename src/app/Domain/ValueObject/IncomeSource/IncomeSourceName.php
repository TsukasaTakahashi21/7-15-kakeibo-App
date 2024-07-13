<?php
namespace App\Domain\ValueObject\IncomeSource;

class IncomeSourceName
{
  private string $name;

  public function __construct(string $name)
  {
    if (empty($name)) {
      throw new \InvalidArgumentException('収入源名が空です');
    }

    $this->name = $name;
  }

  public function getValue(): string
  {
    return $this->name;
  }
}