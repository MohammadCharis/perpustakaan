<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('members', function (Blueprint $table): void { $table->id(); $table->string('member_code')->unique(); $table->string('name'); $table->string('email')->nullable()->unique(); $table->string('phone')->nullable(); $table->text('address')->nullable(); $table->date('joined_at'); $table->boolean('active')->default(true); $table->timestamps(); }); }
    public function down(): void { Schema::dropIfExists('members'); }
};
