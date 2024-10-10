<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\VaccineCenter;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    public function test_success_registration()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $vaccineCenter = VaccineCenter::create([
            'name' => 'Vaccine Center 1',
            'address' => 'Vaccine Center 1 Address',
            'phone' => '01234567890',
            'email' => 'vaccinecenter1@gmail.com',
            'website' => 'https://vaccinecenter1.com',
            'capacity_per_day' => 100,
        ]);
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nid' => '1234567890',
            'birthday' => '2000-01-01',
            'email' => 'john@gmail.com',
            'phone' => '01234567890',
            'center_id' => $vaccineCenter->id,
        ];

        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/success/1');
        $this->assertDatabaseHas('members', $data);
    }

    public function test_duplicate_registration()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $vaccineCenter = VaccineCenter::create([
            'name' => 'Vaccine Center 1',
            'address' => 'Vaccine Center 1 Address',
            'phone' => '01234567890',
            'email' => 'vaccinecenter1@gmail.com',
            'website' => 'https://vaccinecenter1.com',
            'capacity_per_day' => 100,
        ]);
        Member::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nid' => '1234567890',
            'birthday' => '2000-01-01',
            'email' => 'john@gmail.com',
            'phone' => '01234567890',
            'center_id' => $vaccineCenter->id,
        ]);
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nid' => '1234567890',
            'birthday' => '2000-01-01',
            'email' => 'john@gmail.com',
            'phone' => '01234567890',
            'center_id' => $vaccineCenter->id,
        ];

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors('nid');
        $this->assertCount(1, Member::all());
    }

    public function test_success_registration_with_schedule()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $vaccineCenter = VaccineCenter::create([
            'name' => 'Vaccine Center 1',
            'address' => 'Vaccine Center 1 Address',
            'phone' => '01234567890',
            'email' => 'vaccinecenter1@gmail.com',
            'website' => 'https://vaccinecenter1.com',
            'capacity_per_day' => 100,
        ]);
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nid' => '1234567890',
            'birthday' => '2000-01-01',
            'email' => 'john@gmail.com',
            'phone' => '01234567890',
            'center_id' => $vaccineCenter->id,
        ];

        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/success/1');
        $this->assertDatabaseHas('members', $data);
        $this->assertDatabaseHas('schedules', [
            'member_id' => 1,
            'vaccine_center_id' => $vaccineCenter->id,
            'date' => '2024-10-13 00:00:00', 
        ]);
    }
}
