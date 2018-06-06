<?php
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/6/18
 * Time: 3:59 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $table = 'events';
    protected $fillable = [
        'event_name',
        'description',
        'starts',
        'ends',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    protected $with = [
        'event_profile'
    ];


    public function event_profile(){
        return $this->hasOne('App\EventProfile');
    }

}