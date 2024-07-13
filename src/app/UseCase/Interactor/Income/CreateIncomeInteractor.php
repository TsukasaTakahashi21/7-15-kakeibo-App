<?php
namespace App\UseCase\Interactor\Income;

use App\Domain\Entity\Income;
use App\UseCase\Input\Income\CreateIncomeInput;
use App\Infrastructure\Repository\IncomeRepository;
use App\Presentation\Presenter\Income\CreateIncomePresenter;

class CreateIncomeInteractor
{
  private IncomeRepository $repository;
  private CreateIncomePresenter $presenter;

  public function __construct(IncomeRepository $repository, CreateIncomePresenter $presenter)
  {
    $this->repository = $repository;
    $this->presenter = $presenter;
  }

  public function handle(CreateIncomeInput $input): void
  {
    if (empty($input->getIncomeSourceId()) || empty($input->getAmount()) || empty($input->getAccrualDate())) {
      throw new \InvalidArgumentException('収入源、金額、日付は必須項目です');
    }

    $income = new Income($input->getUserId(), $input->getIncomeSourceId(), $input->getAmount(), $input->getAccrualDate());
    $this->repository->save($income);
    $this->presenter->output(['success' => '収入が登録されました']);
  }
}
