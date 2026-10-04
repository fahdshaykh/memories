<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // Copy existing categories into post_categories
        if (Schema::hasTable('categories')) {
            $existing = DB::table('categories')->get();
            foreach ($existing as $item) {
                DB::table('post_categories')->insert([
                    'id'         => $item->id,
                    'title'      => $item->title,
                    'slug'       => $item->slug,
                    'content'    => $item->content,
                    'image'      => $item->image,
                    'status'     => $item->status,
                    'created_at' => $item->created_at ?? now(),
                    'updated_at' => $item->updated_at ?? now(),
                ]);
            }
        }

        // Repoint foreign key on posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')->references('id')->on('post_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            if (Schema::hasTable('categories')) {
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            }
        });

        Schema::dropIfExists('post_categories');
    }
};
