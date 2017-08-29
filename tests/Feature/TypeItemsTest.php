<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypeItemsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Setup for Tests.
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        
        $this->type = factory(\App\Type::class)
        	->create()
            ->each(function($p) {
                $p->items()->saveMany(factory(\App\Item::class, 3)->create());
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
