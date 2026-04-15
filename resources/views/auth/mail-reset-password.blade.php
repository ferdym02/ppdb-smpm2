<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color:#007A3E; padding:20px;">
                            <h2 style="color:#ffffff; margin:0;">Reset Password Akun</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">

                            <p>Halo,</p>

                            <p>
                                Kami menerima permintaan untuk mereset password akun Anda pada sistem
                                <strong>PPDB SMK Muhammadiyah 2 Kalianda</strong>.
                            </p>

                            <p>
                                Silakan klik tombol di bawah ini untuk melanjutkan proses reset password:
                            </p>

                            <!-- Button -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ route('password.reset', ['token' => $token]) }}"
                                    style="background-color:#007A3E;
                                          color:#ffffff;
                                          padding:12px 25px;
                                          text-decoration:none;
                                          border-radius:5px;
                                          font-weight:bold;
                                          display:inline-block;">
                                    Reset Password
                                </a>
                            </div>

                            <p>
                                Tautan ini memiliki batas waktu tertentu demi keamanan akun Anda.
                            </p>

                            <p>
                                Jika Anda tidak merasa melakukan permintaan ini, Anda dapat mengabaikan email ini.
                                Tidak ada perubahan yang akan terjadi pada akun Anda.
                            </p>

                            <hr style="border:none; border-top:1px solid #eeeeee; margin:25px 0;">

                            <p style="font-size:12px; color:#777777;">
                                Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color:#f8f9fa; padding:15px; font-size:12px; color:#666;">
                            © {{ date('Y') }} PPDB SMK Muhammadiyah 2 Kalianda<br>
                            All Rights Reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
