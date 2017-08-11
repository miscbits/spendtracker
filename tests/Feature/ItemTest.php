<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function setUp() {
        parent::setUp();
        
        $this->item = factory(\App\Item::class)->create();

        $this->updateArray = ['name' => 'Coffee'];
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetItems()
    {
        $response = $this->get(route('items.index'));

        $response->assertStatus(200);

        $response->assertJson(['total' => 1]);
    }

    public function testGetItem() {
        $response = $this->get(route('items.show', $this->item->id));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->item->name]);
    }

    public function testCreateItem() {
        $response = $this->post(route('items.store', $this->updateArray));

        $response->assertStatus(200);

        $response->assertJson($this->updateArray);

        $response = $this->get(route('items.index'));

        $response->assertJson(['total' => 2]);
    }

    public function testUpdateItem() {
        $response = $this->put(route('items.update', array_merge($this->updateArray, ['item' => $this->item->id])));

        $response->assertStatus(200);

        $response->assertJson($this->updateArray);

        $response = $this->get(route('items.index'));

        $response->assertJson(['total' => 1]);
    }

    public function testDestroyItem() {
        $response = $this->delete(route('items.destroy', ['item' => $this->item->id]));

        $response->assertStatus(200);

        $response = $this->get(route('items.index'));

        $response->assertJson(['total' => 0]);
    }
}
