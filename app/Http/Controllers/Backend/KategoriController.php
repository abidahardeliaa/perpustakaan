<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; //load post model
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\KategoriRequest;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::latest()->paginate(7);
        return view('backend.kategori.index', compact('kategori'));
    }
    public function create() {
        return view('backend.kategori.create');
    }
    public function store(KategoriRequest $request) {
        // Tipe data $request adalah object

        // DD (die dump untuk memeriksa apakah ada value atau record di dalam variable $request yang diambil dari form inputan)
         // dd($request->all());

        DB::table('kategori_buku')->insert([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            //'slug' => $request->nama,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => Auth()->user()->id,
            'updated_by' => Auth()->user()->id,
        ]);

        return redirect()->route('backend.kategori')->with('message', 'Kategori Berhasil Disimpan');
        
    }
    public function destroy($id) {
        DB::table('kategori_buku')->where('id', $id)->delete();

        return redirect()->route('backend.kategori')->with('message', 'Data Konfigurasi Berhasil Dihapus');
    }
    public function edit($id) {
        // apa tipe data dari $id ? tipe datanya string dengan value integer, example "8"
        // Menggunakan first karena kita mau ngambil data hanya 1 yang sesuai dengan ID

        $editKategori =DB::table('kategori_buku')->where('id', $id)->first();

        return view('backend.kategori.edit', compact('editKategori'));
    }
    public function update(KategoriRequest $request,$id) {
        DB::table('kategori_buku')->where('id',$id)->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return redirect()->route('backend.kategori')->with('message', 'Data Kategori di Update');      

    }

}
