<?php
namespace App\UseCase\Interactor\Income;

use App\UseCase\Input\Income\DeleteIncomeInput;
use App\Infrastructure\Repository\IncomeRepository;
use App\Domain\Entity\Income;

class DeleteIncomeInteractor {
  private IncomeRepository $repository;

  public function __construct(IncomeRepository $repository)
  {
    $this->repository = $repository;
  }

  public function handle(DeleteIncomeInput $input): void
  {
    $income = new Income(null, null, null, null,$input->getId());
    $this->repository->delete($income);
  }

}