<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTypesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Setup for Tests.
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        
        $this->item = factory(\App\Item::class)
        	->create()
            ->each(function($i) {
                $i->types()->saveMany(factory(\App\Type::class, 3)->create());
            });

        $this->be(factory(\App\User::class)->create());

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
