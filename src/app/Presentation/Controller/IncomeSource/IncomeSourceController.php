<?php
namespace App\Presentation\Controller\IncomeSource;

use App\UseCase\Interactor\IncomeSource\ViewIncomeSourceInteractor;
use App\Infrastructure\Repository\IncomeSourceRepository;
use App\Presentation\Presenter\IncomeSource\IncomeSourcePresenter;

class IncomeSourceController
{
  private ViewIncomeSourceInteractor $interactor;

  public function __construct()
  {
    $pdo = getPdo();
    $repository = new IncomeSourceRepository($pdo);
    $presenter = new IncomeSourcePresenter();
    $this->interactor = new ViewIncomeSourceInteractor($repository, $presenter);
  }

  public function index()
  {
    return $this->interactor->handleAll();
  }
}