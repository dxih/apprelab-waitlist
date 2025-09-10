<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create SQLite database connection
try {
    $db = new PDO('sqlite:waitlist.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS waitlist (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (!isset($input['name']) || !isset($input['email'])) {
        echo json_encode(['success' => false, 'message' => 'Name and email are required']);
        exit;
    }
    
    $name = trim($input['name']);
    $email = trim($input['email']);
    
    // Basic validation
    if (empty($name) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Name and email cannot be empty']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }
    
    try {
        // Insert into database
        $stmt = $db->prepare("INSERT INTO waitlist (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Send email notifications
        $emailResult = sendEmailNotifications($name, $email);
        
        if ($emailResult) {
            echo json_encode(['success' => true, 'message' => 'Successfully joined the waitlist! Check your email for confirmation.']);
        } else {
            // Still return success but with a note about email
            echo json_encode(['success' => true, 'message' => 'Successfully joined the waitlist! Email confirmation may be delayed.']);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // SQLite constraint violation (unique email)
            echo json_encode(['success' => false, 'message' => 'This email is already on the waitlist']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Function to send email notifications
function sendEmailNotifications($name, $email) {
    $userResult = sendUserEmail($name, $email);
    $adminResult = sendAdminEmail($name, $email);
    
    return $userResult && $adminResult;
}

// Function to send email to user
function sendUserEmail($name, $email) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings for Mailtrap
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'efd95e2ad5271e';    // Your Mailtrap username
        $mail->Password = '4dbf6ef7ab5abd';    // Your Mailtrap password
        $mail->Port = 2525;                    // Mailtrap port
        $mail->SMTPSecure = 'tls';             // Mailtrap uses TLS, not SMTPS
        
        // Recipients
        $mail->setFrom('noreply@apprelab.com', 'AppRelab');
        $mail->addAddress($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to the AppRelab Waitlist!';
        $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(90deg, #3B82F6, #F97316); padding: 20px; text-align: center; color: white; }
                    .content { padding: 20px; background: #f9f9f9; }
                    .footer { padding: 20px; text-align: center; color: #777; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>AppRelab</h1>
                    </div>
                    <div class='content'>
                        <h2>Welcome to the AppRelab Waitlist, $name!</h2>
                        <p>Thank you for joining our waitlist. We're excited to have you on board!</p>
                        <p>We'll notify you as soon as AppRelab is launched. You'll be among the first to experience our revolutionary app development platform.</p>
                        <p>In the meantime, follow us on social media to stay updated:</p>
                        <p>
                            <a href='#'>Twitter</a> | 
                            <a href='#'>LinkedIn</a> | 
                            <a href='#'>Instagram</a>
                        </p>
                    </div>
                    <div class='footer'>
                        <p>© 2023 AppRelab. All rights reserved.</p>
                        <p>If you did not sign up for this waitlist, please ignore this email.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        
        $mail->AltBody = "Welcome to the AppRelab Waitlist, $name!\n\nThank you for joining our waitlist. We're excited to have you on board!\n\nWe'll notify you as soon as AppRelab is launched. You'll be among the first to experience our revolutionary app development platform.\n\n© 2023 AppRelab. All rights reserved.";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error but don't show to user
        error_log("User email error: " . $mail->ErrorInfo);
        return false;
    }
}

// Function to send email to admin
function sendAdminEmail($name, $email) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings for Mailtrap
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'efd95e2ad5271e';    // Your Mailtrap username
        $mail->Password = '4dbf6ef7ab5abd';    // Your Mailtrap password
        $mail->Port = 2525;                    // Mailtrap port
        $mail->SMTPSecure = 'tls';             // Mailtrap uses TLS, not SMTPS
        
        // Recipients
        $mail->setFrom('noreply@apprelab.com', 'AppRelab Waitlist');
        $mail->addAddress('admin@apprelab.com', 'AppRelab Admin');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Waitlist Signup - AppRelab';
        $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(90deg, #3B82F6, #F97316); padding: 20px; text-align: center; color: white; }
                    .content { padding: 20px; background: #f9f9f9; }
                    .footer { padding: 20px; text-align: center; color: #777; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>AppRelab Waitlist Notification</h1>
                    </div>
                    <div class='content'>
                        <h2>New Waitlist Signup</h2>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
                    </div>
                    <div class='footer'>
                        <p>© 2023 AppRelab. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        
        $mail->AltBody = "New Waitlist Signup\n\nName: $name\nEmail: $email\nDate: " . date('Y-m-d H:i:s');
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error but don't show to user
        error_log("Admin email error: " . $mail->ErrorInfo);
        return false;
    }
}
?>