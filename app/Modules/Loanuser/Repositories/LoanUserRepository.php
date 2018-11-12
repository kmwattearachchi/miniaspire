<?php

namespace App\Modules\Loanuser\Repositories;

use App\LoanUser;
use App\Repositories\MainRepository;
use App\Modules\Loanuser\Contracts\LoanUserRepositoryInterface;
use Illuminate\Contracts\Container\Container as App;


class LoanUserRepository extends MainRepository implements LoanUserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\LoanUser';
    }
}