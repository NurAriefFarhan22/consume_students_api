<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // menambil data dari input search
        $search = $request->search;
        // memanggil libraries baseAPi method nya index dengan mengirim parameter1 berupa path data dari API nya, parameter2 data untuk mengisi search_nama API nya
        $data = (new BaseApi)->index('/api/students',['search_nama' => $search]);
        // ambil response jsonnya
        $students = $data->json();
        // dd($students);
        // kirim hasil pengembalian data ke blade index
        // ambil propety data dari response json
        return view('index')->with(['students' => $students ['data']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
        $proses = (new BaseApi)->store('/api/students/tambah-data', $data);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with('errors', $errors);
        }else {
            return redirect('/')->with('success', 'Berhasil menambah data baru ke students API');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // proses ambil data api ke route rest api /students/{id}
        $data = (new BaseApi)->edit('/api/students/'.$id);
        if ($data->failed()) {
            // kalau gagal proses $data diatas, ambil deskripsi dari json property data
            $errors = $data->json(['data']);
            // balikin ke halaman awal bersama errors nya
            return redirect()->back()->with(['error' => $errors]);
        }else {
            // kalau berhasil, ambil data jsonnya
            $student = $data->json(['data']);
            // alihin ke blade edit dengan mengirim data $student diatas agar bisa digunakan pada blade
            return view('edit')->with(['student' => $student]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // data yang akand ikirim ($request ke rest apinya)
        $payload = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
        // panggil method update dari baseapi, kirim endpoint (route update dari rest apinya) dan data ($payload diatas)
        $proses = (new BaseApi)->update('api/students/update/'.$id, $payload);
        if ($proses->failed()) {
            // kalau gagal, balikin lagi sama pesan errors dari jsonnnya
            $errors = $proses->json('data');
            return redirect()->back()->with('errors', $errors);
        }else {
            // berhasil, balikin ke halaman awal dengan pesan
            return redirect('/')->with('success', 'Berhasil mengubah data siswa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proses = (new BaseApi)->delete('/api/students/delete/'.$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with('errors', $errors);
        }else {
            return redirect('/')->with('success', 'Berhasil hapus data sementara di API');
        }
    }


    public function trash()
    {
        $proses = (new BaseApi)->trash('/api/students/show/trash');
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with('errors', $errors);
        }else {
            $studentsTrash = $proses->json('data');
            return view('trash')->with(['studentsTrash' => $studentsTrash]);
        }
    }

    public function permanent($id) {
        $proses = (new BaseApi)->permanent('/api/students/trash/delete/permanent/'. $id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect()->back()->with('success', 'Berhasil menghapus data secara peermanent!!');
        }
    }

    public function restore($id) {
        $proses = (new BaseApi)->restore('/api/students/trash/restore/'. $id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil mengembalikan data dari sampah!!');
        }
    }    
}
