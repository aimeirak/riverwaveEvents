<?php
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/6/18
 * Time: 6:49 PM
 */

namespace App\Http\Controllers;


use App\Event;
use App\Exceptions\CustomValidationException;
use App\Speaker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeakerController extends Controller
{

    public function index($eventId){
        $event = null;
        try{
            $event = Event::FindOrFail($eventId);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        $speakers = Speaker::where('event_id',$event->id)->get();
        return JsonResponse::create($speakers,200);
    }

    public function get($eventId,$speakerId){
        $event = null;
        $speaker = null;
        try{
            $event = Event::FindOrFail($eventId);
        }catch (ModelNotFoundException $e){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        try{
            $speaker = Speaker::where('event_id',$event->id)->where('id',$speakerId)->firstOrFail();
        }catch (ModelNotFoundException $exception){
            return JsonResponse::create(['message'=>'Not Found'],404);
        }
        return JsonResponse::create($speaker,200);

    }

    /**
     * @param Request $request
     * @param $eventId
     * @return JsonResponse
     * @throws CustomValidationException
     */
    public function create(Request $request, $eventId){
        $event = Event::findOrFail($eventId);
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'biography' => 'required',
            'photo' => 'nullable',
        ]);
        if ($validator->fails()){
            throw new CustomValidationException($validator->errors());
        }
        $payload = $request->all();
        $payload['event_id'] = $event->id;
        $speaker = Speaker::create($payload);
        return JsonResponse::create($speaker,200);
    }

    public function update(Request $request, $eventId, $speakerId){
        $event = Event::findOrFail($eventId);
        $speaker = Speaker::where('event_id',$event->id)->where('id',$speakerId)->firstOrFail();
        $validator = Validator::make($request->all(),[
            'first_name' => 'string',
            'last_name' => 'string',
            'biography' => 'string',
            'photo' => 'string|nullable',
        ]);
        if ($validator->fails()){
            throw new CustomValidationException($validator->errors());
        }
        $speaker->update($request->all());
        return JsonResponse::create($speaker,200);

    }

    public function delete($eventId,$speakerId){
        $event = Event::findOrFail($eventId);
        $speaker = Speaker::where('event_id',$event->id)->where('id',$speakerId)->firstOrFail();
        $speaker->delete();
        return JsonResponse::create(['message'=>'speaker deleted'],200);
    }

}