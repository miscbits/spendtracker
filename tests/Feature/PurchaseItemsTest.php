<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseItemsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Setup for Tests.
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        
        $user = factory(\App\User::class)->create();

        $this->be($user);
        
        $this->purchase = factory(\App\Purchase::class)->create(['user_id' => $user->id]);

        $this->purchase->each(function($i) {
            $i->items()->saveMany(factory(\App\Item::class, 3)->create());
        });
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetItems()
    {
        $response = $this->get(route('purchase.items.index', $this->purchase));

        $response->assertStatus(200);

        $response->assertJson(['total' => 3]);
    }

    public function testGetItem() {
        $response = $this->get(route('purchase.items.show', ['purchase' => $this->purchase , 'item' => $this->purchase->items->first()]));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->purchase->items->first()->name]);
    }

    public function testCreateItem() {
        $item = factory(\App\Item::class)->create();

        $response = $this->post(route('purchase.items.store', $this->purchase), ['item_id' => $item->id]);

        $response->assertStatus(200);

        $response = $this->get(route('purchase.items.index', $this->purchase));

        $response->assertJson(['total' => 4]);
    }

    public function testUpdateItem() {
        $response = $this->put(route('purchase.items.update', ['purchase' => $this->purchase , 'item' => $this->purchase->items->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('purchase.items.index', $this->purchase));

        $response->assertJson(['total' => 2]);
    }

    public function testDestroyItem() {
        $response = $this->delete(route('purchase.items.destroy', ['purchase' => $this->purchase , 'item' => $this->purchase->items()->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('purchase.items.index', [$this->purchase, $this->purchase->items()->first()]));

        $response->assertJson(['total' => 2]);
    }
}