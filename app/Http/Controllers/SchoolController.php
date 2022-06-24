<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use App\Models\Address;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return School::where('driver_id',Auht::user()->id)
                        ->with('address')
                        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSchoolRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolRequest $request)
    {   
        $address = new Address;
        $address->fill($request->all());
        $address->external_city_id = 1; //temporary
        $address->save();

        $school = new School;
        $school->driver_id = Auht::user()->id;
        $school->fill($request->all());
        $school->address()->associate($address);
        $school->save();
        
        return $school;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        return $school->load('address');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSchoolRequest  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->fill($request->all());
        $school->save();

        $address = Address::find($school->address_id);
        $address->fill($request->all());
        $address->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        $address = $school->address();
        $school->delete();
        $address->delete();

    }
}
