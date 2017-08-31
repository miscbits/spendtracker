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
            ->create();
        $this->type->each(function($i) {
            $i->items()->saveMany(factory(\App\Item::class, 3)->create());
        });

        $this->be(factory(\App\User::class)->create());
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetTypes()
    {
        $response = $this->get(route('type.items.index', $this->type));

        $response->assertStatus(200);

        $response->assertJson(['total' => 3]);
    }

    public function testGetType() {
        $response = $this->get(route('type.items.show', ['type' => $this->type , 'item' => $this->type->items->first()]));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->type->items->first()->name]);
    }

    public function testCreateType() {
        $item = factory(\App\Item::class)->create();

        $response = $this->post(route('type.items.store', $this->type), ['item_id' => $item->id]);

        $response->assertStatus(200);

        $response = $this->get(route('type.items.index', $this->type));

        $response->assertJson(['total' => 4]);
    }

    public function testUpdateType() {
        $response = $this->put(route('type.items.update', ['type' => $this->type , 'item' => $this->type->items->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('type.items.index', $this->type));

        $response->assertJson(['total' => 2]);
    }

    public function testDestroyType() {
        $response = $this->delete(route('type.items.destroy', ['type' => $this->type , 'item' => $this->type->items()->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('type.items.index', [$this->type, $this->type->items()->first()]));

        $response->assertJson(['total' => 2]);
    }
}