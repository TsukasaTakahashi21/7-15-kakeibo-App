<?php
namespace App\UseCase\Output\Income;

class UpdateIncomeInput
{
  private bool $success;

  public function __construct(bool $success)
  {
    $this->success = $success;
  }

  public function isSuccess(): bool
  {
    return $this->success;
  }
}
