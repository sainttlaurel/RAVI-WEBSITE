<?php
// Diagnostic page to check Firebase data
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/config.php');
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/firebaseRDB.php');

$db = new firebaseRDB($databaseURL);

echo "<!DOCTYPE html>";
echo "<html><head>";
echo "<title>Firebase Data Check</title>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
    h1 { color: #333; }
    h2 { color: #667eea; margin-top: 30px; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
    pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; border: 1px solid #ddd; }
    .success { color: #28a745; }
    .error { color: #dc3545; }
    .info { background: #e7f3ff; padding: 15px; border-left: 4px solid #2196F3; margin: 20px 0; }
    table { width: 100%; border-collapse: collapse; margin: 20px 0; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background: #667eea; color: white; }
    tr:hover { background: #f5f5f5; }
</style>";
echo "</head><body>";
echo "<div class='container'>";

echo "<h1>🔍 Firebase Data Diagnostic</h1>";

// Check Appointments
echo "<h2>📅 Appointments Table</h2>";
$appointmentsData = $db->retrieve('appointments');
$appointments = json_decode($appointmentsData, true);

echo "<div class='info'>";
echo "<strong>Raw Data:</strong><br>";
echo "<pre>" . htmlspecialchars($appointmentsData) . "</pre>";
echo "</div>";

if (is_array($appointments) && count($appointments) > 0) {
    echo "<p class='success'>✓ Found " . count($appointments) . " appointment(s)</p>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Service</th><th>Status</th><th>Timestamp</th></tr>";
    foreach ($appointments as $id => $apt) {
        if (is_array($apt)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($id) . "</td>";
            echo "<td>" . htmlspecialchars($apt['name'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($apt['email'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($apt['phone'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($apt['service'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($apt['status'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($apt['timestamp'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p class='error'>✗ No appointments found or invalid data</p>";
}

// Check Contact Messages
echo "<h2>💬 Contact Messages Table</h2>";
$contactData = $db->retrieve('contact_messages');
$contacts = json_decode($contactData, true);

echo "<div class='info'>";
echo "<strong>Raw Data:</strong><br>";
echo "<pre>" . htmlspecialchars($contactData) . "</pre>";
echo "</div>";

if (is_array($contacts) && count($contacts) > 0) {
    echo "<p class='success'>✓ Found " . count($contacts) . " contact message(s)</p>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Timestamp</th></tr>";
    foreach ($contacts as $id => $contact) {
        if (is_array($contact)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($id) . "</td>";
            echo "<td>" . htmlspecialchars($contact['name'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($contact['email'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($contact['subject'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars(substr($contact['message'] ?? 'N/A', 0, 50)) . "...</td>";
            echo "<td>" . htmlspecialchars($contact['status'] ?? 'N/A') . "</td>";
            echo "<td>" . htmlspecialchars($contact['timestamp'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p class='error'>✗ No contact messages found or invalid data</p>";
    echo "<p><strong>Possible reasons:</strong></p>";
    echo "<ul>";
    echo "<li>No contact form has been submitted yet</li>";
    echo "<li>The 'contact_messages' table doesn't exist in Firebase</li>";
    echo "<li>Firebase connection issue</li>";
    echo "</ul>";
}

// Summary
echo "<h2>📊 Summary</h2>";
echo "<table>";
echo "<tr><th>Table</th><th>Count</th><th>Status</th></tr>";
echo "<tr><td>Appointments</td><td>" . (is_array($appointments) ? count($appointments) : 0) . "</td><td>" . (is_array($appointments) && count($appointments) > 0 ? "<span class='success'>✓ OK</span>" : "<span class='error'>✗ Empty</span>") . "</td></tr>";
echo "<tr><td>Contact Messages</td><td>" . (is_array($contacts) ? count($contacts) : 0) . "</td><td>" . (is_array($contacts) && count($contacts) > 0 ? "<span class='success'>✓ OK</span>" : "<span class='error'>✗ Empty</span>") . "</td></tr>";
echo "</table>";

echo "<div class='info' style='margin-top: 30px;'>";
echo "<strong>Next Steps:</strong><br>";
echo "<ol>";
echo "<li>If contact messages are empty, try submitting the test form: <a href='test_contact_form.php'>Test Contact Form</a></li>";
echo "<li>After submitting, refresh this page to see if data appears</li>";
echo "<li>Then check the <a href='adminpage.php'>Admin Page</a></li>";
echo "</ol>";
echo "</div>";

echo "</div>";
echo "</body></html>";
?>
