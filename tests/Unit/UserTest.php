<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name' => 'Wijaya Saputra',
            'email' => 'wijaya@gmail.com'
        ]);

        $user2 = User::make([
            'name' => 'Robi Irhamni',
            'email' => 'robi@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make()[0];

        if ($user) {
            $user->delete();
        }

        $this->assertTrue(true);
    }

    public function test_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'name' => 'Iwan Setiawan',
            'email' => 'iwan@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect('/home');
    }

    public function test_database_has()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'iwan@gmail.com'
        ]);
    }
    
    public function test_database_missing()
    {
        DB::table('users')
            ->where('email', 'iwan@gmail.com')
            ->delete();

        $this->assertDatabaseMissing('users', [
            'email' => 'iwan@gmail.com'
        ]);
    }

    public function test_if_seeders_works()
    {
        $this->seed(); // Seed all seeders in the seeders folder
        // php artisan db:seed
    }
}
