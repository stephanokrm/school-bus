<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenceRequest;
use App\Models\Absence;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AbsenceController extends Controller
{
    /**
     * @return Builder[]|Collection
     */
    public function index(): array | Collection
    {
        return Absence::query()
            ->whereIn('passenger_id', Passenger::query()->whereBelongsTo(auth()->user(), 'responsible')->pluck('id'))
            ->get();
    }

    /**
     * @param  StoreAbsenceRequest  $request
     * @return Builder|Model
     */
    public function store(StoreAbsenceRequest $request): Builder | Model
    {
        return Absence::query()->create($request->all());
    }

    /**
     * @param  Absence  $absence
     * @return bool|null
     */
    public function destroy(Absence $absence): bool | null
    {
        return $absence->delete();
    }
}
