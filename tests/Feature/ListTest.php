<?php

namespace Tests\Feature;

use App\Models\Lista;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function list_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/lists_test', [
            'name' => 'test Name',
            'description' => 'test description',
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, Lista::all());
        $list = Lista::first();

        $this->assertEquals($list->name, 'test Name');
        $this->assertEquals($list->description, 'test description');
    }
    /** @test  */
    public function list_name_valide()
    {
        $response = $this->post('api/lists_test', [
            'name' => '',
            'description' => 'test description',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    /** @test  */
    public function list_description_valide()
    {
        $response = $this->post('api/lists_test', [
            'name' => 'Test name',
            'description' => '',
        ]);
        $response->assertSessionHasErrors(['description']);
    }


    /** @test  */
    public function list_retrieved()
    {
        $this->withoutExceptionHandling();
        $lists = Lista::factory(2)->create();
        $response = $this->getJson('api/lists_test');
        $response->assertStatus(200);

        $response->assertJson(['lists' => $lists->toArray()]);
    }

    /** @test  */
    public function one_list_retrieved()
    {
        $this->withoutExceptionHandling();

        $list = Lista::factory()->create();

        $response = $this->getJson('api/lists_test/' . $list->id);
        $response->assertStatus(200);

        $response->assertJson(['data' => $list->toArray()]);
    }


    /** @test  */
    public function list_updated()
    {
        $this->withoutExceptionHandling();

        $list = Lista::factory()->create();

        $response = $this->put('api/lists_test/' . $list->id, [
            'name' => 'updated Name',
            'description' => 'updated description',
        ]);

        $response->assertStatus(200);
        $this->assertCount(1, Lista::all());
        $list = $list->fresh();

        $this->assertEquals($list->name, 'updated Name');
        $this->assertEquals($list->description, 'updated description');
    }

    /** @test  */
    public function list_deleted()
    {
        $this->withoutExceptionHandling();

        $list = Lista::factory()->create();
        $response = $this->delete('api/lists_test/' . $list->id);
        $response->assertStatus(200);

        $this->assertCount(0, Lista::all());
    }
}
