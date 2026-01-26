<?php
require 'config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($email === '' || $password === '') {
    $error = 'Email and password are required.';
  } else {

    $stmt = $pdo->prepare("
      SELECT id, name, email, password, role, is_active
      FROM users
      WHERE email = ?
      LIMIT 1
    ");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || (int)$user['is_active'] !== 1) {
      $error = 'Invalid email or password.';
    } elseif (!password_verify($password, $user['password'])) {
      $error = 'Invalid email or password.';
    } else {

      // ✅ KONTRAK SESSION (sesuai auth.php)
      $_SESSION['user'] = [
        'id'    => (int)$user['id'],
        'name'  => $user['name'],
        'email' => $user['email'],
        'role'  => $user['role'],
      ];

      // update last login (kalau kolom ada)
      try {
        $stmt = $pdo->prepare("UPDATE users SET last_login_at = NOW() WHERE id = ?");
        $stmt->execute([$user['id']]);
      } catch (Throwable $e) {
        // abaikan kalau kolom tidak ada
      }

      header('Location: index.php');
      exit;
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign In | Kusuma Trisna Bali</title>
  <link rel="icon" href="favicon.ico">
  <link href="style.css" rel="stylesheet">
</head>

<body
  x-data="{ page: 'comingSoon', loaded: true, darkMode: false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">

  <!-- Preloader -->
  <div
    x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
    class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
    <div class="h-16 w-16 animate-spin rounded-full border-4 border-brand-500 border-t-transparent"></div>
  </div>

  <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
    <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">

      <!-- Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="w-full max-w-md pt-10 mx-auto">

          <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">

            <div class="mb-5 sm:mb-8">
              <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                Sign In
              </h1>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Enter your email and password to sign in!
              </p>
            </div>

            <?php if ($error): ?>
              <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">
                <?= htmlspecialchars($error); ?>
              </div>
            <?php endif; ?>

            <form method="POST">
              <div class="space-y-5">

                <!-- Email -->
                <div>
                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Email<span class="text-error-500">*</span>
                  </label>
                  <input
                    type="email"
                    name="email"
                    value="<?= htmlspecialchars($email ?? '') ?>"
                    required
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                         text-gray-800 shadow-theme-xs
                         focus:border-brand-300 focus:outline-none
                         dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                </div>

                <!-- Password -->
                <div>
                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Password<span class="text-error-500">*</span>
                  </label>
                  <input
                    type="password"
                    name="password"
                    required
                    class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                         text-gray-800 shadow-theme-xs
                         focus:border-brand-300 focus:outline-none
                         dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                </div>

                <!-- Button -->
                <div>
                  <button
                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium
                         text-white transition rounded-lg bg-brand-500 hover:bg-brand-600">
                    Sign In
                  </button>
                </div>

              </div>
            </form>

          </div>
        </div>
      </div>

      <!-- Right panel (tetap) -->
      <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
        <div class="flex items-center justify-center z-1">
          <div class="flex flex-col items-center max-w-xs">
            <img src="src/images/logo/logo.svg" alt="Logo" />
          </div>
        </div>
      </div>

    </div>
  </div>

  <script defer src="bundle.js"></script>
</body>

</html>