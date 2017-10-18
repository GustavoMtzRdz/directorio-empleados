<?php
/**
 * Created by PhpStorm.
 * User: alexech
 * Date: 18/10/17
 * Time: 13:28
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $fillable = ['name', 'email', 'birthday', 'employee_id'];

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }
}