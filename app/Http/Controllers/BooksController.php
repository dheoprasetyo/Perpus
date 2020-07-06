<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;
use File;
use App\BorrowLog;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('author')->get();
        $authors = Author::pluck('name','id');
        // dd($books);
        return view('books.index',compact('books','authors'));

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
        $this->validate($request, [
            'title' => 'required|unique:books,title',
            'author_id' => 'required|exists:authors,id',
            'amount' => 'required|numeric',
            'cover' => 'image|max:2048|mimes:jpeg,png,jpg'
            ]);

        $book = Book::create($request->except('cover'));

        // isi field cover jika ada cover yang diupload
        if ($request->hasFile('cover')) {
            // Mengambil file yang diupload
            $uploaded_cover = $request->file('cover');
            // mengambil extension file
            $extension = $uploaded_cover->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename = md5(time()) . '.' . $extension;
            // menyimpan cover ke folder public/img
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $uploaded_cover->move($destinationPath, $filename);
            // mengisi field cover di book dengan filename yang baru dibuat
            $book->cover = $filename;
            $book->save();
        }
        return redirect()->route('books.index')->with('sukses','Data Berhasil Ditambah');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authors = Author::pluck('name','id');
        $book = Book::find($id);
        return view('books.edit')->with(compact('book','authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:books,title,' . $id,
            'author_id' => 'required|exists:authors,id',
            'amount' => 'required|numeric',
            'cover' => 'image|max:2048'
        ]);

        $book = Book::find($id);
        // $book->update($request->all());
        if(!$book->update($request->all())) return redirect()->back();
        if ($request->hasFile('cover')) {
            // menambil cover yang diupload berikut ekstensinya
            $filename = null;
            $uploaded_cover = $request->file('cover');
            $extension = $uploaded_cover->getClientOriginalExtension();
            // membuat nama file random dengan extension
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            // memindahkan file ke folder public/img
            $uploaded_cover->move($destinationPath, $filename);

            // hapus cover lama, jika ada
            if ($book->cover) {
                $old_cover = $book->cover;
                $filepath = public_path() . DIRECTORY_SEPARATOR . 'img'
                . DIRECTORY_SEPARATOR . $book->cover;
                try {
                File::delete($filepath);
                } catch (FileNotFoundException $e) {
                // File sudah dihapus/tidak ada
                }
            }
            // ganti field cover dengan cover yang baru
            $book->cover = $filename;
            $book->save();
        }
        return redirect()->route('books.index')->with('sukses','Data Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $cover = $book->cover;

        if(!$book->delete()) return redirect()->back();
        // hapus cover lama, jika ada
        // if ($book->cover) {
        if ($cover) {
            $old_cover = $book->cover;
            $filepath = public_path() . DIRECTORY_SEPARATOR . 'img'
            . DIRECTORY_SEPARATOR . $book->cover;
        try {
            File::delete($filepath);
        } catch (FileNotFoundException $e) {
        // File sudah dihapus/tidak ada
        }
        }
        // $book->delete();
        return redirect()->route('books.index');
    }

    public function borrow($id)
    {
        $book = Book::findOrFail($id);
        if(Auth::user()->borrow($book)){
        // BorrowLog::create([
        //     'user_id' => Auth::user()->id,
        //     'book_id' => $id
        // ]);
        return redirect('/')->with('sukses','Buku Berhasil Dipinjam');
        }
        return redirect('/');

    }

    public function returnBack($book_id)
    {
        $borrowLog = BorrowLog::where('book_id', $book_id)
        ->where('is_returned', 0)
        ->first();

        if ($borrowLog) {
            $borrowLog->is_returned = true;
            $borrowLog->save();
        }

         return redirect()->route('transaction.admin')->with('sukses','Buku' . $borrowLog->book->title . 'Berhasil Dikembalikan');
    }
}
