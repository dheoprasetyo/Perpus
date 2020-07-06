{{-- Pada view ini, kita membuat link untuk melakukan verifikasi ke URL /auth/verify/{token}?email=<Sebelum mencoba fitur ini, kita harus mengaktifkan middleware user-shouldverified
di RegisterController agar dia tidak langsung login ketika berhasil
mendaftar. --}}

Klik link berikut untuk melakukan aktivasi akun Perpus:
<a href="{{ $link = url('auth/verify', $token).'?email='.urlencode($user->email) }}"> {{ $link }} </a>