<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImpersonateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_impersonate_user()
    {
        // Get or create roles
        $adminRole = Role::firstOrCreate(['name' => 'administrator']);
        
        // Create an admin user
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin_test@test.com',
            'password' => 'password',
            'pin' => '999991',
        ]);
        $admin->assignRole('administrator');

        // Create a target user
        $target = User::create([
            'name' => 'Target Test',
            'email' => 'target_test@test.com',
            'password' => 'password',
            'pin' => '999992',
        ]);

        // Attempt to impersonate as admin
        $response = $this->actingAs($admin)
            ->get(route('admin.users.impersonate', $target->id));

        // Should redirect to admin.home
        $response->assertRedirect(route('admin.home'));
        
        // Session should have impersonator_id
        $this->assertEquals($admin->id, session('impersonator_id'));
        
        // Logged in user should now be the target
        $this->assertEquals($target->id, auth()->id());
    }

    public function test_user_cannot_impersonate()
    {
        // Create a regular user
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user_test@test.com',
            'password' => 'password',
            'pin' => '999993',
        ]);

        // Create a target user
        $target = User::create([
            'name' => 'Target Test',
            'email' => 'target_test@test.com',
            'password' => 'password',
            'pin' => '999994',
        ]);

        // Attempt to impersonate as regular user
        $response = $this->actingAs($user)
            ->get(route('admin.users.impersonate', $target->id));

        // Should return 403 status
        $response->assertStatus(403);
    }
}
