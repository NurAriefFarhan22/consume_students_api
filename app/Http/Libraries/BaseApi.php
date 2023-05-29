<?php
// perbedaan helpers dan libraries
// helpers = bikin API
// libraries = pake API
namespace App\Http\Libraries;
// mengatur posisi file : namespace
use Illuminate\Support\Facades\Http;

class BaseApi
{
    // variable yang cuman bisa diakses di class ini dan turunannya
    protected $baseUrl;
    // constractor : menyiapkan isi data, dijalankan otomatis tanpa dipanggil
    public function __construct()
    {
        // var $baseUrl yg diatas diisi nilainya dari isian file .env bagian API_HOST
        // var ini diisi otomatis ketika file/class baseApi dipanggil oleh controller
        $this->baseUrl = "http://127.0.0.1:2222";
    }
    private function client()
    {
        // koneksikan ip dari var $baseUrl ke depandency Http
        // menggunakan depedency Http karena project API nya berbasis web (protokol Http)
        return Http::baseUrl($this->baseUrl);
    }
    public function index(String $endpoint, Array $data = [])
    {
        // manggil ke function client yg diatas, trs manggil path yang dari $endpoint yg dikirim controllernya, kalau ada data yg mau dicari (params di postman) diambil dari parameter2 $data 
        return $this->client()->get($endpoint, $data);
    }
    public function store(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->post($endpoint, $data);
    }

    public function edit(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->get($endpoint, $data);
    }

    public function update(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->patch($endpoint, $data);
    }

    public function delete(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->delete($endpoint, $data);
    }

    public function trash(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->get($endpoint, $data);
    }

    public function restore(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->get($endpoint, $data);
    }

    public function permanent(String $endpoint, Array $data = [])
    {
        // pake post() karena buat route tambah data di projek RESTT API nya pake::post
        return $this->client()->get($endpoint, $data);
    }
    
}

?>