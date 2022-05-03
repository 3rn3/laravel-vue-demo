<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public const USER_ID = 'user_id';
    public const PERMISSION_ID = 'permission_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(self::USER_ID);
            $table->unsignedBigInteger(self::PERMISSION_ID);
            $table->timestamps();

            $table->unique([self::USER_ID, self::PERMISSION_ID]);

            $table->foreign(self::USER_ID)
                ->references('id')
                ->on('users');

            $table->foreign(self::PERMISSION_ID)
                ->references('id')
                ->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_permissions');
    }
};
