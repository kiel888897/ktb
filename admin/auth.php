<?php
// auth.php
session_start();

/**
 * =====================================================
 * CEK LOGIN
 * =====================================================
 */
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit;
}

/**
 * =====================================================
 * VALIDASI STRUKTUR SESSION
 * =====================================================
 * WAJIB sesuai kontrak dari signin.php
 */
if (
    !is_array($_SESSION['user']) ||
    !isset(
        $_SESSION['user']['id'],
        $_SESSION['user']['name'],
        $_SESSION['user']['email'],
        $_SESSION['user']['role']
    )
) {
    session_destroy();
    header('Location: signin.php');
    exit;
}

/**
 * =====================================================
 * HELPER: CEK ROLE
 * =====================================================
 * Contoh penggunaan:
 *   require 'auth.php';
 *   require_role(['superadmin']);
 */
function require_role(array $roles): void
{
    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        header('Location: index.php?error=forbidden');
        exit;
    }
}
