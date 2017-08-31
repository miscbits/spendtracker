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
            ->create();
        $this->item->each(function($i) {
            $i->types()->saveMany(factory(\App\Type::class, 3)->create());
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
        $response = $this->get(route('item.types.index', $this->item));

        $response->assertStatus(200);

        $response->assertJson(['total' => 3]);
    }

    public function testGetType() {
        $response = $this->get(route('item.types.show', ['item' => $this->item , 'type' => $this->item->types->first()]));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->item->types->first()->name]);
    }

    public function testCreateType() {
        $type = factory(\App\Type::class)->create();

        $response = $this->post(route('item.types.store', $this->item), ['type_id' => $type->id]);

        $response->assertStatus(200);

        $response = $this->get(route('item.types.index', $this->item));

        $response->assertJson(['total' => 4]);
    }

    public function testUpdateType() {
        $response = $this->put(route('item.types.update', ['item' => $this->item , 'type' => $this->item->types->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('item.types.index', $this->item));

        $response->assertJson(['total' => 2]);
    }

    public function testDestroyType() {
        $response = $this->delete(route('item.types.destroy', ['item' => $this->item , 'type' => $this->item->types()->first()]));

        $response->assertStatus(200);

        $response = $this->get(route('item.types.index', [$this->item, $this->item->types()->first()]));

        $response->assertJson(['total' => 2]);
    }
}
