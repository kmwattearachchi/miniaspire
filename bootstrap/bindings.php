<?php

/*
|--------------------------------------------------------------------------
| Bindings
|--------------------------------------------------------------------------
|
|
*/
$app->bind('App\Modules\Loanuser\Contracts\LoanUserRepositoryInterface', 'App\Modules\Loanuser\Repositories\LoanUserRepository');
$app->bind('App\Modules\Loan\Contracts\LoanRepositoryInterface', 'App\Modules\Loan\Repositories\LoanRepository');
