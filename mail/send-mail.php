<?php

declare(strict_types=1);

require_once __DIR__ . '/../admin/config/mail.php';

const SMTP_HOST = 'mail.kusumatrisnabali.com';
const SMTP_PORT = 465;
const SMTP_USER = 'info@kusumatrisnabali.com';
const SMTP_PASSWORD = '5$$PrV0rae&Fe(^%';
const RECAPTCHA_SECRET = '6LdPkaYtAAAAACTFLeUSSdZMEaa5LlPa4YA9sqBg';
const RECIPIENT = 'info@kusumatrisnabali.com';

function redirectWithStatus(string $status): never
{
    header('Location: ../contact.php?status=' . rawurlencode($status));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithStatus('error');
}

if (!empty($_POST['company'])) {
    redirectWithStatus('success');
}

$name = preg_replace('/[\r\n]+/', ' ', trim((string) ($_POST['name'] ?? ''))) ?? '';
$email = trim((string) ($_POST['email'] ?? ''));
$phone = preg_replace('/[\r\n]+/', ' ', trim((string) ($_POST['phone'] ?? ''))) ?? '';
$message = trim((string) ($_POST['message'] ?? ''));
$captchaToken = (string) ($_POST['recaptcha_token'] ?? '');

if (
    $name === '' || mb_strlen($name) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || mb_strlen($email) > 190 || $phone === '' || mb_strlen($phone) > 30
    || !preg_match('/^[0-9+() .-]+$/', $phone) || $message === ''
    || mb_strlen($message) > 5000 || $captchaToken === ''
) {
    redirectWithStatus('error');
}

// Limit repeated submissions by IP without requiring a user account or session.
$rateFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ktb-contact-' . hash('sha256', $_SERVER['REMOTE_ADDR'] ?? 'unknown') . '.json';
$rateHandle = fopen($rateFile, 'c+');
if ($rateHandle === false) {
    redirectWithStatus('error');
}
flock($rateHandle, LOCK_EX);
$rateData = json_decode(stream_get_contents($rateHandle) ?: '{}', true) ?: [];
$now = time();
$recentRequests = array_values(array_filter($rateData, static fn($timestamp): bool => $timestamp > $now - 600));
if (count($recentRequests) >= 3) {
    flock($rateHandle, LOCK_UN);
    fclose($rateHandle);
    redirectWithStatus('error');
}
$recentRequests[] = $now;
ftruncate($rateHandle, 0);
rewind($rateHandle);
fwrite($rateHandle, json_encode($recentRequests));
fflush($rateHandle);
flock($rateHandle, LOCK_UN);
fclose($rateHandle);

$captchaPayload = http_build_query([
    'secret' => RECAPTCHA_SECRET,
    'response' => $captchaToken,
    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
]);
$captchaContext = stream_context_create([
    'http' => ['method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $captchaPayload, 'timeout' => 8],
]);
$captchaResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $captchaContext);
$captchaResult = $captchaResponse ? json_decode($captchaResponse, true) : null;
if (
    !is_array($captchaResult)
    || empty($captchaResult['success'])
    || ($captchaResult['action'] ?? '') !== 'contact'
    || (float) ($captchaResult['score'] ?? 0) < 0.5
) {
    redirectWithStatus('captcha');
}

function smtpRead($socket): string
{
    $response = '';
    while (($line = fgets($socket, 515)) !== false) {
        $response .= $line;
        if (strlen($line) < 4 || $line[3] !== '-') {
            break;
        }
    }
    return $response;
}

function smtpCommand($socket, string $command, int $expectedCode): void
{
    fwrite($socket, $command . "\r\n");
    $response = smtpRead($socket);
    if ((int) substr($response, 0, 3) !== $expectedCode) {
        throw new RuntimeException('SMTP command failed');
    }
}

$socket = @stream_socket_client('ssl://' . SMTP_HOST . ':' . SMTP_PORT, $errorCode, $errorMessage, 15);
try {
    if ($socket === false) {
        throw new RuntimeException('SMTP connection failed');
    }
    stream_set_timeout($socket, 15);
    if ((int) substr(smtpRead($socket), 0, 3) !== 220) {
        throw new RuntimeException('SMTP greeting failed');
    }
    smtpCommand($socket, 'EHLO kusumatrisnabali.com', 250);
    smtpCommand($socket, 'AUTH LOGIN', 334);
    smtpCommand($socket, base64_encode(SMTP_USER), 334);
    smtpCommand($socket, base64_encode(SMTP_PASSWORD), 235);
    smtpCommand($socket, 'MAIL FROM:<' . SMTP_USER . '>', 250);
    smtpCommand($socket, 'RCPT TO:<' . RECIPIENT . '>', 250);
    smtpCommand($socket, 'DATA', 354);
    $subject = 'Pesan kontak website dari ' . $name;
    $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $plainBody = "Nama: {$name}\r\nEmail: {$email}\r\nTelepon: {$phone}\r\nIP: {$ipAddress}\r\n\r\nPesan:\r\n{$message}";
    $htmlBody = '<!doctype html><html><body style="font-family:Arial,sans-serif;color:#333">'
        . '<h2 style="color:#c1121f">Pesan Baru dari Website</h2>'
        . '<table cellpadding="10" cellspacing="0" border="1" style="border-collapse:collapse;border-color:#ddd;width:100%;max-width:650px">'
        . '<tr><th align="left" style="background:#f5f5f5;width:140px">Nama</th><td>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</td></tr>'
        . '<tr><th align="left" style="background:#f5f5f5">Email</th><td>' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</td></tr>'
        . '<tr><th align="left" style="background:#f5f5f5">Telepon</th><td>' . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . '</td></tr>'
        . '<tr><th align="left" style="background:#f5f5f5">IP</th><td>' . htmlspecialchars($ipAddress, ENT_QUOTES, 'UTF-8') . '</td></tr>'
        . '<tr><th align="left" style="background:#f5f5f5;vertical-align:top">Pesan</th><td style="white-space:pre-wrap">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</td></tr>'
        . '</table></body></html>';
    $boundary = 'ktb_' . bin2hex(random_bytes(12));
    $headers = 'From: ' . SMTP_USER . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'To: ' . RECIPIENT . "\r\n" . 'Subject: ' . $subject . "\r\n" . "MIME-Version: 1.0\r\n" . 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
    $data = $headers . "\r\n\r\n--{$boundary}\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n" . $plainBody
        . "\r\n\r\n--{$boundary}\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n" . $htmlBody
        . "\r\n\r\n--{$boundary}--";
    $data = preg_replace('/\r\n\./', "\r\n..", $data) . "\r\n.";
    smtpCommand($socket, $data, 250);
    smtpCommand($socket, 'QUIT', 221);
    fclose($socket);
    redirectWithStatus('success');
} catch (Throwable $exception) {
    if (is_resource($socket)) {
        fclose($socket);
    }
    error_log('KTB contact mail error: ' . $exception->getMessage());
    redirectWithStatus('error');
}
