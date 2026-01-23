<?php
require 'config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($name === '' || $email === '' || $password === '') {
    $error = 'All fields are required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Invalid email address.';
  } elseif (strlen($password) < 6) {
    $error = 'Password must be at least 6 characters.';
  } else {

    // cek email sudah terdaftar
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
      $error = 'Email already registered.';
    } else {

      $hash = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role, is_active)
        VALUES (?, ?, ?, 'superadmin', 1)
      ");
      $stmt->execute([$name, $email, $hash]);

      $success = 'Superadmin account created successfully. You can sign in now.';
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign Up | Kusuma Trisna Bali</title>
  <link rel="icon" href="favicon.ico" />
  <link href="style.css" rel="stylesheet" />
</head>

<body
  x-data="{ page: 'comingSoon', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
  x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
  :class="{'dark bg-gray-900': darkMode === true}">

  <!-- Preloader -->
  <div
    x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
    class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
    <div
      class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"></div>
  </div>

  <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
    <div class="flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">

      <!-- Form -->
      <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div class="w-full max-w-md pt-5 mx-auto sm:py-10">
          <a
            href="index.html"
            class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
            Back to dashboard
          </a>
        </div>

        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
          <div class="mb-5 sm:mb-8">
            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
              Sign Up
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Create initial superadmin account
            </p>
          </div>

          <?php if ($error): ?>
            <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">
              <?= htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>

          <?php if ($success): ?>
            <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-600">
              <?= htmlspecialchars($success); ?>
            </div>
          <?php endif; ?>

          <form method="POST" class="space-y-5">

            <!-- FULL NAME (ganti fname/lname, gaya tetap) -->
            <div>
              <label class="mb-1 block text-sm text-gray-700 dark:text-gray-400">
                Full Name
              </label>
              <input type="text" name="name" required
                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                       dark:border-gray-700 dark:text-white/90">
            </div>

            <div>
              <label class="mb-1 block text-sm text-gray-700 dark:text-gray-400">Email</label>
              <input type="email" name="email" required
                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                       dark:border-gray-700 dark:text-white/90">
            </div>

            <div>
              <label class="mb-1 block text-sm text-gray-700 dark:text-gray-400">Password</label>
              <input type="password" name="password" required
                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm
                       dark:border-gray-700 dark:text-white/90">
            </div>

            <button
              class="w-full rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white hover:bg-brand-600 transition">
              Sign Up
            </button>

          </form>

          <div class="mt-5">
            <p class="text-sm font-normal text-center text-gray-700 dark:text-gray-400 sm:text-start">
              Already have an account?
              <a href="signin.php" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">
                Sign In
              </a>
            </p>
          </div>

        </div>
      </div>

      <!-- Right panel (unchanged) -->
      <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
        <!-- tetap -->
      </div>

    </div>
  </div>

  <script defer src="bundle.js"></script>
</body>

</html>