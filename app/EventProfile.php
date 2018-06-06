<?php
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/6/18
 * Time: 4:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class EventProfile extends Model
{

    protected $table = 'event_profiles';
    protected $fillable = [
        'theme-color',
        'theme-image',
        'secondary-color',
        'secondary-image',
        'event_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function event(){
        return $this->belongsTo('App\Event');
    }

}