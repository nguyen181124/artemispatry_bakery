<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Khóa chính, tự động tăng
            $table->string('name'); // Tên nhân viên
            $table->string('email')->unique(); // Email, duy nhất
            $table->string('phone', 20)->nullable(); // Số điện thoại, có thể null
            $table->date('date_of_birth')->nullable(); // Ngày sinh, có thể null
            $table->text('address')->nullable(); // Địa chỉ, có thể null
            $table->string('position', 100)->nullable(); // Chức vụ, có thể null
            $table->decimal('salary', 10, 2)->nullable(); // Lương, có thể null
            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}