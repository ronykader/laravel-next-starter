<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_all_accounts()
    {
        Account::factory()->create();
        $response = $this->get('/api/v1/accounts');
        $response->assertStatus(200)
        ->assertJsonStructure([
            '*' => ['id', 'account_name', 'type', 'account_number', 'account_status', 'balance']
        ]);
    }
    public function test_create_account()
    {
        $user = Sanctum::actingAs(User::factory()->create());
        $data = [
            'user_id' => $user->id,
            'account_name' => 'Test Account',
            'account_number' => '123456789',
            'type' => 'Bank Account',
            'account_status' => 1,
            'balance' => 10000
        ];
        $response = $this->post('/api/v1/accounts', $data);
        $response->assertStatus(201)
            ->assertJson([
               'data' => [
                   'account_name' => $response->json('data.account_name'),
                   'account_number' => $response->json('data.account_number'),
                   'type' => $response->json('data.type'),
               ]
            ]);
        $this->assertDatabaseHas('accounts', $data);
    }
    public function test_get_single_account()
    {
        $account = Account::factory()->create();
        $response = $this->get('/api/v1/accounts/' . $account->id);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'account_name' => $response->json('data.account_name'),
                    'account_number' => $response->json('data.account_number'),
                ]
            ]);
    }
    public function test_update_account()
    {
        $account = Account::factory()->create();
        $data = [
            'user_id' => $account->user_id,
            'account_name' => 'Update Account',
            'account_number' => '123456789',
            'type' => 'Bank Account',
            'account_status' => 1,
            'balance' => 10000,
        ];
        $response = $this->put('/api/v1/accounts/' . $account->id, $data);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'account_name' => 'Update Account'
                ]
            ]);
        $this->assertDatabaseHas('accounts', [
            'account_name' => 'Update Account'
        ]);
    }
    public function test_delete_account()
    {
        $account = Account::factory()->create();
        $response = $this->delete('/api/v1/accounts/' . $account->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id
        ]);
    }
    public function test_validation_error_on_create_account()
    {
        Sanctum::actingAs(User::factory()->create());
        $data = [
            'account_name' => 'Test Account',
        ];
        $response = $this->postJson('/api/v1/accounts', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors('user_id');
    }
}
