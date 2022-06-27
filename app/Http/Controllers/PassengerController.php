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
use Illuminate\Support\Collection;

class PassengerController extends Controller
{
    /**
     * @return array|Collection
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
            ->orderBy('name')
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
            ->firstOrFail();

        $school = School::query()->findOrFail($request->input('passenger.school_id'));

        $responsible = User::query()->create([
            ...$request->get('user'),
            'password' => Hash::make($request->input('user.cpf')),
        ]);

        $address = new Address;
        $address->fill($request->get('address'));
        $address->save();

        $passenger = new Passenger;
        $passenger->fill($request->get('passenger'));
        $passenger->setAttribute('goes', $request->input('passenger.goes', false));
        $passenger->setAttribute('returns', $request->input('passenger.returns', false));
        $passenger->responsible()->associate($responsible);
        $passenger->address()->associate($address);
        $passenger->driver()->associate($driver);
        $passenger->school()->associate($school);
        $passenger->save();

        $lastRoute = Route::query()
            ->whereHas('passenger', function ($query) use ($driver) {
                $query->whereBelongsTo($driver);
            })
            ->orderBy('order', 'DESC')
            ->first();

        $order = isset($lastRoute->order) ? ($lastRoute->order + 1) : 1;

        $route = new Route;
        $route->setAttribute('order', $order);
        $route->passenger()->associate($passenger);
        $route->school()->associate($school);
        $route->save();

        return $passenger;
    }

    /**
     * @param  Passenger  $passenger
     * @return Passenger
     */
    public function show(Passenger $passenger): Passenger
    {
        return $passenger->load('address', 'responsible', 'school');
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
     * @param  Passenger  $passenger
     */
    public function destroy(Passenger $passenger)
    {
        $address = $passenger->address_id;
        $responsible = $passenger->responsible_id;

        Route::where('passenger_id', $passenger->id)->delete();
        $passenger->delete();
        Address::find($address)->delete();
        User::find($responsible)->delete();

    }
}
