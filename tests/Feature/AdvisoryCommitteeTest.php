<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AdvisoryCommittee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdvisoryCommitteeTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        // Set up fake storage disk for photos
        Storage::fake('public');
    }

    /** @test */
    public function it_can_list_advisory_committee_members()
    {
        $member = AdvisoryCommittee::factory()->create([
            'name' => 'John Doe',
            'designation' => 'Advisor',
            'photo' => 'photos/test.jpg',
            'order' => 1,
            'active' => true
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('advisory.index'));

        $response->assertStatus(200)
            ->assertSee($member->name)
            ->assertSee($member->designation);
    }

    /** @test */
    public function it_can_create_new_advisory_committee_member()
    {
        $photo = UploadedFile::fake()->image('advisor.jpg');

        $response = $this->actingAs($this->admin)
            ->post(route('advisory.store'), [
                'name' => 'Jane Doe',
                'designation' => 'Senior Advisor',
                'photo' => $photo,
                'order' => 2,
                'active' => true,
                'type' => 'type1',
                'message' => 'Test message',
                'email' => 'jane@example.com',
                'phone' => '1234567890',
                'officename' => 'Test Office',
                'officeaddress' => '123 Test St'
            ]);

        $response->assertStatus(302); // Redirect after successful creation
        
        $this->assertDatabaseHas('advisory_committees', [
            'name' => 'Jane Doe',
            'designation' => 'Senior Advisor',
            'order' => 2,
            'active' => true,
            'type' => 'type1',
            'message' => 'Test message',
            'email' => 'jane@example.com',
            'phone' => '1234567890',
            'officename' => 'Test Office',
            'officeaddress' => '123 Test St'
        ]);

        // Verify photo was stored
        Storage::disk('public')->assertExists('photos/' . $photo->hashName());
    }

    /** @test */
    public function it_can_update_advisory_committee_member()
    {
        $member = AdvisoryCommittee::factory()->create();
        $newPhoto = UploadedFile::fake()->image('new_advisor.jpg');

        $response = $this->actingAs($this->admin)
            ->put(route('advisory.update', $member->id), [
                'name' => 'Updated Name',
                'designation' => 'Updated Designation',
                'photo' => $newPhoto,
                'order' => 3,
                'active' => false,
                'type' => 'type2',
                'message' => 'Updated message',
                'email' => 'updated@example.com',
                'phone' => '0987654321',
                'officename' => 'Updated Office',
                'officeaddress' => '456 Updated St'
            ]);

        $response->assertStatus(302); // Redirect after successful update

        $this->assertDatabaseHas('advisory_committees', [
            'id' => $member->id,
            'name' => 'Updated Name',
            'designation' => 'Updated Designation',
            'order' => 3,
            'active' => false,
            'type' => 'type2',
            'message' => 'Updated message',
            'email' => 'updated@example.com',
            'phone' => '0987654321',
            'officename' => 'Updated Office',
            'officeaddress' => '456 Updated St'
        ]);
    }

    /** @test */
    public function it_can_delete_advisory_committee_member()
    {
        $member = AdvisoryCommittee::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('advisory.destroy', $member->id));

        $response->assertStatus(302); // Redirect after successful deletion

        $this->assertDatabaseMissing('advisory_committees', ['id' => $member->id]);
    }
}