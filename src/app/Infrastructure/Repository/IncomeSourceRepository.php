<?php
namespace App\Infrastructure\Repository;

use App\Domain\Entity\IncomeSource;
use App\Domain\Repository\IncomeSourceRepositoryInterface;
use App\Domain\ValueObject\IncomeSource\IncomeSourceName;
use PDO;

class IncomeSourceRepository implements IncomeSourceRepositoryInterface
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function save(IncomeSource $incomeSource): void
  {
    $sql = 'INSERT INTO income_sources (name, user_id) VALUES (:name, :user_id)';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':name', $incomeSource->getName()->getValue(), PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $incomeSource->getUserId(), PDO::PARAM_INT);
    $stmt->execute();
  
    header('Location: ./index.php');
    exit();
  }

  public function findById(int $id): ?IncomeSource
  {
    $sql = 'SELECT * FORM income_sources WHERE id = :id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      return new IncomeSource($row['id'], new IncomeSourceName($row['name']), $row['user_id']);
    }

    return null;
  }

  public function findAll(): array
  {
    $sql = 'SELECT * FROM income_sources';
    $stmt = $this->pdo->prepare($sql);
    $incomeSources = [];

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    while ($row) {
      $incomeSources[] = new IncomeSource($row['id'], new IncomeSourceName($row['name']), $row['user_id']);
    }

    return $incomeSources;
  }
}