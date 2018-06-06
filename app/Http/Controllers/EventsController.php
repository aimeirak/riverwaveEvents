<?php
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/6/18
 * Time: 4:06 PM
 */

namespace App\Http\Controllers;


use App\Event;
use App\EventProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{

    public function index(){
        return JsonResponse::create(Event::all(),200);
    }

    public function get($id){
        $event = null;
        try{
            $event = Event::findOrFail($id);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        return JsonResponse::create($event,200);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(),[
            'event_name'=>'required',
            'description' => 'required',
            'starts' => 'required',
            'ends' => 'required',

        ]);
        if ($validator->fails()){
            return JsonResponse::create($validator->errors(),400);
        }
        $event = Event::create($request->all());
        return JsonResponse::create($event,200);

    }

    public function update(Request $request, $id){
        $event = null;
        try{
            $event = Event::findOrFail($id);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        $validator = Validator::make($request->all(),[
            'event_name'=>'nullable|required',
            'description' => 'nullable|required',
            'starts' => 'nullable|required',
            'ends' => 'nullable|required',

        ]);
        if ($validator->fails()){
            return JsonResponse::create($validator->errors(),400);
        }

        $event->update($request->all());
        return JsonResponse::create($event,200);
    }

    public function delete($id){
        $event = null;
        try{
            $event = Event::findOrFail($id);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        $event->delete();
        return JsonResponse::create(['message'=>'event deleted'],200);
    }



    public function createEventProfile(Request $request,$id){
        $event = null;
        try{
            $event = Event::findOrFail($id);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        $validator = Validator::make($request->all(),[
            'theme-color' => 'required',
            'theme-image' => 'required',
            'secondary-color' => 'required',
            'secondary-image' => 'required'
        ]);
        if ($validator->fails()){
            return JsonResponse::create($validator->errors(),400);
        }
        $requestPayload = $request->all();
        $requestPayload['event_id'] = $event->id;
        $eventProfile = EventProfile::create($requestPayload);
        return JsonResponse::create($eventProfile,200);
    }

    public function editEventProfile(Request $request,$id){
        $event = null;
        try{
            $event = Event::findOrFail($id);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        $validator = Validator::make($request->all(),[
            'theme-color' => 'string',
            'theme-image' => 'string',
            'secondary-color' => 'string',
            'secondary-image' => 'string'
        ]);
        if ($validator->fails()){
            return JsonResponse::create($validator->errors(),400);
        }
        $profile = $event->event_profile;
        $profile->update($request->all());
        return JsonResponse::create($event,200);
    }

}