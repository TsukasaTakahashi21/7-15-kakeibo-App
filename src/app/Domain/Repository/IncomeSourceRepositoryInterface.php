<?php
namespace App\Domain\Repository;

use App\Domain\Entity\IncomeSource;

interface IncomeSourceRepositoryInterface
{
  public function save(IncomeSource $incomeSource): void;
  public function findById(int $id): ?IncomeSource;
  public function findAll(): array;
  public function update(IncomeSource $incomeSource): void;
  public function delete(int $id);

}