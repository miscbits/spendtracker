<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TypeTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();
        
        $this->type = factory(\App\Type::class)->create();

        $this->updateArray = ['name' => 'lunch'];

        $this->be(factory(\App\User::class)->create());
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetTypes()
    {
        $response = $this->get(route('types.index'));

        $response->assertStatus(200);

        $response->assertJson(['total' => 1]);
    }

    public function testGetType() {
        $response = $this->get(route('types.show', $this->type->id));

        $response->assertStatus(200);

        $response->assertJson(['name' => $this->type->name]);
    }

    public function testCreateType() {
        $response = $this->post(route('types.store', $this->updateArray));

        $response->assertStatus(200);

        $response->assertJson($this->updateArray);

        $response = $this->get(route('types.index'));

        $response->assertJson(['total' => 2]);
    }

    public function testUpdateType() {
        $response = $this->put(route('types.update', array_merge($this->updateArray, ['type' => $this->type->id])));

        $response->assertStatus(200);

        $response->assertJson($this->updateArray);

        $response = $this->get(route('types.index'));

        $response->assertJson(['total' => 1]);
    }

    public function testDestroyType() {
        $response = $this->delete(route('types.destroy', ['type' => $this->type->id]));

        $response->assertStatus(200);

        $response = $this->get(route('types.index'));

        $response->assertJson(['total' => 0]);
    }
}
