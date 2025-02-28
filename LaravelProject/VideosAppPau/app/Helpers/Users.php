<?php
use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;


function createDefaultUser()
{
    $user = User::create([
        'name' => config('users.default_user.name'),
        'email' => config('users.default_user.email'),
        'password' => bcrypt(config('users.default_user.password')),
    ]);

    $user->save();


    add_personal_team($user, 'Default Team');

    return $user;
}

function createDefaultTeacher()
{
    $teacher = User::create([
        'name' => config('users.default_teacher.name'),
        'email' => config('users.default_teacher.email'),
        'password' => bcrypt(config('users.default_teacher.password')),
        'super_admin' => true,
    ]);

    $teacher->save();

    add_personal_team($teacher, 'Default Team');


    return $teacher;
}


function add_personal_team(User $user, string $teamName)
{
    $team = Team::create([
        'name' => $teamName,
        'user_id' => $user->id,
        'personal_team' => true,
    ]);

    $user->team()->associate($team);
    $user->save();
}


function create_regular_user()
{
    $user = User::create([
        'name' => 'Regular',
        'email' => 'regular@videosapp.com',
        'password' => bcrypt('123456789'),
    ]);
    add_personal_team($user, 'Default Team');

    return $user;
}

function create_video_manager_user()
{
    $user = User::create([
        'name' => 'Video Manager',
        'email' => 'videosmanager@videosapp.com',
        'password' => bcrypt('123456789'),
    ]);
    add_personal_team($user, 'Default Team');

    return $user;
}



function create_superadmin_user()
{
    $user = User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@videosapp.com',
        'password' => bcrypt('123456789'),
        'super_admin' => true,
    ]);
    add_personal_team($user, 'Default Team');

    return $user;
}

function define_gates()
{
    Gate::define('manage-videos', function (\App\Models\User $user) {
        return $user->hasRole('video_manager') || $user->isSuperAdmin();
    });

    Gate::define('manage-users', function (\App\Models\User $user) {
        return $user->isSuperAdmin();
    });
}


function create_permissions()
{
    $permissions = [
        'manage videos',
        'manage users'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    $roles = [
        'regular' => [],
        'video_manager' => ['manage videos'],
        'super_admin' => Permission::pluck('name')->toArray(),
    ];

    foreach ($roles as $role => $perms) {
        $roleInstance = Role::firstOrCreate(['name' => $role]);
        $roleInstance->syncPermissions($perms);
    }
}
