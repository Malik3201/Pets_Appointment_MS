<?php
// Compact Professional PDF Receipt Generator
// This script creates a compact, half-page professional receipt
// Usage: generate_receipt_compact($appointment_id, $saveToFile = true)

require_once __DIR__ . '/config.php';

function generate_receipt_compact($appointment_id, $saveToFile = true) {
    global $mysqli;
    $appointment_id = (int)$appointment_id;
    
    // Get appointment details with owner information
    $stmt = $mysqli->prepare('SELECT a.id, a.date, a.time, a.service, a.status, p.pet_name, p.type, p.age, o.owner_name, o.email, o.phone, o.address FROM appointments a JOIN pets p ON a.pet_id = p.id JOIN owners o ON p.owner_id = o.id WHERE a.id = ? LIMIT 1');
    $stmt->bind_param('i', $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    
    if (!$data) { 
        return false; 
    }
    
    // Generate HTML receipt
    $html = generate_receipt_html_compact($data);
    
    // Create receipts directory if it doesn't exist
    $receiptsDir = __DIR__ . '/receipts';
    if (!is_dir($receiptsDir)) { 
        mkdir($receiptsDir, 0777, true); 
    }
    
    $htmlFilePath = $receiptsDir . '/appointment_compact_' . $appointment_id . '.html';
    
    // Save HTML file
    file_put_contents($htmlFilePath, $html);
    
    if ($saveToFile) {
        return $htmlFilePath; // Return HTML file path for download
    } else {
        // Output HTML for direct viewing
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        return true;
    }
}

function generate_receipt_html_compact($data) {
    $receiptNumber = 'APT-' . str_pad($data['id'], 6, '0', STR_PAD_LEFT);
    $currentDate = date('M j, Y');
    $appointmentDate = date('M j, Y', strtotime($data['date']));
    $appointmentTime = date('g:i A', strtotime($data['time']));
    
    // Status styling
    $statusColor = '';
    $statusBg = '';
    switch($data['status']) {
        case 'Approved':
            $statusColor = '#ffffff';
            $statusBg = '#22c55e';
            break;
        case 'Pending':
            $statusColor = '#ffffff';
            $statusBg = '#f59e0b';
            break;
        case 'Cancelled':
            $statusColor = '#ffffff';
            $statusBg = '#ef4444';
            break;
        default:
            $statusColor = '#ffffff';
            $statusBg = '#6b7280';
    }
    
    $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Receipt - Pets Care</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Segoe UI", "Helvetica Neue", Arial, sans-serif;
            line-height: 1.4;
            color: #1a1a1a;
            background: white;
            padding: 15px;
            font-size: 12px;
        }
        
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border: 2px solid #e02222;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(224, 34, 34, 0.15);
        }
        
        .header {
            background: linear-gradient(135deg, #e02222 0%, #dc2626 100%);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.95;
            font-weight: 500;
        }
        
        .receipt-title {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 2px solid #e02222;
        }
        
        .receipt-title h2 {
            color: #e02222;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .content {
            padding: 20px;
            background: white;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-item {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 12px;
            border-left: 3px solid #e02222;
        }
        
        .info-label {
            font-weight: 700;
            color: #374151;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 13px;
            font-weight: 600;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: ' . $statusColor . ';
            background-color: ' . $statusBg . ';
        }
        
        .full-width {
            grid-column: 1 / -1;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-top: 2px solid #e02222;
            font-size: 11px;
            color: #6b7280;
        }
        
        .footer .brand {
            color: #e02222;
            font-weight: 700;
        }
        
        .contact-info {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        @media print {
            body {
                padding: 0;
                font-size: 11px;
            }
            
            .receipt-container {
                box-shadow: none;
                border: 2px solid #e02222;
                margin: 0;
                max-width: none;
            }
            
            .info-grid {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .receipt-title h2 {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>PETS CARE</h1>
            <p>Professional Veterinary Services</p>
        </div>
        
        <!-- Receipt Title -->
        <div class="receipt-title">
            <h2>Appointment Receipt</h2>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Receipt Number</span>
                    <span class="info-value">' . $receiptNumber . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date Issued</span>
                    <span class="info-value">' . $currentDate . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="status-badge">' . strtoupper($data['status']) . '</span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Appointment Date</span>
                    <span class="info-value">' . $appointmentDate . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Appointment Time</span>
                    <span class="info-value">' . $appointmentTime . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Service</span>
                    <span class="info-value">' . htmlspecialchars($data['service']) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pet Name</span>
                    <span class="info-value">' . htmlspecialchars($data['pet_name']) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Pet Type</span>
                    <span class="info-value">' . htmlspecialchars($data['type']) . ' (' . $data['age'] . ' years)</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Owner Name</span>
                    <span class="info-value">' . htmlspecialchars($data['owner_name']) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">' . htmlspecialchars($data['phone']) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">' . htmlspecialchars($data['email']) . '</span>
                </div>
                <div class="info-item full-width">
                    <span class="info-label">Address</span>
                    <span class="info-value">' . htmlspecialchars($data['address']) . '</span>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing <span class="brand">Pets Care</span></p>
            <div class="contact-info">
                <p>📧 info@petscare.com | 📞 (555) 123-4567 | 🌐 www.petscare.com</p>
                <p>© 2025 Pets Care. All Rights Reserved.</p>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads
        window.onload = function() {
            // Auto-trigger print dialog after 1 second
            setTimeout(() => {
                window.print();
            }, 1000);
        };
        
        // Listen for Ctrl+P keyboard shortcut
        document.addEventListener("keydown", function(event) {
            if (event.ctrlKey && event.key === "p") {
                event.preventDefault();
                window.print();
            }
        });
        
        // Add print functionality
        function printReceipt() {
            window.print();
        }
        
        // Add keyboard shortcuts info
        console.log("Receipt loaded. Press Ctrl+P to print or wait for auto-print.");
    </script>
</body>
</html>';
    
    return $html;
}

// Only run this code if the script is accessed directly via URL
if (basename($_SERVER['PHP_SELF']) === 'generate_receipt_compact.php') {
    // Get appointment ID from URL parameter
    $appointment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if (!$appointment_id) {
        die('Invalid appointment ID');
    }

    // Generate and output the receipt
    generate_receipt_compact($appointment_id, false);
}
?>
