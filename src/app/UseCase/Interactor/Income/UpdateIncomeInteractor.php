<?php
namespace App\UseCase\Interactor\Income;

use App\Domain\Entity\Income;
use App\UseCase\Input\Income\UpdateIncomeInput;
use App\Infrastructure\Repository\IncomeRepository;
use App\Domain\ValueObject\Income\IncomeSourceId; 
use App\Domain\ValueObject\Income\Amount; 
use App\Domain\ValueObject\Income\AccrualDate;

class UpdateIncomeInteractor
{
  private IncomeRepository $repository;

  public function __construct(IncomeRepository $repository)
  {
      $this->repository = $repository;
  }

  public function handle(UpdateIncomeInput $input)
  {
    $income = new Income(
      $input->getId(),
      new IncomeSourceId($input->getIncomeSourceId()),
      new Amount($input->getAmount()),
      new AccrualDate($input->getAccrualDate()),
      $input->getId()
    );
    $this->repository->update($income);
  }
}