<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Periode;
use App\Models\Kriteria;
use App\Models\VarianRoti;
use App\Services\SawService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpkSawSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');

        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_login_and_access_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'admin@pelangifood.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $dashboardResponse = $this->get('/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Selamat Datang, Ibu Dian');
        $dashboardResponse->assertSee('PELANGI FOOD');
    }

    public function test_saw_algorithm_calculation_logic()
    {
        $periode = Periode::first();
        $this->assertNotNull($periode);

        $sawService = new SawService();
        $hasil = $sawService->hitung($periode);

        $this->assertTrue($hasil['status']);
        $this->assertCount(8, $hasil['hasil_perankingan']);

        // Pastikan peringkat 1 memiliki nilai preferensi tertinggi
        $rank1 = $hasil['hasil_perankingan'][0];
        $rank2 = $hasil['hasil_perankingan'][1];
        $this->assertGreaterThanOrEqual($rank2['nilai_preferensi'], $rank1['nilai_preferensi']);
        $this->assertEquals(1, $rank1['ranking']);
    }

    public function test_kriteria_and_varian_pages_accessible()
    {
        $admin = User::where('email', 'admin@pelangifood.com')->first();

        $response = $this->actingAs($admin)->get('/kriteria');
        $response->assertStatus(200);
        $response->assertSee('Volume Penjualan');
        $response->assertSee('Keuntungan');

        $response = $this->actingAs($admin)->get('/varian');
        $response->assertStatus(200);
        $response->assertSee('Roti Sisir Mentega Manis');
        $response->assertSee('Roti Coklat Lumer');
    }

    public function test_perhitungan_saw_page_and_steps()
    {
        $admin = User::where('email', 'admin@pelangifood.com')->first();
        $periode = Periode::first();

        $response = $this->actingAs($admin)->get('/perhitungan?periode_id=' . $periode->id);
        $response->assertStatus(200);
        $response->assertSee('Hasil Perangkingan (Vᵢ)');
        $response->assertSee('Matriks Normalisasi (R)');
        $response->assertSee('Matriks Keputusan (X)');
    }

    public function test_laporan_and_cetak_view()
    {
        $admin = User::where('email', 'admin@pelangifood.com')->first();
        $periode = Periode::first();

        $response = $this->actingAs($admin)->get('/laporan?periode_id=' . $periode->id);
        $response->assertStatus(200);
        $response->assertSee('Laporan Rekomendasi Prioritas Produksi');

        $responseCetak = $this->actingAs($admin)->get('/laporan/' . $periode->id . '/cetak');
        $responseCetak->assertStatus(200);
        $responseCetak->assertSee('PELANGI NUSANTARA FOOD');
        $responseCetak->assertSee('Wisnu Nur Yadi');
        $responseCetak->assertSee('Ibu Dian');
        $responseCetak->assertSee('H. Iwan Abdul Hamit');
    }

    public function test_manajemen_can_validate_production_period()
    {
        $manajer = User::where('email', 'manajemen@pelangifood.com')->first();
        $periode = Periode::first();

        $response = $this->actingAs($manajer)->post('/periode/' . $periode->id . '/validasi', [
            'catatan_manajemen' => 'Produksi disetujui penuh untuk periode ini.',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('divalidasi', $periode->fresh()->status);
        $this->assertEquals('Produksi disetujui penuh untuk periode ini.', $periode->fresh()->catatan_manajemen);
    }
}
