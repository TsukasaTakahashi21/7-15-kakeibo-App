<?php 
session_start();
require_once '../../vendor/autoload.php';
require_once '../../Config/db.php';

use App\Infrastructure\Repository\IncomeRepository;
use App\Presentation\Controller\Income\CreateIncomeController;
use App\Presentation\Presenter\Income\CreateIncomePresenter;
use App\UseCase\Interactor\Income\CreateIncomeInteractor;


$pdo = getPdo();
$repository = new IncomeRepository($pdo);
$presenter = new CreateIncomePresenter();
$interactor = new CreateIncomeInteractor($repository, $presenter);
$controller = new CreateIncomeController($interactor);

$controller->store();