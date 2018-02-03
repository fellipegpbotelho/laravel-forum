<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testActionIndexOnController()
    {
        $user = factory(\App\User::class)->create();
        $this->seed('ThreadsTableSeeder');

        /** @var Collection $threads */
        $threads = Thread::orderBy('updated_at', 'desc')
            ->paginate();

        $response = $this
            ->actingAs($user)
            ->json('GET', '/threads');

        $response->assertStatus(200)
            ->assertJsonFragment([$threads->toArray()['data']]);
    }

    public function testActionStoreOnController()
    {
        $user = factory(\App\User::class)->create();

        $response = $this
            ->actingAs($user)
            ->json('POST', '/threads', [
                'title' => 'Meu primeiro tópico',
                'body' => 'Corpo do meu primeiro tópico',
            ]);

        $thread = Thread::find(1);

        $response->assertStatus(200)
            ->assertJsonFragment(['created' => 'success'])
            ->assertJsonFragment([$thread->toArray()]);
    }

    public function testActionUpdateOnController()
    {
        $user = factory(\App\User::class)->create();
        $thread = factory(\App\Thread::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->json('PUT', '/threads/' . $thread->id, [
                'title' => 'Meu primeiro tópico atualizado',
                'body' => 'Corpo do meu primeiro tópico atualizado',
            ]);

        $thread->title = 'Meu primeiro tópico atualizado';
        $thread->body = 'Corpo do meu primeiro tópico atualizado';

        $response->assertStatus(200)
            ->assertJsonFragment(['updated' => 'success'])
            ->assertJsonFragment([
                'title' => 'Meu primeiro tópico atualizado',
                'body' => 'Corpo do meu primeiro tópico atualizado',
            ]);
    }
}
