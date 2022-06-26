<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Models\Route;
use App\Models\Passenger;
use App\Models\School;
use App\Models\Driver;
use Illuminate\Support\Collection;

class RouteController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index():  array|Collection
    {
        $driver = Driver::query()
        ->whereBelongsTo(auth()->user())
        ->first();

        return Route::query()
            ->whereHas('passenger', function($query) use ($driver){
                $query->whereBelongsTo($driver)
                ->whereDoesntHave('absences', function ($query) {
                    $query->whereDate('absent_at', date('Y-m-d'));
                });
            })->with('passenger')
            ->with('school')
            ->orderBy('order')
            ->get();
        }

    /**
     *
     * @param  StoreRouteRequest  $request
     */
    public function store(StoreRouteRequest $request)
    {
        $driver = Driver::query()
        ->whereBelongsTo(auth()->user())
        ->first();

        Route::whereHas('passenger', function($query) use ($driver){
                $query->whereBelongsTo($driver);
            })->delete();

        foreach ($request->all() as $key => $values) {
            $school = School::Find($values['school_id']);
            $passenger = Passenger::Find($values['passenger_id']);

            $route = new Route;
            $route->fill($values);
            $route->passenger()->associate($passenger);
            $route->school()->associate($school);
            $route->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRouteRequest  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRouteRequest $request, Route $route)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        //
    }
}
