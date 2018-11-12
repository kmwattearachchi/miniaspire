<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = "loans";

    /**
     * Primary key
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     *  Relationship for repayments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repayments()
    {
        return $this->hasMany('App\LoanRepayment', 'loan', 'id');
    }
}
