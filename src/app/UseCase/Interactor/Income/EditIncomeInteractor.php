<?php
namespace App\UseCase\Interactor\Income;

use App\UseCase\Input\Income\EditIncomeInput;
use App\Infrastructure\Repository\IncomeRepository;

class EditIncomeInteractor
{
  private IncomeRepository $repository;
  
  public function __construct(IncomeRepository $repository)
  {
    $this->repository = $repository;
  }

  public function handle(EditIncomeInput $input)
  {
    return $this->repository->findById($input->getId());
  }
}