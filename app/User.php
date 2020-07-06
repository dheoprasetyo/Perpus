<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

use App\Book;
use App\BorrowLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

//     Method borrow menerima parameter berupa instance dari App\Book. Pada method
// ini, kita mengecek apakah ada record BorrowLog untuk user dan buku tersebut yang
// isian is_returned-nya 0. Jika ya, kita throw BookException dengan pesan yang
// sesuai.
// Terakhir, ketika pengecekan diatas sudah dilewati, kita membuat record BorrowLog
// dan mengembalikan model BorrowLog yang baru dibuat.
    public function borrow(Book $book)
    {
        // cek apakah masih ada stok buku
        if ($book->stock < 1) {
            $html = "Buku $book->title sedang tidak tersedia.";
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>$html
            ]);
        }

        // cek apakah buku ini sedang dipinjam oleh user
        if($this->borrowLogs()->where('book_id',$book->id)->where('is_returned', 0)->count() > 0 ) {
            $html = "Buku $book->title sedang Anda pinjam. ";
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>$html
            ]);
            return false;
            // throw new BookException("Buku $book->title sedang Anda pinjam.");
        }
        $borrowLog = BorrowLog::create(['user_id'=>$this->id, 'book_id'=>$book->id]);
        return $borrowLog;
    }

//     method
// borrowLogs yang akan kita gunakan untuk mengambil semua data peminjaman oleh
// user tersebut
    public function borrowLogs()
    {
        return $this->hasMany(BorrowLog::class);
    }

    public function generateVerificationToken()
    {
        $token = $this->verification_token;
        if (!$token) {
            $token = Str::random(40);
            $this->verification_token = $token;
            $this->save();
        }
        return $token;
    }

//     Di Laravel, untuk mengirim email kita menggunakan fungsi Mail::send(). Opsi ini
// menerima 3 parameter:
// 1. View yang digunakan sebagai template email
// 2. Array asosiatif berisi variable yang akan di-passing ke template email
// 3. Sebuah fungsi (closure) yang digunakan untuk menentukan alamat email
// penerima dan subject email
    public function sendVerification()
    {
        $token = $this->generateVerificationToken();
        $user = $this;
        // $token = Str::random(40);
        // $user->verification_token = $token;
        // $user->save();
        Mail::send('auth.emails.verification', compact('user', 'token'), function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Verifikasi Akun Perpus');
        });
    }

    public function verify()
    {
        $this->is_verified = 1;
        $this->verification_token = null;
        $this->save();
    }
}