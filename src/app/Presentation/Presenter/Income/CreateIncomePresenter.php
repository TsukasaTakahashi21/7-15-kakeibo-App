<?php
namespace App\Presentation\Presenter\Income;

class CreateIncomePresenter
{
  public function output(array $data)
  {
    if (isset($data['error'])) {
      $_SESSION['errors'] = $data['error'];
      header('Location: ./create.php');
      exit();
    }

    $_SESSION['success'] = $data['success'];
    header('Location: ./index.php');
    exit();
  }
}
