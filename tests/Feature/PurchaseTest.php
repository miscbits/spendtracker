<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        
        $this->purchase = factory(\App\Purchase::class)->create();

        $this->updateArray = ['name' => 'Starbucks', 'cost' => 2500];

        $this->be(factory(\App\User::class)->create());
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetPurchases()
    {
        $response = $this->get(route('purchases.index'));

        $response->assertStatus(200);

        $response->assertJson(['total' => 1]);
    }

    public function testGetPurchase() {
        $response = $this->get(route('purchases.show', $this->purchase->id));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->purchase->name]);
    }

    public function testCreatePurchase() {
        $response = $this->post(route('purchases.store', $this->updateArray));

        $response->assertStatus(200);

        $response->assertJson($this->updateArray);

        $response = $this->get(route('purchases.index'));

        $response->assertJson(['total' => 2]);
    }

    public function testUpdatePurchase() {
        $response = $this->put(route('purchases.update', array_merge($this->updateArray, ['purchase' => $this->purchase->id])));

        $response->assertStatus(200);

        $response->assertJson($this->updateArray);

        $response = $this->get(route('purchases.index'));

        $response->assertJson(['total' => 1]);
    }

    public function testDestroyPurchase() {
        $response = $this->delete(route('purchases.destroy', ['purchase' => $this->purchase->id]));

        $response->assertStatus(200);

        $response = $this->get(route('purchases.index'));

        $response->assertJson(['total' => 0]);
    }
}
