<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Subscriber\StoreRequest;
use App\Http\Requests\API\Subscriber\UpdateRequest;
use App\Models\Subscriber;
use App\Models\SubscriberField;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Subscriber::all()->load('fields'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\API\Subscriber\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //$subscriber = Subscriber::create();
        $subscriber = Subscriber::find(1);

        foreach ($request->get('fields') as $fieldData) {
            SubscriberField::updateOrCreate([
                'field_id' => $fieldData['field_id'],
                'subscriber_id' => $subscriber->id,
            ], [
                'value' => $fieldData['value'],
            ]);
        }

        return response()->json([
            'data' => $subscriber->load('fields'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        return response()->json([
            'data' => $subscriber->load('fields'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requests\API\Subscriber\UpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Subscriber $subscriber)
    {
        foreach ($request->get('fields') as $fieldData) {
            SubscriberField::updateOrCreate([
                'field_id' => $fieldData['field_id'],
                'subscriber_id' => $subscriber->id,
            ], [
                'value' => $fieldData['value'],
            ]);
        }

        return response()->json([
            'data' => $subscriber->load('fields'),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return response()->json([
            'data' => null,
        ]);
    }
}
