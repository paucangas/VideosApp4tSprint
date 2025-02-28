<?php

namespace Database\Seeders;

use App\Helpers\DefaultVideoHelper;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        create_permissions();

        $superAdmin = create_superadmin_user();
        $superAdmin->save();
        $regularUser = create_regular_user();
        $regularUser->save();
        $videoManager = create_video_manager_user();
        $videoManager->save();

        $defaultUser = createDefaultUser();
        $defaultUser->save();

        $defaultTeacher = createDefaultTeacher();
        $defaultTeacher->save();


        $superAdmin->assignRole('super_admin');
        $regularUser->assignRole('regular');
        $videoManager->assignRole('video_manager');
        $defaultUser->assignRole('regular');
        $defaultTeacher->assignRole('super_admin');

        DefaultVideoHelper::createDefaultVideo();
        DefaultVideoHelper::createDefaultVideo2();
        DefaultVideoHelper::createDefaultVideo3();

        define_gates();

    }
}
