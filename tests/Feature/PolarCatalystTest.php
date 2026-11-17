<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\TournamentMatch;
use App\Livewire\ContactForm;
use App\Livewire\LoginForm;
use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PolarCatalystTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_home_page_returns_ok(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('POLAR CATALYST');
        $response->assertSee('Community Organizer &amp; Creative Marketing Collective', false);
    }

    public function test_events_page_returns_ok(): void
    {
        $response = $this->get('/events');
        $response->assertStatus(200);
        $response->assertSee('Events & Schedules');
    }

    public function test_results_page_returns_ok(): void
    {
        $response = $this->get('/results');
        $response->assertStatus(200);
        $response->assertSee('Results & Leaderboard');
    }

    public function test_contact_page_returns_ok(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Contact');
    }

    public function test_login_page_returns_ok(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Admin Portal');
    }

    public function test_unauthenticated_user_redirected_from_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $admin = Admin::firstOrCreate(
            ['username' => 'admin_test'],
            ['passwordHash' => Hash::make('password')]
        );

        $response = $this->actingAs($admin, 'admin')->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
    }

    public function test_authenticated_admin_can_access_turnamen(): void
    {
        $admin = Admin::firstOrCreate(
            ['username' => 'admin_test'],
            ['passwordHash' => Hash::make('password')]
        );

        $response = $this->actingAs($admin, 'admin')->get('/admin/turnamen');
        $response->assertStatus(200);
        $response->assertSee('Kelola Turnamen & Season');
    }

    public function test_authenticated_admin_can_access_pesan(): void
    {
        $admin = Admin::firstOrCreate(
            ['username' => 'admin_test'],
            ['passwordHash' => Hash::make('password')]
        );

        $response = $this->actingAs($admin, 'admin')->get('/admin/pesan');
        $response->assertStatus(200);
        $response->assertSee('Inbox Pesan Masuk');
    }

    public function test_tournament_creation_and_detail(): void
    {
        $admin = Admin::firstOrCreate(
            ['username' => 'admin_test'],
            ['passwordHash' => Hash::make('password')]
        );

        $t = Tournament::create([
            'name' => 'Fandom Clash Test',
            'season' => 'Season 1',
            'slug' => 'fandom-clash-test-' . time(),
            'game' => 'Valorant',
            'type' => 'PLAYOFF',
            'status' => 'ONGOING',
            'startDate' => now(),
        ]);

        $teamA = Team::create([
            'name' => 'Team Alpha',
            'tournamentId' => $t->id,
        ]);

        $teamB = Team::create([
            'name' => 'Team Beta',
            'tournamentId' => $t->id,
        ]);

        $match = TournamentMatch::create([
            'tournamentId' => $t->id,
            'matchOrder' => 1,
            'roundNumber' => 1,
            'teamAId' => $teamA->id,
            'teamBId' => $teamB->id,
            'status' => 'SCHEDULED',
        ]);

        $response = $this->actingAs($admin, 'admin')->get("/admin/turnamen/{$t->id}");
        $response->assertStatus(200);
        $response->assertSee('Fandom Clash Test');
        $response->assertSee('Team Alpha');
        $response->assertSee('Team Beta');

        // Test public events page displays it
        $eventsResponse = $this->get('/events');
        $eventsResponse->assertStatus(200);
        $eventsResponse->assertSee('Fandom Clash Test');

        // Clean up
        $t->delete();
    }

    public function test_login_livewire_component_authentication(): void
    {
        Admin::create([
            'username' => 'auth_test',
            'passwordHash' => Hash::make('secret123'),
        ]);

        // Failed login
        Livewire::test(LoginForm::class)
            ->set('username', 'auth_test')
            ->set('password', 'wrongpassword')
            ->call('login')
            ->assertSet('errorMessage', 'Username atau password salah.');

        // Successful login
        Livewire::test(LoginForm::class)
            ->set('username', 'auth_test')
            ->set('password', 'secret123')
            ->call('login')
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_contact_form_livewire_submission(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Budi Tester')
            ->set('email', 'budi@example.com')
            ->set('message', 'Halo Polar Catalyst, ini adalah pesan uji coba dari unit test.')
            ->call('submit')
            ->assertSet('successMessage', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');

        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Budi Tester',
            'email' => 'budi@example.com',
        ]);
    }
}
