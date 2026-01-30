<?php
use Cake\Routing\Router;

/**
 * Helper function untuk menukar imej kepada Base64.
 */
if (!function_exists('getBase64Image')) {
    function getBase64Image($imageName) {
        $path = WWW_ROOT . 'img' . DS . $imageName;
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = @file_get_contents($path);
            if ($data) {
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }
        return '';
    }
}

// 1. Ambil Header Klinik
$headerBase64 = getBase64Image('letter header.png');

// 2. Logik QR Code Dinamik (Link direct ke PDF)
$qrLink = Router::url([
    'controller' => 'Appointments', 
    'action' => 'pdf', 
    $appointment->id, 
    '_ext' => 'pdf'
], true);

// Gunakan API Google untuk janana gambar QR
$googleChartApi = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode($qrLink) . "&choe=UTF-8";

$qrCodeBase64 = '';
// Ambil data gambar dari Google
$apiData = @file_get_contents($googleChartApi);

if ($apiData) {
    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($apiData);
} else {
    // JIKA GOOGLE API GAGAL (Tiada internet), kita cuba guna fail statik qrcode.png jika ada
    $qrCodeBase64 = getBase64Image('qrcode.png');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Letter - <?= h($appointment->id) ?></title>
    <style>
        @page { margin: 0.5cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 13px;
        }
        .content { width: 85%; margin: 0 auto; }
        .header-container { text-align: center; margin-bottom: 5px; }
        .header-img { width: 100%; max-height: 180px; object-fit: contain; }
        .divider { border: 0; border-top: 2px solid #333; margin: 10px 0; }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0;
        }
        .patient-info { margin-bottom: 25px; line-height: 1.3; }
        .appointment-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .footer-table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        .signature-cell { width: 70%; vertical-align: bottom; }
        .qr-cell {
            width: 30%;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #eee;
            padding: 10px;
            background: #fff;
        }
        .disclaimer {
            font-size: 10px;
            font-style: italic;
            color: #777;
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header-container">
    <?php if ($headerBase64): ?>
        <img src="<?= $headerBase64 ?>" class="header-img">
    <?php endif; ?>
</div>

<div class="content">
    <hr class="divider">

    <div style="text-align:right; margin-bottom: 20px;">
        <strong>Date Issued:</strong> <?= date('d F Y'); ?>
    </div>

    <div class="patient-info">
        <span style="font-size: 14px; font-weight: bold; text-transform: uppercase;">
            <?= h($appointment->patient->name); ?>
        </span><br/>
        <?= h($appointment->patient->street_1); ?><br/>
        <?php if (!empty($appointment->patient->street_2)) echo h($appointment->patient->street_2) . '<br/>'; ?>
        <?= h($appointment->patient->postcode); ?> <?= h($appointment->patient->city); ?>,<br/>
        <?= h($appointment->patient->state); ?>
    </div>

    <div class="title">MEDICAL APPOINTMENT CONFIRMATION</div>

    <div style="text-align: justify;">
        Dear Valued Patient,<br/><br/>
        We are pleased to confirm your upcoming medical appointment at <strong>AWARIQNA Clinic</strong>. Details are as follows:
    </div>

    <div class="appointment-box">
        <table style="width: 100%;">
            <tr>
                <td style="width: 35%; font-weight: bold; padding: 5px 0;">Appointment ID</td>
                <td>: #<?= str_pad($appointment->id, 5, '0', STR_PAD_LEFT) ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 5px 0;">Appointment Date</td>
                <td>: <?= $appointment->date->format('l, d F Y'); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 5px 0;">Reporting Time</td>
                <td>: <?= $appointment->start_time->format('h:i A'); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 5px 0;">Consulting Doctor</td>
                <td>: <?= h($appointment->doctor->name); ?></td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 5px 0;">Purpose of Visit</td>
                <td>: <?= h($appointment->purpose ?: 'General Consultation'); ?></td>
            </tr>
        </table>
    </div>

    <table class="footer-table">
        <tr>
            <td class="signature-cell">
                Sincerely,<br><br><br><br>
                <strong>AWARIQNA CLINIC MANAGEMENT</strong><br>
                <small>Digital Validation System</small>
            </td>
            <td class="qr-cell">
                <?php if ($qrCodeBase64): ?>
                    <img src="<?= $qrCodeBase64 ?>" style="width: 100px; height: 100px;">
                    <br>
                    <span style="font-size: 8px; font-weight: bold; color: #333;">SCAN TO VERIFY</span>
                <?php else: ?>
                    <div style="font-size: 8px; color: #ccc;">[QR OFFLINE]</div>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="disclaimer">
        This document is automatically generated by the AWARIQNA Medical Management System. 
        It is a valid electronic confirmation and does not require a physical signature.
    </div>
</div>

</body>
</html>