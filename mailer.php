<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';   // Composer autoloader
require_once __DIR__ . '/config.mail.php';

/**
 * Send a single email.
 */
function send_email($to, $subject, $htmlBody, $altBody = null, $replyTo = null) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // From
        $mail->setFrom(FROM_EMAIL, FROM_NAME);

        // Recipient
        $mail->addAddress($to);

        // Optional reply-to
        if ($replyTo) {
            $mail->addReplyTo($replyTo);
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $altBody ?? strip_tags($htmlBody);

        $mail->send();
        return ['ok' => true];
    } catch (Exception $e) {
        return ['ok' => false, 'error' => $mail->ErrorInfo];
    }
}

/**
 * Send email to admin and (if present) the submitter.
 */
function email_admin_and_user($formData, $adminSubject, $adminHtmlBody, $userSubject = null, $userHtmlBody = null) {
    $results = [];

    // --- Send to admin ---
    $resAdmin = send_email(ADMIN_EMAIL, $adminSubject, $adminHtmlBody);
    $results['admin_ok']    = $resAdmin['ok'];
    $results['admin_error'] = $resAdmin['ok'] ? null : $resAdmin['error'];

    // --- Send to submitter ---
    $userEmail = null;
    foreach ($formData as $k => $v) {
        if (stripos($k, 'email') !== false && filter_var($v, FILTER_VALIDATE_EMAIL)) {
            $userEmail = $v;
            break;
        }
    }

    if ($userEmail) {
        $resUser = send_email(
            $userEmail,
            $userSubject ?? $adminSubject,
            $userHtmlBody ?? $adminHtmlBody
        );
        $results['user_email'] = $userEmail;
        $results['user_ok']    = $resUser['ok'];
        $results['user_error'] = $resUser['ok'] ? null : $resUser['error'];
    } else {
        $results['user_ok']    = false;
        $results['user_error'] = 'No valid email in form';
    }

    return $results;
}
