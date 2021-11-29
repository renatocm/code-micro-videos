<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    public function testFillable()
    {
        $category = new Category();
        $this->assertEquals(
            ['name', 'description', 'is_active'],
            $category->getFillable()
        );
    }

    public function testIfUseTraits()
    {
        Genre::create(['name'=>'test']);
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $categoryTraits);
    }

    public function testCasts()
    {
        $casts = ['id' => 'string'];
        $category = new Category();
        $this->assertEquals(
            $casts,
            $category->getCasts()
        );
    }

    public function testIncrementing()
    {

        $category = new Category();
        $this->assertFalse($category->incrementing);
    }

    public function testDateAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        $category = new Category();
        foreach ($dates as $date) {
            $this->assertContains($date, $category->getDates());
        }

        $this->assertCount(count($dates), $category->getDates());
    }
}
