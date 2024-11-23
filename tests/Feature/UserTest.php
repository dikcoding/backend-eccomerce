<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'andika',
            'password' => 'rahasia',
            'name' => 'Andika Fadilla Siagian'
        ])->assertStatus(201)->assertJson([
            "data" => [
                'username' => 'andika',
                'name' => 'Andika Fadilla Siagian'
            ]
        ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)->assertJson([
            "errors" => [
                'username' => [
                    "The username field is required."
                ],
                'password' => [
                    "The password field is required."
                ],
                'name' => [
                    "The name field is required."
                ]
            ]
        ]);
    }

    public function testRegisterUsernameAlreadyExists()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'andika',
            'password' => 'rahasia',
            'name' => 'Andika Fadilla Siagian'
        ])->assertStatus(400)->assertJson([
            "errors" => [
                'username' => [
                    "username already registered"
                ]
            ]
        ]);
    }

    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'test'
        ])->assertStatus(200)->assertJson([
            'data' => [
                'username' => 'test',
                'name' => 'test'
            ]
        ]);

        $user = User::where('username', 'test')->first();
        self::assertNotNull($user->token);
    }

    public function testLoginFailedPasswordWrong()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'test',
            'password' => 'salah'
        ])->assertStatus(401)->assertJson([
            'errors' => [
                "message" => [
                    "Username or Password Wrong"
                ]
            ]
        ]);
    }

    public function testGetSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [
            'Authorization' => 'test'
        ])->assertStatus(200)->assertJson([
            'data' => [
                'username' => 'test',
                'name' => 'test'
            ]
        ]);
    }

    public function testGetUnauthorized()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current')
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
                ]
            ]);
    }

    public function testGetInvalidToken()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [
            'Authorization' => 'salah'
        ])->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'unauthorized'
                ]
            ]
        ]);
    }

    public function testUpdatPasswordSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'test')->first();

        $this->patch(
            '/api/users/current',
            [
                'password' => 'baru'
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'test',
                    'name' => 'test'
                ]
            ]);

        $newUser = User::where('username', 'test')->first();
        self::assertNotEquals($oldUser->password, $newUser->password);
    }
    public function testUpdateNameSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'test')->first();

        $this->patch(
            '/api/users/current',
            [
                'name' => 'dik'
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(200)->assertJson([
            'data' => [
                'username' => 'test',
                'name' => 'dik'
            ]
        ]);

        $newUser = User::where('username', 'test')->first();
        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    public function testUpdateFailed()
    {
        $this->seed([UserSeeder::class]);

        $this->patch(
            '/api/users/current',
            [
                'name' => 'dikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdikdik'
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'name' => [
                        "The name field must not be greater than 100 characters."
                    ]
                ]
            ]);
    }

    public function testLogoutSuccesss()
    {
        $this->seed([UserSeeder::class]);

        $this->delete(uri: '/api/users/logout', headers: [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => true
            ]);
    }

    public function testLogoutFailed()
    {
        $this->seed([UserSeeder::class]);

        $this->delete('/api/users/logout', [
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ]);
    }
}
