<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - This creates the table
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            // Primary key (auto-incrementing ID)
            $table->id();
            
            // String fields
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable(); // nullable means optional
            
            // Date fields
            $table->date('date_of_birth');
            $table->date('enrollment_date');
            
            
            
            // Integer fields
            $table->integer('age')->nullable();
            
            // Decimal fields (for numbers with decimals)
            $table->decimal('gpa', 3, 2)->nullable(); // 3 digits total, 2 after decimal
            
            // Boolean field
            $table->boolean('is_active')->default(true);
            
            // Timestamps (created_at and updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations - This drops the table
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};

/*
COMMON FIELD TYPES:

$table->id();                           // Auto-incrementing primary key
$table->string('name');                 // VARCHAR(255)
$table->string('name', 100);           // VARCHAR(100) - custom length
$table->text('description');           // TEXT
$table->integer('votes');              // INTEGER
$table->bigInteger('votes');           // BIGINT
$table->decimal('amount', 8, 2);       // DECIMAL with precision
$table->boolean('confirmed');          // BOOLEAN
$table->date('created_at');           // DATE
$table->datetime('created_at');       // DATETIME
$table->timestamp('added_on');        // TIMESTAMP
$table->time('sunrise');              // TIME
$table->json('options');              // JSON
$table->enum('status', ['active', 'inactive']); // ENUM

FIELD MODIFIERS:

->nullable()                          // Allow NULL values
->default('value')                    // Set default value
->unique()                           // Add unique constraint
->index()                            // Add index
->unsigned()                         // For positive numbers only
->after('column')                    // Position after specific column
->first()                           // Position as first column

FOREIGN KEYS:

$table->foreignId('user_id')->constrained(); // Creates user_id and foreign key to users table
$table->foreign('user_id')->references('id')->on('users'); // Manual foreign key
*/
