<?php
// Include Firebase configuration and class
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/config.php');
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/firebaseRDB.php');

// Set headers for JSON response
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$service = isset($_POST['service']) ? trim($_POST['service']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate required fields
if (empty($name) || empty($phone) || empty($email) || empty($service) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Prepare data for Firebase
$formData = [
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'address' => $address,
    'service' => $service,
    'message' => $message,
    'timestamp' => date('Y-m-d H:i:s'),
    'status' => 'pending'
];

try {
    // Initialize Firebase
    $firebase = new firebaseRDB($databaseURL);
    
    // Insert data into 'appointments' table
    $result = $firebase->insert('appointments', $formData);
    
    // Check if insertion was successful
    if ($result) {
        echo json_encode([
            'success' => true, 
            'message' => 'Thank you! Your appointment request has been submitted successfully. We will contact you soon!'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Failed to submit form. Please try again.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
