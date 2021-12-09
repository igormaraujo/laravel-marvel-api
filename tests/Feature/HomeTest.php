<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
{

  public function setUp(): void
  {
    parent::setUp();
    $this->user = User::factory(User::class)->create();
  }

  public function test_home_page()
  {
    $response = $this->get('/');

    $response->assertStatus(200);
  }

  public function test_user_authenticated()
  {
    $response = $this->actingAs($this->user)->get('/user');

    $response->assertStatus(200);
  }

  public function test_user_favorites()
  {
    $response = $this->actingAs($this->user)->get('/favorites');

    $response->assertStatus(200);
  }
}
