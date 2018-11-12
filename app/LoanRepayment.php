<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = "loan_repayments";

    /**
     * Primary key
     *
     * @var array
     */
    protected $guarded = ['id'];
}
