<?php

use App\Enums\Company\UserRole;
use App\Enums\Company\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('role')
                ->default(UserRole::MEMBER->value);

            $table->unsignedTinyInteger('status')
                ->default(UserStatus::ACTIVE->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'role', 'status']);
        });
    }
};
