<?php
namespace App\Presentation\Controller\IncomeSource;

use App\Infrastructure\Repository\IncomeSourceRepository;
use App\UseCase\Interactor\IncomeSource\EditIncomeSourceInteractor;
use App\Presentation\Presenter\IncomeSource\EditIncomeSourcePresenter;
use App\UseCase\Input\IncomeSource\EditIncomeSourceInput;

class EditIncomeSourceController
{
  private $interactor;

  public function __construct()
  {
    $pdo = getPdo();
    $repository = new IncomeSourceRepository($pdo);
    $presenter = new EditIncomeSourcePresenter();
    $this->interactor = new EditIncomeSourceInteractor($repository, $presenter);
  }

  public function edit($id)
  {
    return $this->interactor->handleEdit($id);
  }

  public function update(EditIncomeSourceInput $input)
  {
    return $this->interactor->handleUpdate($input);
  }
}