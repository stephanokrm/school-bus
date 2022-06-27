<?php

use App\Models\Address;
use App\Models\Driver;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->boolean('goes');
            $table->boolean('returns');
            $table->enum('shift', ['M', 'A', 'N']);
            $table->foreignIdFor(Address::class)->constrained();
            $table->foreignIdFor(Driver::class)->constrained();
            $table->foreignIdFor(School::class)->constrained();
            $table->foreignIdFor(User::class, 'responsible_id')->constrained('users');
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengers');
    }
};
