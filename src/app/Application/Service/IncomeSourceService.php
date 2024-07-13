<!--  -->

<?php
namespace App\Aplication\Service;

use App\Infrastructure\Repository\IncomeSourceRepository;
use App\Domain\Entity\IncomeSource;
use App\Domain\ValueObject\IncomeSource\IncomeSourceName;

class IncomeSourceService
{
  private IncomeSourceRepository $repository;

  public function __construct(IncomeSourceRepository $repository)
  {
    $this->repository = $repository;
  }

  public function createIncomeSource(string $name, int $userId): void
  {
    $incomeSourceName = new IncomeSourceName($name);
    $incomeSource = new IncomeSource(null, $incomeSourceName, $userId);

    $this->repository->save($incomeSource);
  }
}
