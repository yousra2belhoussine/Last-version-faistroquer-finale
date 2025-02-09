<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'profile_photo' => $photo,
        ]);

        $this->assertAuthenticated();
        
        // Vérifie que l'utilisateur a été créé
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Récupère l'utilisateur créé
        $user = \App\Models\User::where('email', 'test@example.com')->first();

        // Vérifie que le chemin de la photo est enregistré
        $this->assertNotNull($user->profile_photo_path);

        // Vérifie que le fichier a été stocké
        Storage::disk('public')->assertExists($user->profile_photo_path);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_registration_without_photo_is_successful(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    public function test_registration_with_invalid_photo(): void
    {
        Storage::fake('public');

        $invalidFile = UploadedFile::fake()->create('document.pdf', 1000);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'profile_photo' => $invalidFile,
        ]);

        $response->assertSessionHasErrors('profile_photo');
        $this->assertGuest();
    }

    public function test_registration_with_large_photo(): void
    {
        Storage::fake('public');

        $largePhoto = UploadedFile::fake()->image('large.jpg')->size(3000); // 3MB

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'profile_photo' => $largePhoto,
        ]);

        $response->assertSessionHasErrors('profile_photo');
        $this->assertGuest();
    }
}
