<?php
namespace App\UseCase\Interactor\IncomeSource;

use App\Infrastructure\Repository\IncomeSourceRepository;
use App\Presentation\Presenter\IncomeSource\DeleteIncomeSourcePresenter;
use App\UseCase\Output\IncomeSource\DeleteIncomeSourceOutput;

class DeleteIncomeSourceInteractor
{
  private $repository;
  private $presenter;

  public function __construct(
    IncomeSourceRepository $repository,
    DeleteIncomeSourcePresenter $presenter
  )
  {
    $this->repository = $repository;
    $this->presenter = $presenter;
  }

  public function handleDelete($id)
  {
    $this->repository->delete($id);
    $output = new DeleteIncomeSourceOutput($id);
    $this->presenter->output($output);
  }
}