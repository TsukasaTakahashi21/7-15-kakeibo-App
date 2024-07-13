<?php
namespace App\Presentation\Controller\IncomeSource;

use App\Infrastructure\Repository\IncomeSourceRepository;
use 
App\UseCase\Interactor\IncomeSource\DeleteIncomeSourceInteractor;
use App\Presentation\Presenter\IncomeSource\DeleteIncomeSourcePresenter;


class DeleteIncomeSourceController
{
  private $interactor;

  public function __construct()
  {
    $pdo = getPdo();
    $repository = new IncomeSourceRepository($pdo);
    $presenter = new DeleteIncomeSourcePresenter();
    
    $this->interactor = new DeleteIncomeSourceInteractor($repository, $presenter);
  }

  public function delete($id)
  {
    return $this->interactor->handleDelete($id);
  }
}