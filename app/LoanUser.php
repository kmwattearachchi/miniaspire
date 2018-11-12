<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LoanUser
 * @package App
 */
class LoanUser extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = "loan_users";

    /**
     * Primary key
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     *  Relationship for loans.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loans()
    {
        return $this->hasMany('App\Loan', 'loan_user', 'id');
    }
}
