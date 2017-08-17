<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseItemsTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    /**
     * Setup for Tests.
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        
        $this->purchase = factory(\App\Purchase::class)
        	->create()
            ->each(function($p) {
                $p->items()->saveMany(factory(\App\Item::class, 3)->create());
            });
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
