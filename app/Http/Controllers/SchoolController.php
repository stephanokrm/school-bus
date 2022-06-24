<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use App\Models\Address;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SchoolController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index(): array|Collection
    {
        return School::query()
            ->whereBelongsTo(auth()->user())
            ->with('address')
            ->get();
    }

    /**
     * @param  StoreSchoolRequest  $request
     * @return School
     */
    public function store(StoreSchoolRequest $request): School
    {
        $address = new Address;
        $address->fill($request->all());
        $address->setAttribute('external_city_id', 1);
        $address->save();

        $school = new School;
        $school->fill($request->all());
        $school->address()->associate($address);
        $school->driver()->associate(auth()->user());
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
