<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('energy_consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appliance_id')
                  ->constrained()
                  ->references('id')
                  ->on('appliances')
                  ->onDelete('cascade');
            $table->timestamp('date');
            $table->decimal('consumption')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_consumptions');
    }
}
