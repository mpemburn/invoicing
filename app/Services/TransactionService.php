<?php
namespace App\Services;

use App\Models\TransactionType;

/**
 * Class TransactionService
 * @package App\Services
 *
 * This class is instantiated as a singleton to provide TransactionType info
 *
 */
class TransactionService {
    protected $positive_transactions;

    public function __construct()
    {
        $this->setPositiveTransactions();
    }

    public function getPositiveTransactions()
    {
        return $this->positive_transactions;
    }

    private function setPositiveTransactions()
    {
        $trans = TransactionType::select('id')
            ->where('is_positive', 1)
            ->get()
            ->pluck('id')
            ->toArray();
        $this->positive_transactions = array_values($trans);
    }
}