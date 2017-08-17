<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemPurchasesTest extends TestCase
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
        
        $this->item = factory(\App\Item::class)
        	->create()
            ->each(function($i) {
                $i->purchases()->saveMany(factory(\App\Purchase::class, 3)->create());
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
