<?php
namespace App\UseCase\Interactor\IncomeSource;

use App\Infrastructure\Repository\IncomeSourceRepository;
use App\Presentation\Presenter\IncomeSource\IncomeSourcePresenter;
use App\UseCase\Output\IncomeSource\ViewIncomeSourceOutput;

class ViewIncomeSourceInteractor
{
  private IncomeSourceRepository $repository;
  private IncomeSourcePresenter $presenter;

  public function __construct(IncomeSourceRepository $repository, IncomeSourcePresenter $presenter)
  {
    $this->repository = $repository;
    $this->presenter = $presenter;
  }

  public function handleAll(): array
  {
    $incomeSources = $this->repository->findAll();
    $outputs = [];

    foreach ($incomeSources as $incomeSource) {
      $outputs[] = new ViewIncomeSourceOutput($incomeSource);
  }
    return $this->presenter->outputAll($outputs);
  }
}