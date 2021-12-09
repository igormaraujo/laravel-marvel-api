<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ComicTest extends TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory(User::class)->create();
  }

  public function test_search()
  {
    $response = $this->get('/comics');

    $response->assertStatus(200)->assertSeeText('10');
  }

  public function test_search_with_pagination()
  {
    $response = $this->get('/comics?offset=10');

    $response->assertStatus(200)->assertSeeText('20');
  }

  public function test_search_with_page_size()
  {
    $response = $this->get('/comics?limit=100');

    $response->assertStatus(200)->assertSeeText('100');
  }

  public function test_search_with_parameter()
  {
    $response = $this->get('/comics?titleStartsWith=Spider');

    $response->assertStatus(200)->assertSeeText('Spider');
  }

  public function test_view_detail()
  {
    $response = $this->get('/comics/91992');

    $response->assertStatus(200)->assertSeeText('Fantastic Four by Dan Slott Vol. 1 (Hardcover)');
  }

  public function test_add_remove_favorite()
  {
    $response = $this->actingAs($this->user)->put('/comics/91992');
    $response->assertStatus(204);

    $response = $this->actingAs($this->user)->get('/comics/favorites');
    $response->assertStatus(200)->assertSeeText('91992');

    $response = $this->actingAs($this->user)->delete('/comics/91992');
    $response->assertStatus(204);
  }
}
