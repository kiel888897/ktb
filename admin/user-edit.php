<?php
require 'auth.php';
require_role(['admin', 'superadmin']);
require 'config/database.php';

// ===== VALIDASI ID =====
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: user.php');
    exit;
}

// ===== AMBIL DATA USER =====
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: user.php');
    exit;
}

$error = '';

// ===== PROSES UPDATE =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name      = trim($_POST['name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $role      = $_POST['role'] ?? 'staff';
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $password  = $_POST['password'] ?? '';

    if ($name === '' || $email === '') {
        $error = 'Name and email are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif (!in_array($role, ['superadmin', 'admin', 'staff'], true)) {
        $error = 'Invalid role.';
    } else {

        // cek email unik
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
                    $stmt->execute([
                        $name,
                        $email,
                        $hash,
                        $role,
                        $is_active,
                        $id
                    ]);
                }
            } else {
                $stmt = $pdo->prepare("
                    UPDATE users
                    SET name = ?, email = ?, role = ?, is_active = ?
                    WHERE id = ?
                ");
                $stmt->execute([
                    $name,
                    $email,
                    $role,
                    $is_active,
                    $id
                ]);
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

                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                            Edit User
                        </h2>

                        <a href="user.php"
                            class="inline-flex items-center gap-2 rounded-lg border px-4 py-2 text-sm">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back
                        </a>
                    </div>

                    <div class="rounded-xl border bg-white dark:bg-white/[0.03]">
                        <div class="p-5 sm:p-6 max-w-xl">

                            <?php if ($error): ?>
                                <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">
                                    <?= htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" class="grid gap-6">

                                <input type="text" name="name" required
                                    value="<?= htmlspecialchars($user['name']); ?>"
                                    class="rounded-lg border px-4 py-2">

                                <input type="email" name="email" required
                                    value="<?= htmlspecialchars($user['email']); ?>"
                                    class="rounded-lg border px-4 py-2">

                                <input type="password" name="password"
                                    placeholder="Leave blank to keep current password"
                                    class="rounded-lg border px-4 py-2">

                                <select name="role" class="rounded-lg border px-4 py-2">
                                    <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                                    <option value="seller" <?= $user['role'] === 'seller' ? 'selected' : '' ?>>Seller</option>
                                </select>

                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="is_active" <?= $user['is_active'] ? 'checked' : '' ?>>
                                    Active
                                </label>

                                <div class="flex justify-end gap-3">
                                    <a href="user.php" class="rounded-lg border px-4 py-2 text-sm">Cancel</a>
                                    <button class="rounded-lg bg-brand-500 px-4 py-2 text-sm text-white">
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