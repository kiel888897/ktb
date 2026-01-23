<?php
require 'auth.php';
require 'config/database.php';

$userId = (int) $_SESSION['user']['id'];

// Ambil data user login
$stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  session_destroy();
  header('Location: signin.php');
  exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name     = trim($_POST['name'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($name === '' || $email === '') {
    $error = 'Name and email are required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Invalid email address.';
  } else {

    // cek email dipakai user lain
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt->execute([$email, $userId]);

    if ($stmt->fetch()) {
      $error = 'Email already used by another account.';
    } else {

      if ($password !== '') {
        if (strlen($password) < 6) {
          $error = 'Password must be at least 6 characters.';
        } else {
          $hash = password_hash($password, PASSWORD_DEFAULT);

          $stmt = $pdo->prepare("
                        UPDATE users
                        SET name = ?, email = ?, password = ?
                        WHERE id = ?
                    ");
          $stmt->execute([$name, $email, $hash, $userId]);
        }
      } else {
        $stmt = $pdo->prepare("
                    UPDATE users
                    SET name = ?, email = ?
                    WHERE id = ?
                ");
        $stmt->execute([$name, $email, $userId]);
      }

      if ($error === '') {
        // update session juga
        $_SESSION['user']['name']  = $name;
        $_SESSION['user']['email'] = $email;

        $success = 'Profile updated successfully.';
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Profile | Kusuma Trisna Bali</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="favicon.ico">
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body
  x-data="{ page: 'profile', loaded: true, darkMode: false, sidebarToggle: false }"
  x-init="
        darkMode = JSON.parse(localStorage.getItem('darkMode'));
        $watch('darkMode', v => localStorage.setItem('darkMode', JSON.stringify(v)))
    "
  :class="{'dark bg-gray-900': darkMode}">

  <!-- Preloader -->
  <div
    x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => setTimeout(() => loaded = false, 500))"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-black">
    <div class="h-16 w-16 animate-spin rounded-full border-4 border-brand-500 border-t-transparent"></div>
  </div>

  <div class="flex h-screen overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <div class="relative flex flex-1 flex-col overflow-y-auto">

      <?php include 'header.php'; ?>

      <main>
        <div class="mx-auto max-w-7xl p-4 md:p-6">

          <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
              My Profile
            </h2>
            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
              Update your personal information
            </p>
          </div>

          <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] max-w-xl">

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

            <form method="POST" class="space-y-6">

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                  Name
                </label>
                <input
                  type="text"
                  name="name"
                  required
                  value="<?= htmlspecialchars($user['name']); ?>"
                  class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                       text-gray-800 focus:border-brand-500 outline-none
                                       dark:border-gray-700 dark:text-white/90">
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                  Email
                </label>
                <input
                  type="email"
                  name="email"
                  required
                  value="<?= htmlspecialchars($user['email']); ?>"
                  class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                       text-gray-800 focus:border-brand-500 outline-none
                                       dark:border-gray-700 dark:text-white/90">
              </div>

              <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                  New Password
                </label>
                <input
                  type="password"
                  name="password"
                  placeholder="Leave blank to keep current password"
                  class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                       text-gray-800 focus:border-brand-500 outline-none
                                       dark:border-gray-700 dark:text-white/90">
              </div>

              <div class="flex justify-end">
                <button
                  type="submit"
                  class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2
                                       text-sm font-medium text-white hover:bg-brand-600 transition">
                  <i class="fa-solid fa-floppy-disk"></i>
                  Update Profile
                </button>
              </div>

            </form>
          </div>

        </div>
      </main>
    </div>
  </div>

  <script defer src="bundle.js"></script>
</body>

</html>