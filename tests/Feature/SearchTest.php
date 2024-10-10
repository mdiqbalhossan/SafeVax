<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\VaccineCenter;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;
    public function test_search_page_is_accessible()
    {
        $response = $this->get('/search');
        $response->assertStatus(200);
    }

    public function test_not_registered()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $nid = '1234567890'; 
        $response = $this->post(route('search.result'), [
            'nid' => $nid,
        ]);
        Log::info('Search response received', ['response' => $response]);
        $response->assertViewIs('search');
        $response->assertViewHas('status', 'Not Registered');
        $response->assertViewHas('link', route('register'));
    }

    public function test_not_scheduled()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $vaccineCenter = $this->createVaccineCenter();
        $member = $this->createMember($vaccineCenter);
        $nid = '1234567890'; 
        $response = $this->post(route('search.result'), [
            'nid' => $nid,
        ]);
        $response->assertViewIs('search');
        $response->assertViewHas('status', 'Not Scheduled');
    }

    public function test_scheduled()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $vaccineCenter = $this->createVaccineCenter();
        $member = $this->createMember($vaccineCenter);
        $member->schedule()->create([
            'vaccine_center_id' => $vaccineCenter->id,
            'date' => '2024-10-13 00:00:00',
        ]);
        $nid = '1234567890'; 
        $response = $this->post(route('search.result'), [
            'nid' => $nid,
        ]);
        $response->assertViewIs('search');
        $response->assertViewHas('status', 'Scheduled');
        $response->assertViewHas('member', $member);
        $response->assertViewHas('date', '13 Oct,2024');
        $response->assertViewHas('center', $vaccineCenter->name);
    }

    public function test_vaccinated()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $vaccineCenter = $this->createVaccineCenter();
        $member = $this->createMember($vaccineCenter);
        $member->schedule()->create([
            'vaccine_center_id' => $vaccineCenter->id,
            'date' => '2024-10-09 00:00:00',
        ]);
        
        $nid = '1234567890'; 
        $response = $this->post(route('search.result'), [
            'nid' => $nid,
        ]);
        $response->assertViewIs('search');
        $response->assertViewHas('status', 'Vaccinated');
    }

    private function createVaccineCenter()
    {
        return VaccineCenter::create([
            'name' => 'Vaccine Center 1',
            'address' => 'Vaccine Center 1 Address',
            'phone' => '01234567890',
            'email' => 'vaccinecenter1@gmail.com',
            'website' => 'https://vaccinecenter1.com',
            'capacity_per_day' => 100,
        ]);
    }

    private function createMember($vaccineCenter)
    {
        return Member::create([
            'nid' => '1234567890',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '01712345678',
            'email' => 'john@doe.com',
            'birthday' => '1990-01-01',
            'center_id' => $vaccineCenter->id,
        ]);
    }
}
