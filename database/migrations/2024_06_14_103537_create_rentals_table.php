<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('car');
            $table->string('name');
            $table->string('ktp');
            $table->text('address');
            $table->string('phone', 20);
            $table->enum('package', ['3', '5', '7']);
            $table->decimal('total_price', 10, 2);
            $table->timestamp('created-at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('packageDescription')->nullable();
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
        Schema::dropIfExists('rentals');
    }
}
