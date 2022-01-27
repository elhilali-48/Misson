<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récuperer tous les evenements 
        $events = Event::all();
        $eventsArray = [];
        foreach($events as $event){
           $data = [
               'id'=>$event->id,
               'title' => $event->nom,
               'start' => $event->debut,
               'end'=> $event->fin,
               'description' => $event->description
           ];
           array_push($eventsArray,$data);
        }
        //récuperer la liste des evenements dans un array
        return response()->json($eventsArray);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        Event::create([
            'nom' => $request->title,
            'debut' => $request->start,
            'fin' => $request->end,
            'description'=> $request->description
        ]);

        return response()->json(['success'=>'Event Adeed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        
        $data = [
            'id'=>$event->id,
            'title' => $event->nom,
            'start' => $event->debut,
            'end'=> $event->fin,
            'description' => $event->description
        ];

        return response()->json($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        
        $data = [
            'id'=>$event->id,
            'title' => $event->nom,
            'start' => $event->debut,
            'end'=> $event->fin,
            'description' => $event->description
        ];

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, $id)
    {
        
        $event = Event::findOrFail($id);
        
        $event->update([
            'nom'=>$request->title,
            'description'=>$request->description,
            'debut'=>$request->start,
            'fin'=>$request->end,
        ]);


       
        
       
        return response()->json(['success'=>'Event Updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        return response()->json(['success'=>"Evenement Deleted"]);

    }
}
