<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotesResources;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class notesController extends Controller
{
    public function index()
    {
        $notes = Notes::all();

        //return collection of posts as a resource
        return new NotesResources(true, 'List data notes', $notes);
    }

    public function show($id)
    {
        if (!auth()->user()) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'], 403);
        }
        $note = Notes::findOrFail($id);

        return new NotesResources(true, 'Detail data notes !',$note);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'editor' && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'], 403);
        } 
        // Validasi data JSON yang masuk
        $validator = Validator::make($request->all(), [
            'judul'     => 'required',
            'catatan'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $notes = Notes::create([
            'judul'     => $request->judul,
            'catatan'   => $request->catatan,
        ]);

        return new NotesResources(true, 'Data Berhasil Ditambahkan !', $notes);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'editor' && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'], 403);
        } 
        $validator = Validator::make($request->all(),[
            'judul' => 'required',
            'catatan' => 'required',
        ]);

        $notes = Notes::findOrFail($id);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $notes->update([
            'judul' => $request->judul,
            'catatan' => $request->catatan,
        ]);

        return new NotesResources(true,'Data berhasil di update!', $notes);
    }


    public function destroy($id)
    {
        if (auth()->user()->role !== 'editor' && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'], 403);
        } 
        $note = Notes::findOrFail($id);

        $note->delete();

        return new NotesResources(true, 'Data note berhasil dihapus', null);
    }
}
