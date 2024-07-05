<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Pegawai::all())->make(true);
        }
        return view('pages.pegawai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $data = Validator::make($input, [
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required|email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jabatan' => 'required',
            'gaji' => 'required',
        ])->validate();

        $file_url = null;
        if (!empty($request->file('photo'))) {
            $file = $request->file('photo');
            $file_url = $file->store('pegawai', 'public');
        }

        $data['photo'] = $file_url;
        Pegawai::create($data);

        return $this->sendResponse($data, 201, 'Data Berhasil Ditambahkan');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();

        $pegawai = Pegawai::findOrFail($request->id);

        $data = Validator::make($input, [
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required|email',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jabatan' => 'required',
            'gaji' => 'required',
        ])->validate();

        $file_url = null;
        if (!empty($request->file('photo'))) {
            Storage::delete('public/pegawai/' . $pegawai->photo);
            $file = $request->file('photo');
            $file_url = $file->store('pegawai', 'public');
        } else {
            $file_url = $pegawai->photo;
        }

        $data['photo'] = $file_url;

        $pegawai->update($data);

        return $this->sendResponse($data, 201, 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        Storage::delete('public/pegawai/' . $pegawai->photo);

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with(['success' => 'Data Berhasil Dihapus']);

    }
}
