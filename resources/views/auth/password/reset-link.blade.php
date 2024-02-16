<h2>Halo, {{ $user->nama_lengkap }}</h2>
<p>Kami menerima permintaan untuk mereset kata sandi akun anda. Jika ini bukan permintaan Anda, silahkan mengabaikan
    email ini <br>
    Jika Anda ingin melanjutkan proses reset password, silahkan klik tautan dibawah ini:</p>
<br>
{{-- <a href='{{ Route('auth.reset.password.token', ['token' => $token]) }}'>Reset password</a> --}}
<a href="http://127.0.0.1:8000/reset-password/form/{{ $token }}" class="btn btn-outline-dark">Reset Password</a>
<p>Tautan tersebut akan mengarahkan Anda ke halaman di mana Anda dapat membuat kata sandi baru untuk akun Anda.
    Mohon
    pastikan untuk segera melakukan reset password agar keamanan akun Anda tetap terjaga. <br>
    Tautan ini hanya berlaku untuk 15 menit setelah penerimaan email ini. Jika Anda tidak melakukan reset password
    dalam
    waktu tersebut, Anda dapat meminta tautan reset password baru.</p>

<br>
<h3>Terima kasih,</h5>
    <h3>Tim Pusat Karir ITK</h5>
