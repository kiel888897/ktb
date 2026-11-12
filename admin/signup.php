<?php
/*
| Pendaftaran publik ditutup: sebelumnya siapa pun bisa membuat akun superadmin di sini.
| Akun baru dibuat lewat menu Pengguna di admin (user-create.php), yang butuh login.
*/
http_response_code(404);
header('X-Robots-Tag: noindex, nofollow');
header('Content-Type: text/plain; charset=UTF-8');
echo 'Not Found';
exit;
