<?php
// Database configuration
$host = 'localhost';
$dbname = 'website_forms';
$username = 'root'; // Change this if needed
$password = ''; // Change this if needed

// Connect to MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Continue without database connection for now
    $pdo = null;
    error_log("Database connection failed: " . $e->getMessage());
}

// Function to send email notifications
function sendFormEmail($formType, $formData, $toAdmin = true) {
    // Admin email address - CHANGE THIS TO YOUR ACTUAL EMAIL
    $adminEmail = "anthonydarkoministries@gmail.com";
    
    if ($toAdmin) {
        // Email to admin
        $to = $adminEmail;
        $subject = "New Form Submission: " . $formType;
        
        $message = "
        <html>
        <head>
            <title>New $formType Submission</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                table { border-collapse: collapse; width: 100%; margin: 15px 0; }
                th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h2>New $formType Form Submission</h2>
            <p>You have received a new form submission from your website:</p>
            <table>";
        
        foreach ($formData as $key => $value) {
            $message .= "<tr><td><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
        }
        
        $message .= "
            </table>
            <p>Submission received on: " . date('Y-m-d H:i:s') . "</p>
            <p>IP Address: " . $_SERVER['REMOTE_ADDR'] . "</p>
            <br>
            <p>Blessings,<br>Anthony Darko Ministries Website</p>
        </body>
        </html>
        ";
    } else {
        // Email to user
        $to = $formData['email'];
        $subject = "Thank you for your submission to Anthony Darko Ministries";
        
        $message = "
        <html>
        <head>
            <title>Thank you for your submission</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                table { border-collapse: collapse; width: 100%; margin: 15px 0; }
                th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h2>Thank you for contacting Anthony Darko Ministries</h2>
            <p>Dear " . htmlspecialchars($formData['firstName']) . ",</p>
            <p>We have received your $formType form submission and appreciate you reaching out to us.</p>
            <p>Our team will review your information and get back to you as soon as possible.</p>
            <p>Below is a copy of the information you submitted:</p>
            <table>";
        
        foreach ($formData as $key => $value) {
            if ($key !== 'email' && $key !== 'firstName') {
                $message .= "<tr><td><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
            }
        }
        
        $message .= "
            </table>
            <br>
            <p>If you have any questions, please don't hesitate to contact us.</p>
            <p>Blessings,<br><strong>Anthony Darko Ministries</strong><br>Spirit Generation Church (Beth Elohim)</p>
            <p>Email: anthonydarkoministries@gmail.com<br>Phone: +27 67 797 9198</p>
        </body>
        </html>
        ";
    }
    
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Anthony Darko Ministries <noreply@anthonydarkoministries.com>" . "\r\n";
    $headers .= "Reply-To: anthonydarkoministries@gmail.com" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email and log result
    $mailSent = mail($to, $subject, $message, $headers);
    
    // Log email sending status for debugging
    error_log("Email sent to: $to - Subject: $subject - Status: " . ($mailSent ? 'Success' : 'Failed'));
    
    return $mailSent;
}

// Process form submissions if they exist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form-type'] ?? '';
    $response = processForm($formType, $pdo);
    
    if ($response['status'] === 'success') {
        // Redirect to a thank you page or back to form with success message
        header('Location: index.php?success=1&form=' . urlencode($formType));
        exit;
    } else {
        header('Location: index.php?error=1&form=' . urlencode($formType));
        exit;
    }
}

function processForm($formType, $pdo) {
    if (!$pdo) {
        return ['status' => 'error', 'message' => 'Database not connected'];
    }
    
    try {
        $result = [];
        switch ($formType) {
            case 'Giving':
                $result = processGivingForm($pdo);
                break;
            case 'New Membership':
                $result = processMembershipForm($pdo);
                break;
            case 'Partnership Commitment':
                $result = processPartnershipForm($pdo);
                break;
            case 'Prayer Request':
                $result = processPrayerForm($pdo);
                break;
            case 'Discipleship Sign-up':
                $result = processDiscipleshipForm($pdo);
                break;
            default:
                return ['status' => 'error', 'message' => 'Unknown form type'];
        }
        
        // If database insertion was successful, send emails
        if ($result['status'] === 'success') {
            // Prepare form data for email
            $formData = [];
            foreach ($_POST as $key => $value) {
                if ($key !== 'form-type') {
                    $formData[$key] = $value;
                }
            }
            
            // Send email to admin
            $adminEmailSent = sendFormEmail($formType, $formData, true);
            
            // Send confirmation email to user if email field exists
            if (!empty($formData['email'])) {
                $userEmailSent = sendFormEmail($formType, $formData, false);
                $result['email_user'] = $userEmailSent;
            }
            
            // Add email status to result
            $result['email_admin'] = $adminEmailSent;
        }
        
        return $result;
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// ... (rest of your form processing functions remain unchanged) ...

// ... (the rest of your HTML code remains unchanged) ...