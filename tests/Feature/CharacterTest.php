<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class CharacterTest extends TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory(User::class)->create();
  }

  public function test_search()
  {
    $response = $this->get('/characters');

    $response->assertStatus(200)->assertSeeText('10');
  }

  public function test_search_with_pagination()
  {
    $response = $this->get('/characters?offset=10');

    $response->assertStatus(200)->assertSeeText('20');
  }

  public function test_search_with_page_size()
  {
    $response = $this->get('/characters?limit=100');

    $response->assertStatus(200)->assertSeeText('100');
  }

  public function test_search_with_parameter()
  {
    $response = $this->get('/characters?nameStartsWith=Spider');

    $response->assertStatus(200)->assertSeeText('Spider');
  }

  public function test_view_detail()
  {
    $response = $this->get('/characters/1010810');

    $response->assertStatus(200)->assertSeeText('Kate Bishop');
  }

  public function test_add_remove_favorite()
  {
    $response = $this->actingAs($this->user)->put('/characters/1010810');
    $response->assertStatus(204);

    $response = $this->actingAs($this->user)->get('/characters/favorites');
    $response->assertStatus(200)->assertSeeText('1010810');

    $response = $this->actingAs($this->user)->delete('/characters/1010810');
    $response->assertStatus(204);
  }
}
