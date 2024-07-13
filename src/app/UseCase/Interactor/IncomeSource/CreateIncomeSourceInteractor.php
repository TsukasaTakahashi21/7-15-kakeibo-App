<?php
namespace App\UseCase\Interactor\IncomeSource;

use App\Domain\Entity\IncomeSource;
use App\Domain\Repository\IncomeSourceRepositoryInterface;
use App\UseCase\Input\IncomeSource\CreateIncomeSourceInput;
use App\UseCase\Output\IncomeSource\CreateIncomeSourceOutput;
use App\Domain\ValueObject\IncomeSource\IncomeSourceName;
use App\UseCase\Presenter\IncomeSource\CreateIncomeSourcePresenterInterface;

class CreateIncomeSourceInteractor
{
  private IncomeSourceRepositoryInterface $repository;
  private CreateIncomeSourcePresenterInterface $presenter;

  public function __construct(
    IncomeSourceRepositoryInterface $repository,
    CreateIncomeSourcePresenterInterface $presenter
  ) {
    $this->repository = $repository;
    $this->presenter = $presenter;
  }

  public function handle(CreateIncomeSourceInput $input): CreateIncomeSourceOutput
  {
    $incomeSourceName = new IncomeSourceName($input->getName());
    $incomeSource = new IncomeSource(null, $incomeSourceName, $input->getUserId());

    $this->repository->save($incomeSource);

    $output = new CreateIncomeSourceOutput($incomeSource);
    $this->presenter->output($output);

    return $output;
  }
}