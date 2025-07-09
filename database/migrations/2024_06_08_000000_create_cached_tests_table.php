<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cached_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('test_key')->unique();
            $table->json('result');
            $table->longText("test_labels");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cached_tests');
    }
}; 