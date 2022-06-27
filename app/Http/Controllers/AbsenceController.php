<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenceRequest;
use App\Models\Absence;
use App\Models\Driver;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AbsenceController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index(): array|Collection
    {
        $driver = Driver::query()
            ->whereBelongsTo(auth()->user())
            ->firstOrFail();

        return Absence::query()
            ->whereHas('passenger', function ($query) use ($driver) {
                $query->whereBelongsTo($driver);
            })
            ->with('passenger')
            ->get();
    }

    /**
     * @param  StoreAbsenceRequest  $request
     * @return Builder|Model
     */
    public function store(StoreAbsenceRequest $request): Builder|Model
    {
        $passenger = Passenger::query()->findOrFail($request->input('passenger_id'));

        $absence = new Absence;
        $absence->fill($request->all());
        $absence->passenger()->associate($passenger);
        $absence->save();

        return $absence;
    }

    /**
     * @param  Absence  $absence
     * @return bool|null
     */
    public function destroy(Absence $absence): bool|null
    {
        return $absence->delete();
    }
}
