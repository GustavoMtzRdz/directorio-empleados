<?php
/**
 * Created by PhpStorm.
 * User: alexech
 * Date: 18/10/17
 * Time: 13:29
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = ['alias', 'address'];
}