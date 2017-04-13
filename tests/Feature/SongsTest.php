<?php

namespace Tests\Feature;

use App\Songs;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SongsTest extends TestCase
{
    
    use DatabaseMigrations, DatabaseTransactions;
    
    
    
    /** @test */
    public function when_create_song_user_id_is_stored_in_songs_table()
    {
        $user = factory(User::class)->create(['name'   => 'Srdjan',
                                              'email'  => 'mp4065@gmail.com',
                                              'active' => 1]);
        $this->actingAs($user);
        $songs = factory(Songs::class)->create(['band' => 'Metallica', 'song' => 'Enter Sandman']);
        $this->seeInDatabase('songs', ['band' => 'Metallica', 'song' => 'Enter Sandman'])
             ->assertEquals(auth()->id(), $songs->user_id);
    }
    
    
    
    /** @test */
    public function user_can_see_only_songs_they_added()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this->actingAs($user1);
        factory(Songs::class, 5)->create();
        $this->actingAs($user2);
        factory(Songs::class, 3)->create();
        $songs = Songs::where('user_id', $user1->id)->get();
        $userSongs = $user1->songs;
        $this->assertEquals($songs, $userSongs);
        $this->assertEquals(5, $userSongs->count());
    }
    
}
