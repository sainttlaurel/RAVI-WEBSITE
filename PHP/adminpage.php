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

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['appointment_id'];
    $db->update('appointments', $id, ['status' => 'completed']);
    header('Location: adminpage.php');
    exit;
}

// Handle delete
if (isset($_POST['delete_appointment'])) {
    $id = $_POST['appointment_id'];
    $db->delete('appointments', $id);
    header('Location: adminpage.php');
    exit;
}

// Handle bulk delete
if (isset($_POST['bulk_delete'])) {
    $ids = $_POST['selected_ids'] ?? [];
    foreach ($ids as $id) {
        $db->delete('appointments', $id);
    }
    header('Location: adminpage.php');
    exit;
}

// Retrieve appointments
$data = $db->retrieve('appointments');
$appointments = json_decode($data, true);

// Ensure appointments is an array and filter out invalid entries
if (!is_array($appointments)) {
    $appointments = [];
} else {
    // Filter out non-array entries (strings, nulls, etc.)
    $appointments = array_filter($appointments, function($item) {
        return is_array($item);
    });
}

// Calculate statistics
$total = count($appointments);
$pending = 0;
$completed = 0;

foreach ($appointments as $appointment) {
    if (is_array($appointment) && isset($appointment['status'])) {
        if ($appointment['status'] === 'pending') {
            $pending++;
        } elseif ($appointment['status'] === 'completed') {
            $completed++;
        }
    }
}

// Sort appointments by timestamp (newest first)
uasort($appointments, function($a, $b) {
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
            .header, .stats, .filter-buttons, .action-btn, .logout-btn, .bulk-actions, .search-box {
                display: none !important;
            }
            .table-container {
                box-shadow: none;
            }
            th:first-child, td:first-child {
                display: none;
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
    <div class="container">
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
                <h3><?php echo $total; ?></h3>
                <p>Total Appointments</p>
            </div>
            <div class="stat-card pending">
                <i class="fas fa-clock"></i>
                <h3><?php echo $pending; ?></h3>
                <p>Pending Requests</p>
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
                    Appointment Requests
                </h2>
                <div class="table-controls">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Search appointments..." onkeyup="searchTable()">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="filter-buttons">
                        <button type="button" class="filter-btn active" onclick="filterTable('all', this)">All</button>
                        <button type="button" class="filter-btn" onclick="filterTable('pending', this)">Pending</button>
                        <button type="button" class="filter-btn" onclick="filterTable('completed', this)">Completed</button>
                        <button type="button" class="filter-btn" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <?php if (count($appointments) > 0): ?>
            <form method="POST" id="bulkForm">
                <div class="table-wrapper">
                    <table id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>Date & Time</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $id => $appointment): ?>
                            <?php if (is_array($appointment)): ?>
                            <tr data-status="<?php echo htmlspecialchars($appointment['status'] ?? 'pending'); ?>">
                                <td>
                                    <input type="checkbox" name="selected_ids[]" value="<?php echo htmlspecialchars($id); ?>" class="row-checkbox" onchange="updateBulkActions()">
                                </td>
                                <td><?php echo htmlspecialchars($appointment['timestamp'] ?? 'N/A'); ?></td>
                                <td><strong><?php echo htmlspecialchars($appointment['name'] ?? 'N/A'); ?></strong></td>
                                <td><?php echo htmlspecialchars($appointment['phone'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($appointment['email'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($appointment['service'] ?? 'N/A')); ?></td>
                                <td><?php echo htmlspecialchars($appointment['address'] ?? 'Not provided'); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo htmlspecialchars($appointment['status'] ?? 'pending'); ?>">
                                        <?php echo htmlspecialchars(ucfirst($appointment['status'] ?? 'pending')); ?>
                                    </span>
                                </td>
                                <td class="no-print">
                                    <?php if (($appointment['status'] ?? 'pending') === 'pending'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($id); ?>">
                                        <button type="submit" name="update_status" class="action-btn btn-complete" title="Mark as Completed">
                                            <i class="fas fa-check"></i> Complete
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <button type="button" class="action-btn btn-view" onclick="viewDetails(<?php echo htmlspecialchars(json_encode($appointment)); ?>, '<?php echo htmlspecialchars($id); ?>')" title="View Details">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($id); ?>">
                                        <button type="submit" name="delete_appointment" class="action-btn btn-delete" 
                                                onclick="return confirm('Are you sure you want to delete this appointment?')" title="Delete">
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
                    <button type="submit" name="bulk_delete" class="bulk-delete-btn" onclick="return confirm('Are you sure you want to delete selected appointments?')">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                </div>
            </form>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>No Appointments Yet</h3>
                <p>Appointment requests will appear here once customers submit the form.</p>
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
        // Filter table by status
        function filterTable(status, element) {
            const rows = document.querySelectorAll('#appointmentsTable tbody tr');
            const buttons = document.querySelectorAll('.filter-btn:not([onclick*="print"])');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            if (element) {
                element.classList.add('active');
            }
            
            rows.forEach(row => {
                if (status === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = row.dataset.status === status ? '' : 'none';
                }
            });
        }

        // Search functionality
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('appointmentsTable');
            const rows = table.getElementsByTagName('tr');

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

                row.style.display = found ? '' : 'none';
            }
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
        function viewDetails(appointment, id) {
            const modal = document.getElementById('detailsModal');
            const modalBody = document.getElementById('modalBody');
            
            const html = `
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-hashtag"></i> Appointment ID</div>
                    <div class="detail-value">${id}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-calendar-alt"></i> Date & Time</div>
                    <div class="detail-value">${appointment.timestamp || 'N/A'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-user"></i> Full Name</div>
                    <div class="detail-value">${appointment.name || 'N/A'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-phone"></i> Phone Number</div>
                    <div class="detail-value"><a href="tel:${appointment.phone}" style="color: #667eea; text-decoration: none;">${appointment.phone || 'N/A'}</a></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-envelope"></i> Email Address</div>
                    <div class="detail-value"><a href="mailto:${appointment.email}" style="color: #667eea; text-decoration: none;">${appointment.email || 'N/A'}</a></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-briefcase"></i> Service Type</div>
                    <div class="detail-value">${appointment.service ? appointment.service.charAt(0).toUpperCase() + appointment.service.slice(1) : 'N/A'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-map-marker-alt"></i> Location/Address</div>
                    <div class="detail-value">${appointment.address || 'Not provided'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-comment-dots"></i> Message</div>
                    <div class="detail-value">${appointment.message || 'No message provided'}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label"><i class="fas fa-info-circle"></i> Status</div>
                    <div class="detail-value">
                        <span class="status-badge status-${appointment.status || 'pending'}">
                            ${appointment.status ? appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1) : 'Pending'}
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
    </script>
</body>
</html>
