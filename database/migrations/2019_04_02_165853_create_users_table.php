<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('wp_user')->nullable();
            $table->string('wp_login')->nullable();
            $table->string('wp_password')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->string('agency')->nullable();
            $table->string('favored')->nullable();
            $table->string('type')->nullable();
            $table->string('account')->nullable();
            $table->string('cpf')->nullable();
            $table->float('amount', 12, 6)->default('0');
            $table->float('amount_blocked', 12, 6)->default('0');
            $table->boolean('active')->default('1');
            $table->char('accepted',1)->default('0');
            $table->bigInteger('indication')->default('0');
            $table->string('indication_hash');
            $table->bigInteger('clicks_a')->default('0');
            $table->bigInteger('clicks_b')->default('0');
            $table->float('cpm_a', 8, 2)->default('0');
            $table->float('cpm_b', 8, 2)->default('0');
            $table->text('fonts')->nullable();
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
        Schema::dropIfExists('users');
    }
}
