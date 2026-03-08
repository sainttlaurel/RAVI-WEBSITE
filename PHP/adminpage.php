<?php
session_start();

// Simple authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adminlogin.php');
    exit;
}

// Include Firebase configuration
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/config.php');
require_once(__DIR__ . '/../ravi(htdocs)FIREBASE-PHP/firebaseRDB.php');

$db = new firebaseRDB($databaseURL);

// Get filter type from URL parameter
$filterType = isset($_GET['type']) ? $_GET['type'] : 'all';

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['item_id'];
    $table = $_POST['table_name'];
    $db->update($table, $id, ['status' => 'completed']);
    header('Location: adminpage.php?type=' . $filterType);
    exit;
}

// Handle delete
if (isset($_POST['delete_item'])) {
    $id = $_POST['item_id'];
    $table = $_POST['table_name'];
    $db->delete($table, $id);
    header('Location: adminpage.php?type=' . $filterType);
    exit;
}

// Handle bulk delete
if (isset($_POST['bulk_delete'])) {
    $items = $_POST['selected_items'] ?? [];
    foreach ($items as $item) {
        list($table, $id) = explode(':', $item);
        $db->delete($table, $id);
    }
    header('Location: adminpage.php?type=' . $filterType);
    exit;
}

// Retrieve all submissions from appointments table
$appointmentsData = $db->retrieve('appointments');
$allSubmissions = json_decode($appointmentsData, true);

// Debug: Log what we're getting
error_log("Appointments Data Raw: " . $appointmentsData);
error_log("All Submissions Count: " . (is_array($allSubmissions) ? count($allSubmissions) : 'not array'));

// Ensure data is array
if (!is_array($allSubmissions)) {
    $allSubmissions = [];
} else {
    $allSubmissions = array_filter($allSubmissions, function($item) {
        return is_array($item);
    });
}

// Separate by form type and add metadata
$appointments = [];
$contacts = [];
$allItems = [];

foreach ($allSubmissions as $key => $item) {
    if (is_array($item)) {
        // Add table and id to each item
        $item['table'] = 'appointments';
        $item['id'] = $key;
        
        // Add to allItems
        $allItems[$key] = $item;
        
        // Check form_type to categorize
        if (isset($item['form_type']) && $item['form_type'] === 'Contact Form') {
            $contacts[$key] = $item;
        } else {
            $appointments[$key] = $item;
        }
    }
}

// Debug: Log filtered counts
error_log("Filtered Appointments: " . count($appointments));
error_log("Filtered Contacts: " . count($contacts));

// Debug: Output to page (temporary)
if (isset($_GET['debug'])) {
    echo "<pre style='background: #f0f0f0; padding: 20px; margin: 20px; border: 2px solid #333;'>";
    echo "=== DEBUG INFO ===\n\n";
    echo "Total Submissions: " . count($allSubmissions) . "\n";
    echo "Appointments: " . count($appointments) . "\n";
    echo "Contacts: " . count($contacts) . "\n\n";
    echo "All Items:\n";
    foreach ($allItems as $key => $item) {
        echo "ID: $key\n";
        echo "  form_type: " . ($item['form_type'] ?? 'NOT SET') . "\n";
        echo "  name: " . ($item['name'] ?? 'N/A') . "\n";
        echo "  email: " . ($item['email'] ?? 'N/A') . "\n";
        if (isset($item['subject'])) echo "  subject: " . $item['subject'] . "\n";
        if (isset($item['service'])) echo "  service: " . $item['service'] . "\n";
        echo "\n";
    }
    echo "</pre>";
}

// Filter based on type
if ($filterType === 'appointments') {
    $filteredItems = $appointments;
} elseif ($filterType === 'contacts') {
    $filteredItems = $contacts;
} else {
    $filteredItems = $allItems;
}

// Calculate statistics
$totalAppointments = count($appointments);
$totalContacts = count($contacts);
$totalAll = $totalAppointments + $totalContacts;
$pending = 0;
$completed = 0;

