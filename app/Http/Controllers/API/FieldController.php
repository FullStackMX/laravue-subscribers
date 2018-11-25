<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Field\StoreRequest;
use App\Http\Requests\API\Field\UpdateRequest;
use App\Models\Field;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Field::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\API\Field\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $field = Field::create([
            'meta' => $request->input('meta'),
            'name' => $request->input('name'),
            'protected' => $request->input('protected') ? 1 : 0,
            'required' => $request->input('required') ? 1 : 0,
            'title' => $request->input('title'),
            'type' => $request->input('type'),
        ]);

        return response()->json([
            'data' => $field,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        return response()->json([
            'data' => $field,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requests\API\Field\UpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Field $field)
    {
        $field->update([
            'meta' => $request->input('meta'),
            'name' => $request->input('name'),
            'protected' => $request->input('protected') ? 1 : 0,
            'required' => $request->input('required') ? 1 : 0,
            'title' => $request->input('title'),
            'type' => $request->input('type'),
        ]);

        return response()->json([
            'data' => $field,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        abort_if($field->protected, 403, 'You cannot delete protected fields.');

        $field->delete();

        return response()->json([
            'data' => null,
        ]);
    }
}
