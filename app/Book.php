<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Book extends Model
{
    protected $fillable = ['title', 'author_id', 'amount'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function borrowLogs()
    {
        return $this->hasMany(BorrowLog::class);
    }


    // Custom Accessor
//     Field ini
// akan menghitung jumlah field amount dikurangi jumlah peminjaman untuk buku
// tersebut yang belum dikembalikan.

// Untuk mendapatkan total buku yang sedang dipinjam, kita menggunakan method
// borrowLogs() untuk semua record yang berelasi di model BorrowLog. Selanjutnya,
// kita menggunakan query scope borrowLog untuk mendapatkan hanya data peminjaman
// yang belum dikembalikan. Terakhir, kita menggunakan method count() untuk
// menghitung total model yang kita dapatkan.

// Syntax selanjutnya, kita menghitung field stock dengan mengurangi nilai field
// amount dengan hasil yang kita dapatkan sebelumnya. Terakhir, kita kembalikan nilai
// stock.
    public function getStockAttribute()
    {
        $borrowed = $this->borrowLogs()->borrowed()->count();
        $stock = $this->amount - $borrowed;
        return $stock;
    }

    public static function boot()
    {
        parent::boot();
        self::updating(function($book)
        {
            if ($book->amount < $book->borrowed) {
                Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Jumlah buku $book->title harus >= " . $book->borrowed
                ]);
                return false;
            }
        });

        self::deleting(function($book)
        {
            if ($book->borrowLogs()->count() > 0) {
                Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Buku $book->title sudah pernah dipinjam."
                ]);

                return false;
            }
        });
//         Pada statement if diatas, kita mengecek apakah ada record di BorrowLog untuk
// buku ini. Jika ya, kita buat data session untuk pesan error dan kita batalkan proses
// penghapusan buku.
    }
        
    public function getBorrowedAttribute()
    {
        return $this->borrowLogs()->borrowed()->count();
    }

//     Pada syntax diatas, pada event updating kita mengecek isian field amount dengan
// field borrowed. Field borrowed adalah accessor baru yang kita buat. Field ini berisi
// total buku yang sedang dipinjam. Jika nilai amount kurang dari borrowed, kita set
// flash data untuk pesan error dan mengembalikan nilai false untuk membatalkan
// proses update.
// Pada form buku, kita akan menambahkan helper untuk menampilkan jumlah buku
// yang sedang dipinjam:


    
}
