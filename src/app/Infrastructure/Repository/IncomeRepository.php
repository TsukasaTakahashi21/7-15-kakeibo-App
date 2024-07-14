<?php
namespace App\Infrastructure\Repository;

use App\Domain\Entity\Income;
use App\Domain\Repository\IncomeRepositoryInterface;
use App\Domain\ValueObject\Income\IncomeSourceId; 
use App\Domain\ValueObject\Income\Amount; 
use App\Domain\ValueObject\Income\AccrualDate;
use PDO;

class IncomeRepository implements IncomeRepositoryInterface
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function save(Income $income): void
  {
    $sql = 'INSERT INTO incomes(user_id, income_source_id, amount, accrual_date, created_at, updated_at) VALUES (:user_id, :income_source_id, :amount, :accrual_date, NOW(), NOW())';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':user_id', $income->getUserId(), PDO::PARAM_INT);
    $stmt->bindValue(':income_source_id', $income->getIncomeSourceId(), PDO::PARAM_INT);
    $stmt->bindValue(':amount', $income->getAmount(), PDO::PARAM_INT);
    $stmt->bindValue(':accrual_date', $income->getAccrualDate(), PDO::PARAM_STR);
    $stmt->execute();
  }

  public function findById(int $id): ?Income
  {
    $sql = 'SELECT * FROM incomes WHERE id = :id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      return new Income(
        $result['user_id'],
        new IncomeSourceId($result['income_source_id']),
        new Amount($result['amount']),
        new AccrualDate($result['accrual_date']), 
        $result['id'],
      );
    }
    return null;
  }

  public function findAll(): array
  {
    $sql = 'SELECT * FROM incomes';
    $stmt = $this->pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $incomes = [];
    foreach ($results as $result) {
      $incomes[] = new Income(
        $result['id'],
        $result['user_id'],
        $result['income_source_id'],
        $result['amount'],
        $result['accrual_date']
      );
    }
    return $incomes;
  }

  public function update(Income $income): void
  {
    $sql = 'UPDATE incomes SET income_source_id = :income_source_id, amount = :amount, accrual_date = :accrual_date WHERE id = :id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':income_source_id', $income->getIncomeSourceId()->getValue(), PDO::PARAM_INT);
    $stmt->bindValue(':amount', $income->getAmount()->getValue(), PDO::PARAM_INT);
    $stmt->bindValue(':accrual_date', $income->getAccrualDate()->getValue());
    $stmt->bindValue(':id', $income->getId(), PDO::PARAM_INT);
    $stmt->execute();
  }

  public function delete(Income $income): void
  {
    $sql = 'DELETE FROM incomes WHERE id = :id';
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $income->getId(), PDO::PARAM_INT);
    $stmt->execute();
  }
}

