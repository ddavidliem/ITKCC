<h2>Halo, {{ $user->nama_lengkap }}</h2>
<p>Terima kasih telah mendaftar di Pusat Karir ITK. Untuk menyelesaikan proses pendaftaran, kami memerlukan verifikasi
    email Anda.</p>
<p>Silakan klik tautan di bawah ini untuk memverifikasi alamat email Anda:</p>
<a href="http://127.0.0.1:8000/verify-email/{{ $token }}" class="btn btn-outline-dark">Verifikasi Email</a>
<br>
<p>Jika Anda tidak mendaftar di Pusat Karir ITK, Anda dapat mengabaikan email ini. Namun, keamanan akun Anda sangat
    penting, jadi kami sarankan untuk memverifikasi email segera.</p>
<p>Tautan verifikasi ini akan berlaku selama 10 menit. Setelah waktu tersebut, Anda dapat meminta tautan verifikasi baru
    jika diperlukan.</p>
<br>
<h3>Salam,</h3>
<h3>Tim Pusat Karir ITK</h3>
