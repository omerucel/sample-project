<?php

namespace Application\Database\MySQL;

use Application\Database\TransactionProxy;

class TransactionProxyImpl implements TransactionProxy
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function rollback()
    {
        $this->pdo->rollBack();
    }

    public function commit()
    {
        $this->pdo->commit();
    }
}
