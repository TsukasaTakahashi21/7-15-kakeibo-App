<?php
namespace App\UseCase\Interactor\IncomeSource;

use App\Domain\Entity\IncomeSource;
use App\Domain\Repository\IncomeSourceRepositoryInterface;
use App\UseCase\Input\IncomeSource\EditIncomeSourceInput;
use App\UseCase\Output\IncomeSource\EditIncomeSourceOutput;
use App\Domain\ValueObject\IncomeSource\IncomeSourceName;
use App\Infrastructure\Repository\IncomeSourceRepository;
use App\UseCase\Presenter\IncomeSource\EditIncomeSourcePresenterInterface;

class EditIncomeSourceInteractor
{
  private $repository;
  private $presenter;

  public function __construct(
    IncomeSourceRepository $repository,
    EditIncomeSourcePresenterInterface $presenter
  )
  {
    $this->repository = $repository;
    $this->presenter = $presenter;
  }

  public function handleEdit($id)
  {
    $incomeSource = $this->repository->findById($id);
    $output = new EditIncomeSourceOutput($incomeSource);
    return $this->presenter->output($output);
  }

  public function handleUpdate(EditIncomeSourceInput $input)
  {
    $incomeSourceName = new IncomeSourceName($input->getName());
    $incomeSource = new IncomeSource($input->getId(), $incomeSourceName, $input->getUserId());

    $this->repository->update($incomeSource);

    $output = new EditIncomeSourceOutput($incomeSource);
    return $this->presenter->output($output);
  }
}