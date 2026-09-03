<?php

declare(strict_types=1);

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
$message = trim((string) ($_POST['message'] ?? ''));
$captchaToken = (string) ($_POST['g-recaptcha-response'] ?? '');

if (
    $name === '' || mb_strlen($name) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || mb_strlen($email) > 190 || $message === '' || mb_strlen($message) > 5000 || $captchaToken === ''
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
if (!is_array($captchaResult) || empty($captchaResult['success'])) {
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
    $body = "Nama: {$name}\r\nEmail: {$email}\r\nIP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\r\n\r\n{$message}";
    $headers = 'From: ' . SMTP_USER . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'To: ' . RECIPIENT . "\r\n" . 'Subject: ' . $subject . "\r\n" . 'Content-Type: text/plain; charset=UTF-8';
    $data = $headers . "\r\n\r\n" . str_replace("\n.", "\n..", str_replace("\r\n", "\n", $body)) . "\r\n.";
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