foreach ($allItems as $item) {
    if (is_array($item) && isset($item['status'])) {
        if ($item['status'] === 'pending') {
            $pending++;
        } elseif ($item['status'] === 'completed') {
            $completed++;
        }
    }
}

// Sort items by timestamp (newest first)
uasort($filteredItems, function($a, $b) {
    $timeA = isset($a['timestamp']) ? strtotime($a['timestamp']) : 0;
    $timeB = isset($b['timestamp']) ? strtotime($b['timestamp']) : 0;
    return $timeB - $timeA;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Appointment Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            padding: 0;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            background: white;
            padding: 20px 35px;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slideDown 0.5s ease;
            border-left: 4px solid #667eea;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header h1 {
            color: #2C3E50;
            font-size: 28px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1 i {
            color: #667eea;
            font-size: 28px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        /* Stats Cards */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease;
            position: relative;
            overflow: hidden;
            border-top: 3px solid transparent;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card i {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .stat-card.pending i { color: #f39c12; }
        .stat-card.completed i { color: #27ae60; }
        .stat-card.total i { color: #3498db; }

        .stat-card h3 {
            font-size: 36px;
            color: #2C3E50;
            margin: 8px 0;
            font-weight: 600;
        }

        .stat-card p {
            color: #7f8c8d;
            font-size: 14px;
            font-weight: 500;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            animation: fadeIn 0.7s ease;
        }

        .table-header {
            padding: 20px 30px;
            background: white;
            border-bottom: 2px solid #f0f0f0;
            color: #2C3E50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2C3E50;
        }

        .table-header h2 i {
            color: #667eea;
        }

        .table-controls {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 10px 40px 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: #f8f9fa;
            color: #2C3E50;
            font-family: 'Poppins', sans-serif;
            width: 250px;
            transition: all 0.3s;
        }

        .search-box input::placeholder {
            color: #95a5a6;
        }

        .search-box input:focus {
            outline: none;
            background: white;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #e0e0e0;
            background: white;
            color: #2C3E50;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 14px;
        }

        .filter-btn:hover {
            background: #f8f9fa;
            border-color: #667eea;
            color: #667eea;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        /* Table Styles */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 16px 15px;
            text-align: left;
            font-weight: 600;
            color: #2C3E50;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e0e0e0;
        }

        th input[type="checkbox"] {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        td {
            padding: 16px 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #34495e;
            font-size: 14px;
        }

        tbody tr {
            transition: all 0.2s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        /* Type Badges */
        .type-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
        }

        .type-appointments {
            background: #d1ecf1;
            color: #0c5460;
        }

        .type-contact_messages {
            background: #e2d9f3;
            color: #5a3a7a;
        }

        /* Filter button styles */
        .filter-btn {
            text-decoration: none;
            color: #667eea;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
        }

        /* Action Buttons */
        .action-btn {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.2s;
            margin-right: 5px;
            font-size: 13px;
        }

        .btn-complete {
            background: #27ae60;
            color: white;
        }

        .btn-complete:hover {
            background: #229954;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .btn-view {
            background: #3498db;
            color: white;
        }

        .btn-view:hover {
            background: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .bulk-actions {
            padding: 16px 30px;
            background: #f8f9fa;
            border-top: 2px solid #e0e0e0;
            display: none;
            align-items: center;
            gap: 15px;
        }

        .bulk-actions.active {
            display: flex;
        }

        .bulk-delete-btn {
            padding: 10px 20px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 14px;
        }

        .bulk-delete-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .no-data {
            text-align: center;
            padding: 80px 20px;
            color: #7f8c8d;
        }

        .no-data i {
            font-size: 80px;
            margin-bottom: 25px;
            opacity: 0.3;
        }

        .no-data h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .logout-btn {
            padding: 10px 24px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            animation: fadeIn 0.3s;
            overflow-y: auto;
            padding: 20px;
        }

        .modal-content {
            background: white;
            margin: 20px auto;
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 650px;
            max-height: calc(100vh - 40px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: slideUp 0.3s;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            background: #667eea;
            color: white;
            padding: 20px 30px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .modal-header h2 {
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close {
            color: white;
            font-size: 32px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            line-height: 1;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close:hover {
            transform: rotate(90deg);
            background: rgba(255,255,255,0.2);
        }

        .modal-body {
            padding: 30px;
            overflow-y: auto;
            max-height: calc(100vh - 180px);
        }

        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }

        .detail-row {
            margin-bottom: 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 15px;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .detail-row:hover {
            background: #e9ecef;
            border-left-color: #667eea;
            transform: translateX(5px);
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #667eea;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-label i {
            font-size: 14px;
        }

        .detail-value {
            color: #2C3E50;
            font-size: 16px;
            font-weight: 500;
            word-wrap: break-word;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .header, .stats, .filter-buttons, .search-box, .bulk-actions, .logout-btn {
                display: none !important;
            }
            
            .action-btn {
                display: none !important;
            }
            
            .table-container {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
            
            .table-header {
                background: #667eea !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .table-header h2 {
                color: white !important;
            }
            
            th:first-child, td:first-child {
                display: none;
            }
            
            th:last-child, td:last-child {
                display: none;
            }
            
            thead {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .status-badge, .type-badge {
                border: 1px solid #333;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            /* Improve table layout for print */
            table {
                width: 100%;
                font-size: 11px;
                border-collapse: collapse;
            }
            
            th, td {
                padding: 8px 6px;
                border: 1px solid #ddd;
                vertical-align: top;
                word-wrap: break-word;
            }
            
            th {
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
            }
            
            /* Adjust column widths for better fit */
            th:nth-child(2), td:nth-child(2) { /* Type */
                width: 10%;
            }
            
            th:nth-child(3), td:nth-child(3) { /* Date */
                width: 12%;
            }
            
            th:nth-child(4), td:nth-child(4) { /* Name */
                width: 15%;
            }
            
            th:nth-child(5), td:nth-child(5) { /* Contact */
                width: 18%;
            }
            
            th:nth-child(6), td:nth-child(6) { /* Details */
                width: 30%;
            }
            
            th:nth-child(7), td:nth-child(7) { /* Status */
                width: 10%;
            }
            
            /* Make details more readable */
            td strong {
                display: inline;
                font-weight: bold;
            }
            
            td br {
                display: block;
                content: "";
                margin: 3px 0;
            }
            
            /* Page setup */
            @page {
                size: A4 landscape;
                margin: 1cm;
            }
            
            .container::before {
                content: "RAVI MODULAR CABINET - Admin Report";
                display: block;
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 15px;
                padding-bottom: 8px;
                border-bottom: 3px solid #667eea;
            }
            
            .container::after {
                content: "Printed on: " attr(data-print-date) " | Page " counter(page);
                display: block;
                text-align: right;
                font-size: 10px;
                margin-top: 15px;
                color: #666;
                page-break-after: avoid;
            }
            
            /* Print summary */
            .print-summary {
                display: block !important;
                margin-bottom: 15px;
                padding: 12px;
                background: #f8f9fa;
                border: 1px solid #ddd;
                border-radius: 6px;
                page-break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .print-summary h3 {
                margin: 0 0 10px 0;
                font-size: 14px;
            }
            
            .print-summary-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }
            
            .print-summary-item {
                text-align: center;
                padding: 8px;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            
            .print-summary-item strong {
                display: block;
                font-size: 18px;
                color: #667eea;
                margin-bottom: 4px;
            }
            
            .print-summary-item span {
                font-size: 11px;
                color: #666;
            }
            
            /* Prevent page breaks inside rows */
            tr {
                page-break-inside: avoid;
            }
            
            /* Ensure table header repeats on each page */
            thead {
                display: table-header-group;
            }
            
            tbody {
                display: table-row-group;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-wrapper {
                overflow-x: scroll;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container" data-print-date="">
        <!-- Print Summary (hidden on screen, visible on print) -->
        <div class="print-summary" style="display: none;">
            <h3>Summary Report</h3>
            <div class="print-summary-grid">
                <div class="print-summary-item">
                    <strong><?php echo $totalAll; ?></strong>
                    <span>Total Submissions</span>
                </div>
                <div class="print-summary-item">
                    <strong><?php echo $totalAppointments; ?></strong>
                    <span>Appointments</span>
                </div>
                <div class="print-summary-item">
                    <strong><?php echo $totalContacts; ?></strong>
                    <span>Contact Messages</span>
                </div>
                <div class="print-summary-item">
                    <strong><?php echo $pending; ?></strong>
                    <span>Pending</span>
                </div>
            </div>
        </div>

        <div class="header">
            <div class="header-left">
                <h1>
                    <i class="fas fa-calendar-check"></i>
                    Admin Dashboard
                </h1>
            </div>
            <div class="admin-info">
                <div class="admin-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <form method="POST" action="adminlogin.php" style="display: inline;">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card total">
                <i class="fas fa-clipboard-list"></i>
                <h3><?php echo $totalAll; ?></h3>
                <p>Total Submissions</p>
            </div>
            <div class="stat-card" style="border-top-color: #3498db;">
                <i class="fas fa-calendar-check" style="color: #3498db;"></i>
                <h3><?php echo $totalAppointments; ?></h3>
                <p>Appointments</p>
            </div>
            <div class="stat-card" style="border-top-color: #9b59b6;">
                <i class="fas fa-envelope" style="color: #9b59b6;"></i>
                <h3><?php echo $totalContacts; ?></h3>
                <p>Contact Messages</p>
            </div>
            <div class="stat-card pending">
                <i class="fas fa-clock"></i>
                <h3><?php echo $pending; ?></h3>
                <p>Pending</p>
            </div>
            <div class="stat-card completed">
                <i class="fas fa-check-circle"></i>
                <h3><?php echo $completed; ?></h3>
                <p>Completed</p>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h2>
                    <i class="fas fa-list"></i>
                    <?php 
                    if ($filterType === 'appointments') echo 'Appointment Requests';
                    elseif ($filterType === 'contacts') echo 'Contact Messages';
                    else echo 'All Submissions';
                    ?>
                </h2>
                <div class="table-controls">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="filter-buttons">
                        <a href="?type=all" class="filter-btn <?php echo $filterType === 'all' ? 'active' : ''; ?>">All</a>
                        <a href="?type=appointments" class="filter-btn <?php echo $filterType === 'appointments' ? 'active' : ''; ?>">Appointments</a>
                        <a href="?type=contacts" class="filter-btn <?php echo $filterType === 'contacts' ? 'active' : ''; ?>">Messages</a>
                        <button type="button" class="filter-btn" onclick="filterTable('pending', this)">Pending</button>
                        <button type="button" class="filter-btn" onclick="filterTable('completed', this)">Completed</button>
                        <button type="button" class="filter-btn" onclick="printReport()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="filter-btn" onclick="exportToCSV()">
                            <i class="fas fa-file-csv"></i> Export CSV
                        </button>
                    </div>
                </div>
            </div>

            <?php if (count($filteredItems) > 0): ?>
            <form method="POST" id="bulkForm">
                <div class="table-wrapper">
                    <table id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>Type</th>
                                <th>Date & Time</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filteredItems as $item): ?>
                            <?php if (is_array($item) && isset($item['table']) && isset($item['id'])): ?>
                            <tr data-status="<?php echo htmlspecialchars($item['status'] ?? 'pending'); ?>">
                                <td>
                                    <input type="checkbox" name="selected_items[]" value="<?php echo htmlspecialchars($item['table'] . ':' . $item['id']); ?>" class="row-checkbox" onchange="updateBulkActions()">
                                </td>
                                <td>
                                    <span class="type-badge type-<?php echo htmlspecialchars($item['table']); ?>">
                                        <?php echo isset($item['form_type']) && $item['form_type'] === 'Contact Form' ? 'Message' : 'Appointment'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($item['timestamp'] ?? 'N/A'); ?></td>
                                <td><strong><?php echo htmlspecialchars($item['name'] ?? 'N/A'); ?></strong></td>
                                <td>
                                    <?php if (isset($item['phone']) && !empty($item['phone'])): ?>
                                        <i class="fas fa-phone"></i> <?php echo htmlspecialchars($item['phone']); ?><br>
                                    <?php endif; ?>
                                    <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($item['email'] ?? 'N/A'); ?>
                                </td>
                                <td>
                                    <?php if (isset($item['form_type']) && $item['form_type'] === 'Contact Form'): ?>
                                        <strong>Subject:</strong> <?php echo htmlspecialchars($item['subject'] ?? 'N/A'); ?>
                                    <?php else: ?>
                                        <strong>Service:</strong> <?php echo htmlspecialchars(ucfirst($item['service'] ?? 'N/A')); ?><br>
                                        <strong>Location:</strong> <?php echo htmlspecialchars($item['address'] ?? 'Not provided'); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo htmlspecialchars($item['status'] ?? 'pending'); ?>">
                                        <?php echo htmlspecialchars(ucfirst($item['status'] ?? 'pending')); ?>
                                    </span>
                                </td>
                                <td class="no-print">
                                    <?php if (($item['status'] ?? 'pending') === 'pending'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($item['table']); ?>">
                                        <button type="submit" name="update_status" class="action-btn btn-complete" title="Mark as Completed">
                                            <i class="fas fa-check"></i> Complete
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <button type="button" class="action-btn btn-view" onclick="viewDetails(<?php echo htmlspecialchars(json_encode($item)); ?>)" title="View Details">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                        <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($item['table']); ?>">
                                        <button type="submit" name="delete_item" class="action-btn btn-delete" 
                                                onclick="return confirm('Are you sure you want to delete this item?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="bulk-actions" id="bulkActions">
                    <span id="selectedCount">0 selected</span>
                    <button type="submit" name="bulk_delete" class="bulk-delete-btn" onclick="return confirm('Are you sure you want to delete selected items?')">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </div>
            </form>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>No Data Yet</h3>
                <p>Submissions will appear here once customers submit forms.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal for viewing details -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-info-circle"></i> Appointment Details</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Details will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('appointmentsTable');
            const rows = table.getElementsByTagName('tr');
            let visibleCount = 0;

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const textValue = cell.textContent || cell.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                if (found || filter === '') {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }
            
            updateNoResultsMessage(visibleCount);
        }

        // Select all checkboxes
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateBulkActions();
        }

        // Update bulk actions visibility
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.row-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (checkboxes.length > 0) {
                bulkActions.classList.add('active');
                selectedCount.textContent = checkboxes.length + ' selected';
            } else {
                bulkActions.classList.remove('active');
            }
        }

        // View details in modal
        function viewDetails(item) {
            const modal = document.getElementById('detailsModal');
            const modalBody = document.getElementById('modalBody');
            const modalTitle = modal.querySelector('.modal-header h2');
            
            // Check if it's a contact message or appointment
            const isContact = item.form_type === 'Contact Form';
            
            // Update modal title
            modalTitle.innerHTML = isContact ? 
                '<i class="fas fa-envelope"></i> Contact Message Details' : 
                '<i class="fas fa-calendar-check"></i> Appointment Details';
            
            let html = `
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-hashtag"></i> ${isContact ? 'Message' : 'Appointment'} ID</div>
                    <div class="detail-value">${item.id || 'N/A'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-calendar-alt"></i> Date & Time</div>
                    <div class="detail-value">${item.timestamp || 'N/A'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-user"></i> Full Name</div>
                    <div class="detail-value">${item.name || 'N/A'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-envelope"></i> Email Address</div>
                    <div class="detail-value"><a href="mailto:${item.email}" style="color: #667eea; text-decoration: none;">${item.email || 'N/A'}</a></div>
                </div>
            `;
            
            // Add contact-specific fields
            if (isContact) {
                html += `
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-tag"></i> Subject</div>
                        <div class="detail-value">${item.subject || 'N/A'}</div>
                    </div>
                `;
            } else {
                // Add appointment-specific fields
                html += `
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-phone"></i> Phone Number</div>
                        <div class="detail-value"><a href="tel:${item.phone}" style="color: #667eea; text-decoration: none;">${item.phone || 'N/A'}</a></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-briefcase"></i> Service Type</div>
                        <div class="detail-value">${item.service ? item.service.charAt(0).toUpperCase() + item.service.slice(1) : 'N/A'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-map-marker-alt"></i> Location/Address</div>
                        <div class="detail-value">${item.address || 'Not provided'}</div>
                    </div>
                `;
            }
            
            // Add common fields
            html += `
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-comment-dots"></i> Message</div>
                    <div class="detail-value">${item.message || 'No message provided'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-info-circle"></i> Status</div>
                    <div class="detail-value">
                        <span class="status-badge status-${item.status || 'pending'}">
                            ${item.status ? item.status.charAt(0).toUpperCase() + item.status.slice(1) : 'Pending'}
                        </span>
                    </div>
                </div>
            `;
            
            modalBody.innerHTML = html;
            modal.style.display = 'block';
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
        }

        // Close modal
        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('detailsModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('detailsModal');
                if (modal.style.display === 'block') {
                    closeModal();
                }
            }
        });

        // Print report with custom formatting
        function printReport() {
            // Set print date
            const container = document.querySelector('.container');
            const now = new Date();
            const dateStr = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
            container.setAttribute('data-print-date', dateStr);
            
            // Show print instructions
            const printInstructions = confirm(
                'Print Tips:\n\n' +
                '1. Select "Save as PDF" as the printer\n' +
                '2. Choose "Landscape" orientation for best fit\n' +
                '3. Enable "Background graphics" for colors\n\n' +
                'Click OK to continue to print dialog'
            );
            
            if (printInstructions) {
                // Small delay to ensure styles are applied
                setTimeout(() => {
                    window.print();
                }, 100);
            }
        }

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('appointmentsTable');
            const rows = table.querySelectorAll('tr');
            let csv = [];
            
            // Get filter type for filename
            const filterType = '<?php echo $filterType; ?>';
            const filename = 'ravi_' + filterType + '_' + new Date().toISOString().split('T')[0] + '.csv';
            
            // Process each row
            rows.forEach((row, index) => {
                const cols = row.querySelectorAll('td, th');
                let rowData = [];
                
                cols.forEach((col, colIndex) => {
                    // Skip checkbox column (first) and actions column (last)
                    if (colIndex === 0 || colIndex === cols.length - 1) return;
                    
                    // Get text content and clean it
                    let text = col.textContent.trim();
                    text = text.replace(/\s+/g, ' '); // Replace multiple spaces with single space
                    text = text.replace(/"/g, '""'); // Escape quotes
                    
                    rowData.push('"' + text + '"');
                });
                
                if (rowData.length > 0) {
                    csv.push(rowData.join(','));
                }
            });
            
            // Create download link
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            
            if (navigator.msSaveBlob) { // IE 10+
                navigator.msSaveBlob(blob, filename);
            } else {
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Filter by status (improved)
        function filterTable(status, element) {
            const rows = document.querySelectorAll('#appointmentsTable tbody tr');
            const filterButtons = document.querySelectorAll('.filter-btn[onclick*="filterTable"]');
            
            // Remove active class from all filter buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            if (element) {
                element.classList.add('active');
            }
            
            // Show/hide rows
            let visibleCount = 0;
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    if (row.dataset.status === status) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
            
            // Show message if no results
            updateNoResultsMessage(visibleCount);
        }

        // Update no results message
        function updateNoResultsMessage(count) {
            let existingMsg = document.querySelector('.no-results-message');
            
            if (count === 0) {
                if (!existingMsg) {
                    const tbody = document.querySelector('#appointmentsTable tbody');
                    const tr = document.createElement('tr');
                    tr.className = 'no-results-message';
                    tr.innerHTML = '<td colspan="8" style="text-align: center; padding: 40px; color: #999;"><i class="fas fa-search" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>No results found</td>';
                    tbody.appendChild(tr);
                }
            } else {
                if (existingMsg) {
                    existingMsg.remove();
                }
            }
        }
    </script>
</body>
</html>
