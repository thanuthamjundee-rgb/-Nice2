<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('password');
            $table->integer('p_id');
            $table->integer('dep_id');
            $table->integer('level_id');
            $table->timestamps();
        });
        User::create(['firstname' => 'admin','lastname' => 'admin','email' => 'devtai@gmail.com','mobile' => '098xxxxxxx','password' => Hash::make('12345678'),'p_id' => 1,'dep_id' => 1,'level_id' => 1,'created_at' => now(),]);

        Schema::create('building', function (Blueprint $table) {
            $table->id();
            $table->string('build_name');
        });
        Schema::create('department', function (Blueprint $table) {
            $table->id();
            $table->string('dep_name');
        });
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('eq_name');
        });
        Schema::create('position', function (Blueprint $table) {
            $table->id();
            $table->string('position_name');
        });
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('s_status');
        });
        Schema::create('user_level', function (Blueprint $table) {
            $table->id();
            $table->string('level_name');
        });
        Schema::create('repair', function (Blueprint $table) {
            $table->id();
            $table->integer('u_id');
            $table->integer('eq_id');
            $table->string('r_name');
            $table->string('r_serialnumber');
            $table->string('r_detail');
            $table->integer('build_id');
            $table->string('floor');
            $table->string('room');
            $table->integer('s_id');
            $table->integer('head_id');
            $table->integer('technician_id');
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
