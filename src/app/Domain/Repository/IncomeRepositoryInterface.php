<?php
namespace App\Domain\Repository;

use App\Domain\Entity\Income;

interface IncomeRepositoryInterface
{
  public function save(Income $income): void;
  public function findById(int $id): ?Income;
  public function findAll(): array;
  public function update(Income $income): void;
  

}
