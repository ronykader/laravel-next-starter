<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_all_users()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->getJson('/api/users');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_create_user()
    {
        $role = Role::factory()->create();
        $data = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'role_id' => $role->id,
        ];
        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@doe.com',
                ]
            ]);
    }
    public function test_get_single_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->getJson("/api/user");
        $response->assertStatus(200)
            ->assertJson([
                    'name' => $user->name,
                    'email' => $user->email

            ]);
    }
    public function test_validation_error_on_create_user()
    {
        $data = [
            'name' => 'Md Tarikul Islam',
        ];
        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['role_id','email']);
    }
}
