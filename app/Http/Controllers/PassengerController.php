<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePassengerRequest;
use App\Http\Requests\UpdatePassengerRequest;
use App\Models\Passenger;
use App\Models\User;
use App\Models\Driver;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePassengerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePassengerRequest $request)
    {
        $userRequest = $request->user;
        $addressRequest = $request->address;
        $passengerRequest = $request->passenger;

        $responsible = User::query()->create([
            ...$userRequest,
            'password' => Hash::make($userRequest['cpf']),
        ]);

        $address = new Address;
        $address->fill($addressRequest);
        $address->external_city_id = 1; //temporary
        $address->save();

        $driver = Driver::find(Auth::user()->id);

        $passenger = new Passenger;
        $passenger->fill($passengerRequest);
        $passenger->responsible()->associate($responsible);
        $passenger->address()->associate($address);
        $passenger->driver()->associate($driver);
        $passenger->driver_id = 1;
        $passenger->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function show(Passenger $passenger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePassengerRequest  $request
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePassengerRequest $request, Passenger $passenger)
    {
        $passengerRequest = $request->passenger;
        $userRequest = $request->user;
        $addressRequest = $request->address;
        
        $passenger->fill($passengerRequest);
        $passenger->save();

        $responsible = User::find($passenger->responsible_id);
        $responsible->fill($userRequest);
        $responsible->save();

        $address = Address::find($passenger->address_id);
        $address->fill($addressRequest);
        $address->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Passenger $passenger)
    {
        //
    }
}
