<?php
require_once __DIR__ . '/mailer.php';

$to      = ADMIN_EMAIL;
$subject = 'SMTP Test from XAMPP';
$body    = '<h2>SMTP Test</h2><p>If you see this, PHPMailer is working on your XAMPP.</p>';

$result = send_email($to, $subject, $body);

header('Content-Type: text/plain');
echo $result['ok']
    ? "✅ OK: Test email sent to {$to}"
    : "❌ ERROR: {$result['error']}";
