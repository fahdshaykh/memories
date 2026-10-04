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
        Schema::create('video_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // Copy distinct categories currently used by videos
        $videoCatIds = DB::table('videos')->distinct()->pluck('category_id');
        $idMap = [];

        foreach ($videoCatIds as $oldId) {
            $source = DB::table('categories')->where('id', $oldId)->first()
                   ?? DB::table('post_categories')->where('id', $oldId)->first();
            if ($source) {
                $newId = DB::table('video_categories')->insertGetId([
                    'title'      => $source->title,
                    'slug'       => $source->slug,
                    'content'    => $source->content,
                    'image'      => $source->image,
                    'status'     => $source->status,
                    'created_at' => $source->created_at ?? now(),
                    'updated_at' => $source->updated_at ?? now(),
                ]);
                $idMap[$oldId] = $newId;
            }
        }

        // Drop old foreign key on videos and update category_id
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        foreach ($idMap as $oldId => $newId) {
            DB::table('videos')->where('category_id', $oldId)->update(['category_id' => $newId]);
        }

        Schema::table('videos', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('video_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('video_categories');
    }
};
