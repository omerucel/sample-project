<?php

namespace Application\Database;

interface TransactionProxy
{
    public function beginTransaction();
    public function rollback();
    public function commit();
}
