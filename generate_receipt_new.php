<?php
// Professional PDF Receipt Generator using HTML to PDF conversion
// Usage: generate_receipt_pdf_new($appointment_id, $saveToFile = true)

require_once __DIR__ . '/config.php';

function generate_receipt_pdf_new($appointment_id, $saveToFile = true) {
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
    $html = generate_receipt_html($data);
    
    // For now, we'll save as HTML file and use browser's print to PDF
    // In production, you can integrate with libraries like wkhtmltopdf or TCPDF with HTML support
    $receiptsDir = __DIR__ . '/receipts';
    if (!is_dir($receiptsDir)) { 
        mkdir($receiptsDir, 0777, true); 
    }
    
    $htmlFilePath = $receiptsDir . '/appointment_' . $appointment_id . '.html';
    $pdfFilePath = $receiptsDir . '/appointment_' . $appointment_id . '.pdf';
    
    // Save HTML file
    file_put_contents($htmlFilePath, $html);
    
    // For immediate PDF generation, we'll use a simple approach
    // In production, integrate with proper PDF library
    if ($saveToFile) {
        // Create a simple PDF using browser's print functionality
        // This is a temporary solution - in production use proper PDF library
        return $htmlFilePath; // Return HTML file path for now
    } else {
        // Output HTML for direct viewing/printing
        header('Content-Type: text/html');
        echo $html;
        return true;
    }
}

function generate_receipt_html($data) {
    $receiptNumber = 'APT-' . str_pad($data['id'], 6, '0', STR_PAD_LEFT);
    $currentDate = date('M j, Y');
    $appointmentDate = date('M j, Y', strtotime($data['date']));
    $appointmentTime = date('g:i A', strtotime($data['time']));
    
    // Status color
    $statusColor = '';
    switch($data['status']) {
        case 'Approved':
            $statusColor = '#22c55e'; // Green
            break;
        case 'Pending':
            $statusColor = '#f59e0b'; // Yellow
            break;
        case 'Cancelled':
            $statusColor = '#ef4444'; // Red
            break;
        default:
            $statusColor = '#6b7280'; // Gray
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
            font-family: "Helvetica", "Arial", sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background: white;
            padding: 20px;
        }
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #e02222 0%, #dc2626 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 500;
        }
        
        .receipt-title {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #e02222;
        }
        
        .receipt-title h2 {
            color: #e02222;
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .content {
            padding: 30px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            color: #e02222;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e02222;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-weight: 700;
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 12px;
            background: #f9fafb;
            border-radius: 4px;
            border-left: 3px solid #e02222;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
            background-color: ' . $statusColor . ';
        }
        
        .footer {
            background: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .footer .brand {
            color: #e02222;
            font-weight: 700;
            font-size: 16px;
        }
        
        .contact-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
        
        .contact-info p {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 4px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .receipt-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>PETS CARE</h1>
            <p>Professional Veterinary Care</p>
        </div>
        
        <!-- Receipt Title -->
        <div class="receipt-title">
            <h2>Appointment Receipt</h2>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Appointment Details -->
            <div class="section">
                <h3 class="section-title">Appointment Details</h3>
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
                        <span class="info-label">Service Date</span>
                        <span class="info-value">' . $appointmentDate . '</span>
                    </div>
                </div>
            </div>
            
            <!-- Pet Information -->
            <div class="section">
                <h3 class="section-title">Pet Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Pet Name</span>
                        <span class="info-value">' . htmlspecialchars($data['pet_name']) . '</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Type</span>
                        <span class="info-value">' . htmlspecialchars($data['type']) . '</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Age</span>
                        <span class="info-value">' . $data['age'] . ' years</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Service</span>
                        <span class="info-value">' . htmlspecialchars($data['service']) . '</span>
                    </div>
                </div>
            </div>
            
            <!-- Owner Information -->
            <div class="section">
                <h3 class="section-title">Owner Information</h3>
                <div class="info-grid">
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
                    <div class="info-item">
                        <span class="info-label">Appointment Time</span>
                        <span class="info-value">' . $appointmentTime . '</span>
                    </div>
                </div>
                <div class="info-item" style="margin-top: 15px;">
                    <span class="info-label">Address</span>
                    <span class="info-value">' . htmlspecialchars($data['address']) . '</span>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Thank you for choosing <span class="brand">Pets Care</span> for your veterinary needs.</p>
            <p>For any questions or concerns, please contact us.</p>
            <p>This receipt is valid for approved appointments only.</p>
            
            <div class="contact-info">
                <p><strong>Pets Care - Professional Veterinary Services</strong></p>
                <p>Email: info@petscare.com | Phone: (555) 123-4567</p>
                <p>© 2025 Pets Care. All Rights Reserved.</p>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads (optional)
        window.onload = function() {
            // Uncomment the next line to auto-print
            // window.print();
        };
    </script>
</body>
</html>';
    
    return $html;
}

// If called directly with ?id=, stream the HTML for testing
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    generate_receipt_pdf_new($id, false);
    exit;
}
?>
