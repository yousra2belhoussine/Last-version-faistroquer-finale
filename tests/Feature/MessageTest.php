<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_message()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Créer une conversation
        $conversation = Conversation::create(['type' => 'private']);
        $conversation->participants()->attach([
            $user1->id => ['role' => 'member'],
            $user2->id => ['role' => 'member']
        ]);

        // Simuler l'authentification du premier utilisateur
        $this->actingAs($user1);

        // Envoyer un message
        $response = $this->post(route('messages.store', $conversation), [
            'content' => 'Bonjour, ceci est un test!'
        ]);

        // Vérifier que le message a été créé
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $user1->id,
            'content' => 'Bonjour, ceci est un test!'
        ]);

        $response->assertRedirect();
    }

    public function test_user_can_view_conversation()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Créer une conversation
        $conversation = Conversation::create(['type' => 'private']);
        $conversation->participants()->attach([
            $user1->id => ['role' => 'member'],
            $user2->id => ['role' => 'member']
        ]);

        // Créer quelques messages
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user1->id,
            'content' => 'Message 1'
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user2->id,
            'content' => 'Message 2'
        ]);

        // Simuler l'authentification du premier utilisateur
        $this->actingAs($user1);

        // Accéder à la conversation
        $response = $this->get(route('messages.show', $conversation));

        $response->assertStatus(200)
                ->assertSee('Message 1')
                ->assertSee('Message 2');
    }
} 