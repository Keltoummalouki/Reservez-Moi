<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Service;

class UpdateServicesTableAddCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, create default categories based on existing category strings
        $existingCategories = DB::table('services')
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->get()
            ->pluck('category');
            
        foreach ($existingCategories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => \Str::slug($categoryName), 'description' => '']
            );
        }
            
        // Add category_id column to services table
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('category');
        });
        
        // Transfer data from category string to category_id
        $services = Service::all();
        foreach ($services as $service) {
            if (!empty($service->category)) {
                $category = Category::where('name', $service->category)->first();
                if ($category) {
                    $service->category_id = $category->id;
                    $service->save();
                }
            }
        }
        
        // Remove the old category column
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add back the category string column
        Schema::table('services', function (Blueprint $table) {
            $table->string('category')->nullable()->after('price');
        });
        
        // Transfer data from category_id to category string
        $services = Service::all();
        foreach ($services as $service) {
            if ($service->category_id && $service->category) {
                $service->category = $service->category->name;
                $service->save();
            }
        }
        
        // Remove the category_id column
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}