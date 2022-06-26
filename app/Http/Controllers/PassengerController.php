<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePassengerRequest;
use App\Http\Requests\UpdatePassengerRequest;
use App\Models\Passenger;
use App\Models\User;
use App\Models\Driver;
use App\Models\Address;
use App\Models\School;
use App\Models\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class PassengerController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index(): array|Collection
    {
        $driver = Driver::query()
        ->whereBelongsTo(auth()->user())
        ->first();

        return Passenger::query()
            ->whereBelongsTo($driver)
            ->with('address')
            ->with('responsible')
            ->with('school')
            ->get();
    }

    /**
     * @param  StorePassengerRequest  $request
     * @return Passenger
     */
    public function store(StorePassengerRequest $request): Passenger
    {
        $driver = Driver::query()
        ->whereBelongsTo(auth()->user())
        ->first();

        $userRequest = $request->user;
        $addressRequest = $request->address;
        $passengerRequest = $request->passenger;

        $responsible = User::query()->create([
            ...$userRequest,
            'password' => Hash::make($userRequest['cpf']),
        ]);

        $address = new Address;
        $address->fill($addressRequest);
        $address->setAttribute('external_city_id', 1);
        $address->save();

        $school = School::Find($passengerRequest['school_id']);

        $passenger = new Passenger;
        $passenger->fill($passengerRequest);
        $passenger->responsible()->associate($responsible);
        $passenger->address()->associate($address);
        $passenger->driver()->associate($driver);
        $passenger->school()->associate($school);
        $passenger->save();

        $lastRoute = Route::whereHas('passenger', function($query) use ($driver){
            $query->whereBelongsTo($driver);
        })->orderBy('order','DESC')
        ->first();
        $order = isset($lastRoute->order) ? ($lastRoute->order+1) : 1;

        $route = new Route;
        $route->passenger()->associate($passenger);
        $route->school()->associate($school);
        $route->setAttribute('order', $order);
        $route->save();

        return $passenger;
    }

    /**
     * @param  Passenger  $passenger
     * @return Passenger
     */
    public function show(Passenger $passenger): Passenger
    {
        return $passenger->load('address','responsible','school');
    }

    /**
     * @param  UpdatePassengerRequest  $request
     * @param  Passenger  $passenger
     */
    public function update(UpdatePassengerRequest $request, Passenger $passenger): Passenger
    {
        $passengerRequest = $request->passenger;
        $userRequest = $request->user;
        $addressRequest = $request->address;
        
        $school = School::Find($passengerRequest['school_id']);

        $passenger->fill($passengerRequest);
        $passenger->school()->associate($school);
        $passenger->save();

        $responsible = User::find($passenger->responsible_id);
        $responsible->fill($userRequest);
        $responsible->save();

        $address = Address::find($passenger->address_id);
        $address->fill($addressRequest);
        $address->save();

        return $passenger;
    }

    /**
     * @param Passenger  $passenger
     */
    public function destroy(Passenger $passenger)
    {
        $address = $passenger->address();
        $responsible = $passenger->responsible();
        $address->delete();
        $responsible->delete();
        $passenger->delete();
    }
}
