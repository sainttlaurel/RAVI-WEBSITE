<?php
// Include Firebase configuration and class
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/config.php');
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/firebaseRDB.php');

// Enable error logging
error_log("=== CONTACT FORM SUBMISSION START ===");
error_log("POST data: " . print_r($_POST, true));

// Set headers for JSON response
header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("ERROR: Invalid request method");
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get form type (contact or appointment)
$formType = isset($_POST['form_type']) ? trim($_POST['form_type']) : 'contact';
error_log("Form type: " . $formType);

// Get common fields
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

error_log("Name: $name, Email: $email");

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    error_log("ERROR: Missing required fields");
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    error_log("ERROR: Invalid email format");
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Prepare data based on form type
if ($formType === 'contact') {
    // Contact form data
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    
    if (empty($subject)) {
        echo json_encode(['success' => false, 'message' => 'Please provide a subject']);
        exit;
    }
    
    $formData = [
        'form_type' => 'Contact Form',
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s'),
        'status' => 'pending'
    ];
    
    $tableName = 'appointments'; // Changed to use same table
    $successMessage = 'Thank you! Your message has been sent successfully. We will get back to you soon!';
    
} else {
    // Appointment form data
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $service = isset($_POST['service']) ? trim($_POST['service']) : '';
    
    if (empty($phone) || empty($service)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
        exit;
    }
    
    $formData = [
        'form_type' => 'Appointment Request',
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'address' => $address,
        'service' => $service,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s'),
        'status' => 'pending'
    ];
    
    $tableName = 'appointments';
    $successMessage = 'Thank you! Your appointment request has been submitted successfully. We will contact you soon!';
}

try {
    // Initialize Firebase
    $firebase = new firebaseRDB($databaseURL);
    
    error_log("Firebase initialized, inserting into table: $tableName");
    error_log("Data to insert: " . print_r($formData, true));
    
    // Insert data into appropriate table
    $result = $firebase->insert($tableName, $formData);
    
    error_log("Insert result: " . print_r($result, true));
    
    // Check if result contains an error
    $resultData = json_decode($result, true);
    if (isset($resultData['error'])) {
        error_log("ERROR: Firebase returned error: " . $resultData['error']);
        echo json_encode([
            'success' => false, 
            'message' => 'Firebase error: ' . $resultData['error'] . '. Please check Firebase security rules.'
        ]);
    } elseif ($result) {
        error_log("SUCCESS: Data inserted successfully");
        echo json_encode([
            'success' => true, 
            'message' => $successMessage
        ]);
    } else {
        error_log("ERROR: Insert returned false");
        echo json_encode([
            'success' => false, 
            'message' => 'Failed to submit form. Please try again.'
        ]);
    }
} catch (Exception $e) {
    error_log("EXCEPTION: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

error_log("=== CONTACT FORM SUBMISSION END ===");
?>
