<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolGsmTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function testShowSekolahGsmTerdaftar() {
     
        $response = $this->json('GET', '/api/v1/school-gsm');

        $response
            ->assertStatus(200)
           ;
    }

     public function testMendaftarkanSekolahGsm()
    {
        $response = $this->json('POST', '/api/v1/school-gsm/store', [
            'kode_prop'=> '140000  ',
            'propinsi'=> 'Prov. Kalimantan Tengah',
            'kode_kab_kota'=> '140900  ',
            'kabupaten_kota'=> 'Kab. Lamandau',
            'kode_kec'=> '140906  ',
            'kecamatan'=> 'Kec. Sematu Jaya',
            'id'=> 'B0C44835-30F5-E011-A33F-A394B5415A23',
            'npsn'=> '30202994',
            'sekolah'=> 'SD NEGERI BATU HAMBAWANG',
            'bentuk'=> 'SD',
            'status'=> 'N',
            'alamat_jalan'=> 'Batu Hambawang Rt. 01',
            'lintang'=> '-2.2386953',
            'bujur'=> '111.4695363'
        ]);

        $response->assertStatus(201);
    }

    public function testMenghapusSekolahGsm()
    {
        $response = $this->json('DELETE', '/api/v1/school-gsm/delete', [
            'npsn'=> '30202994'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
            'data' => 1
            ]);
    }

    public function testSekolahGsmPerDaerah()
    {
        $response = $this->json('post', '/api/v1/school-gsm/per-daerah', [
            'kecamatan'=> 'Kec. Sematu Jaya'
        ]);

        $response
            ->assertStatus(200)
            ;
    }

     
    public function testListKecamatanSekolahGsmTerdaftar()
    {
        $response = $this->json('get', '/api/v1/school-gsm/daerah');

        $response
            ->assertStatus(200)
            ;
    }
}

