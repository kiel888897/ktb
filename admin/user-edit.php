<?php
require 'config/database.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: users.php');
    exit;
}

// Ambil data user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: users.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'admin';
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '') {
        $error = 'Name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif (!in_array($role, ['superadmin', 'admin', 'staff'])) {
        $error = 'Invalid role.';
    } else {

        // cek email unik (kecuali user ini)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);

        if ($stmt->fetch()) {
            $error = 'Email already used by another user.';
        } else {

            if ($password !== '') {
                if (strlen($password) < 6) {
                    $error = 'Password must be at least 6 characters.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $pdo->prepare("
                        UPDATE users
                        SET name = ?, email = ?, password = ?, role = ?, is_active = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([$name, $email, $hash, $role, $is_active, $id]);
                }
            } else {
                $stmt = $pdo->prepare("
                    UPDATE users
                    SET name = ?, email = ?, role = ?, is_active = ?
                    WHERE id = ?
                ");
                $stmt->execute([$name, $email, $role, $is_active, $id]);
            }

            if ($error === '') {
                header('Location: user.php?updated=1');
                exit;
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Kusuma Trisna Bali</title>

    <link rel="icon" href="favicon.ico">
    <link href="style.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body
    x-data="{ page: 'user', loaded: true, darkMode: false, sidebarToggle: false }"
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

                    <!-- Header -->
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                                Edit User
                            </h2>
                            <p class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
                                Perbarui data user
                            </p>
                        </div>

                        <a href="users.php"
                            class="inline-flex items-center gap-2 rounded-lg
                                   border border-gray-300 px-4 py-2
                                   text-sm font-medium text-gray-700
                                   hover:bg-gray-100
                                   dark:border-gray-700 dark:text-gray-300
                                   dark:hover:bg-white/[0.05] transition">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back
                        </a>
                    </div>

                    <!-- Card -->
                    <div
                        class="overflow-hidden rounded-xl border border-gray-200
                               bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="p-5 sm:p-6 max-w-xl">

                            <?php if ($error): ?>
                                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" class="grid grid-cols-1 gap-6">

                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Name
                                    </label>
                                    <input type="text" name="name" required
                                        value="<?= htmlspecialchars($user['name']); ?>"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                </div>

                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Email
                                    </label>
                                    <input type="email" name="email" required
                                        value="<?= htmlspecialchars($user['email']); ?>"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                </div>

                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        New Password
                                    </label>
                                    <input type="password" name="password"
                                        placeholder="Leave blank to keep current password"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                </div>

                                <div>
                                    <label class="mb-2 block font-medium text-gray-700 dark:text-gray-300">
                                        Role
                                    </label>
                                    <select name="role"
                                        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5
                                               text-gray-800 outline-none focus:border-brand-500
                                               dark:border-gray-700 dark:text-white/90">
                                        <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="is_active"
                                        <?= $user['is_active'] ? 'checked' : '' ?>
                                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-700">
                                    <label class="text-sm text-gray-700 dark:text-gray-300">
                                        Active
                                    </label>
                                </div>

                                <div class="flex justify-end gap-3 pt-2">
                                    <a href="users.php"
                                        class="inline-flex items-center gap-2 rounded-lg
                                               border border-gray-300 px-4 py-2
                                               text-sm font-medium text-gray-700
                                               hover:bg-gray-100
                                               dark:border-gray-700 dark:text-gray-300
                                               dark:hover:bg-white/[0.05] transition">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg
                                               bg-brand-500 px-4 py-2
                                               text-sm font-medium text-white
                                               hover:bg-brand-600 transition">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Update User
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script defer src="bundle.js"></script>
</body>

</html>