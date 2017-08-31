<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemPurchasesTest extends TestCase
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
        
        $this->user = $user;

        $this->item = factory(\App\Item::class)->create();

        $this->item->each(function($i) use ($user) {
            $i->purchases()->saveMany(factory(\App\Purchase::class, 3)->create(['user_id' => $user->id]));
        });
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetPurchases()
    {
        $response = $this->get(route('item.purchases.index', $this->item));

        $response->assertStatus(200);

        $response->assertJson(['total' => 3]);
    }

    public function testGetPurchase() {
        $response = $this->get(route('item.purchases.show', ['item' => $this->item , 'purchase' => $this->item->purchases->first()]));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->item->purchases->first()->name]);
    }

    public function testCreatePurchase() {
        $purchase = factory(\App\Purchase::class)->create(['user_id' => $this->user->id]);

        $response = $this->post(route('item.purchases.store', $this->item), ['purchase_id' => $purchase->id]);

        $response->assertStatus(200);

        $response = $this->get(route('item.purchases.index', $this->item));

        $response->assertJson(['total' => 4]);
    }

    public function testUpdatePurchase() {
        $response = $this->put(route('item.purchases.update', ['item' => $this->item , 'purchase' => $this->item->purchases->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('item.purchases.index', $this->item));

        $response->assertJson(['total' => 2]);
    }

    public function testDestroyPurchase() {
        $response = $this->delete(route('item.purchases.destroy', ['item' => $this->item , 'purchase' => $this->item->purchases()->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('item.purchases.index', [$this->item, $this->item->purchases()->first()]));

        $response->assertJson(['total' => 2]);
    }
}
