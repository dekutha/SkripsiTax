<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ExpertTax extends Model
{
    protected $table = 'experttaxes';

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
