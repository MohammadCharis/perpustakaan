<?php

namespace App\Console\Commands;

use App\LoanService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:process-overdue-loans')]
#[Description('Mark overdue loans.')]
class ProcessOverdueLoans extends Command
{
    public function handle(LoanService $loanService): int
    {
        $this->info('Updated '.$loanService->markOverdue().' overdue loans.');

        return self::SUCCESS;
    }
}
