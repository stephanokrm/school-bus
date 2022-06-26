<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\Driver;
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
        $driver = Driver::query()
            ->whereBelongsTo(auth()->user())
            ->first();

        return School::query()
            ->whereBelongsTo($driver)
            ->with('address')
            ->get();
    }

    /**
     * @param  StoreSchoolRequest  $request
     * @return School
     */
    public function store(StoreSchoolRequest $request): School
    {
        $driver = Driver::query()
            ->whereBelongsTo(auth()->user())
            ->first();

        $address = new Address;
        $address->fill($request->all());
        $address->setAttribute('external_city_id', 1);
        $address->save();

        $school = new School;
        $school->fill($request->all());
        $school->address()->associate($address);
        $school->driver()->associate($driver);
        $school->save();

        return $school;
    }

    /**
     * @param  School  $school
     * @return School
     */
    public function show(School $school): School
    {
        return $school->load('address');
    }

    /**
     *
     * @param  UpdateSchoolRequest
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
     * @param  School  $school
     */
    public function destroy(School $school)
    {
        $address = $school->address();
        $school->delete();
        $address->delete();

    }
}
