<?php

namespace Tests\Feature\Videos;

use App\Helpers\DefaultVideoHelper;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        create_permissions();
    }

    public function test_user_with_permissions_can_manage_videos()
    {
        $video1 = DefaultVideoHelper::createDefaultVideo();
        $video2 = DefaultVideoHelper::createDefaultVideo2();
        $video3 = DefaultVideoHelper::createDefaultVideo3();

        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->get(route('videos.manage.index'));

        $response->assertStatus(200);

        $response->assertSee($video1->title);
        $response->assertSee($video2->title);
        $response->assertSee($video3->title);
    }

    public function test_regular_users_cannot_manage_videos()
    {
        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->get(route('videos.manage.index'));

        $response->assertStatus(403); // Forbidden
    }

    public function test_guest_users_cannot_manage_videos()
    {
        $response = $this->get(route('videos.manage.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_videos()
    {
        $superAdmin = $this->loginAsSuperAdmin();

        $response = $this->actingAs($superAdmin)->get(route('videos.manage.index'));

        $response->assertStatus(200);
    }

    public function test_user_without_permissions_can_see_default_videos_page(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }

    public function test_user_with_permissions_can_see_default_videos_page(){
        $user = User::factory()->create();
        $user->givePermissionTo('manage videos');

        $response = $this->actingAs($user)->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }

    public function test_user_with_permissions_can_see_add_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->get(route('videos.manage.create'));

        $response->assertStatus(200);
    }

    public function test_user_without_videos_manage_create_cannot_see_add_videos(){
        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->get(route('videos.manage.create'));

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_videos()
    {
        $videoData = [
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => null,
        ];

        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->post(route('videos.manage.store'), $videoData);

        $response->assertStatus(302);
        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseHas('videos',[
                'title' => $videoData['title'],
                'description' => $videoData['description'],
                'url' => $videoData['url'],
            ]

        );
    }

    public function test_user_without_permissions_cannot_store_videos(){
        $videoData = [
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ];

        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->post(route('videos.manage.store'), $videoData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('videos',[
                'title' => $videoData['title'],
                'description' => $videoData['description'],
                'url' => $videoData['url'],
            ]
        );
    }

    public function test_user_with_permissions_can_destroy_videos()
    {
        $video = Video::create([
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->delete(route('videos.manage.destroy', $video));

        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseMissing('videos',[
                'id' => $video->id,
            ]
        );
    }

    public function test_user_without_permissions_cannot_destroy_videos()
    {
        $video = Video::create([
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->delete(route('videos.manage.destroy', $video->id));

        $response->assertStatus(403);

        $this->assertDatabaseHas('videos',[
                'id' => $video->id,
            ]
        );
    }

    public function test_user_with_permissions_can_see_edit_videos(){
        $video = Video::create([
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->get(route('videos.manage.edit', $video->id));

        $response->assertStatus(200);

        $response->assertSee($video->title);
    }

    public function test_user_without_permissions_cannot_see_edit_videos()
    {
        $video = Video::create([
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->get(route('videos.manage.edit', $video->id));

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_videos()
    {
        $video = Video::create([
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->put(route('videos.manage.update', $video->id), [
            'title' => 'Vídeo de prova modificat',
            'description' => 'Descripció del vídeo de prova modificat',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => null,
        ]);

        $response->assertStatus(302);

        $updatedVideo = Video::find($video->id);
        $this->assertEquals('Vídeo de prova modificat', $updatedVideo->title);
        $this->assertEquals('Descripció del vídeo de prova modificat', $updatedVideo->description);
        $this->assertEquals('https://www.youtube.com/watch?v=123456', $updatedVideo->url);
    }

    public function test_user_without_permissions_cannot_update_videos()
    {
        $video = Video::create([
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->put(route('videos.manage.update', $video->id), [
            'title' => 'Vídeo de prova modificat',
            'description' => 'Descripció del vídeo de prova modificat',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ]);

        $response->assertStatus(403);

        $updatedVideo = Video::find($video->id);
        $this->assertEquals('Vídeo de prova', $updatedVideo->title);
        $this->assertEquals('Descripció del vídeo de prova', $updatedVideo->description);
        $this->assertEquals('https://www.youtube.com/watch?v=123456', $updatedVideo->url);
    }

    public function test_not_logged_users_can_see_default_videos_page(){

        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }

    // Funcions de login per a cada tipus d'usuari
    private function loginAsVideoManager()
    {
        $user = create_video_manager_user();
        $user->save();

        $user->assignRole('video_manager');
        return $user;
    }

    private function loginAsSuperAdmin()
    {
        $user = create_superadmin_user();
        $user->save();

        $user->assignRole('super_admin');
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = create_regular_user();
        $user->save();

        $user->assignRole('regular');
        return $user;
    }
}
