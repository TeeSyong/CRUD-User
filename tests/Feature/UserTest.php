<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_a_user_test()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone_number' => '123456789',
            'password' => 'password123',
            'status' => 'active',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Test User',
                     'email' => 'test@example.com',
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    #[Test]
    public function list_all_users_test()
    {
        // Create 5 users
        \App\Models\User::factory()->count(5)->create();

        // Make a GET request to list users
        $response = $this->getJson('/api/users');

        // Assert we get 200 OK
        $response->assertStatus(200);

        // Assert that the response contains 5 users
        $response->assertJsonCount(5, 'data');
    }

    #[Test]
    public function update_user_test()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone_number' => '987654321',
            'status' => 'inactive',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Updated Name',
                     'email' => 'updated@example.com',
                     'status' => 'inactive',
                 ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    #[Test]
    public function soft_delete_user_test()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(200);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    #[Test]
    public function bulk_delete_users_test()
    {
        $users = User::factory()->count(3)->create();

        $ids = $users->pluck('id')->toArray();

        $response = $this->postJson('/api/users/bulk-delete', [
            'ids' => $ids,
        ]);

        $response->assertStatus(200);

        foreach ($ids as $id) {
            $this->assertSoftDeleted('users', ['id' => $id]);
        }
    }

    #[Test]
    public function export_to_excel_test()
    {
        User::factory()->count(5)->create();

        $response = $this->get('/api/users/export/excel');

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=users.xlsx');
    }
}
