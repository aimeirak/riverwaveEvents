<?php
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/6/18
 * Time: 6:45 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speaker extends Model
{
    use SoftDeletes;
    protected $table = 'speakers';
    protected $fillable = [
        'first_name',
        'last_name',
        'biography',
        'photo',
        'event_id'
    ];

    public function event(){
        return $this->belongsTo('App\Event');
    }

}