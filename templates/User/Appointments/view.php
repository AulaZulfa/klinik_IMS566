<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Appointment $appointment
 */
use Cake\Routing\Router; // WAJIB ADA baris ni
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Appointment Details</h2>
        <p class="text-muted small">Reference ID: #<?= str_pad($appointment->id, 5, '0', STR_PAD_LEFT) ?></p>
    </div>
    <?= $this->Html->link(__('<i class="bi bi-arrow-left me-1"></i> Back'), ['action' => 'index'], ['class' => 'btn btn-outline-light btn-sm px-3', 'escapeTitle' => false]) ?>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
            <div class="card-header bg-dark border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-uppercase small fw-bold text-secondary">General Information</span>
                    <?php 
                        $statusClass = 'bg-warning text-dark';
                        if ($appointment->status == 1) $statusClass = 'bg-success';
                        if ($appointment->status == 2) $statusClass = 'bg-danger';
                    ?>
                    <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2 shadow-sm">
                        <?= $appointment->status == 1 ? 'Approved' : ($appointment->status == 2 ? 'Rejected' : 'Pending') ?>
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row mb-4 mt-2">
                    <div class="col-md-6 border-end border-secondary border-opacity-25">
                        <label class="text-muted small text-uppercase mb-2 d-block">Consulting Doctor</label>
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold text-info"><?= h($appointment->doctor->name) ?></h5>
                                <small class="text-muted">Specialist Practitioner</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <label class="text-muted small text-uppercase mb-2 d-block">Schedule</label>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-0 small text-muted">Date</p>
                                <p class="fw-bold mb-0"><i class="bi bi-calendar3 text-primary me-2"></i><?= $appointment->date->format('d M Y') ?></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-0 small text-muted">Time</p>
                                <p class="fw-bold mb-0"><i class="bi bi-clock text-primary me-2"></i><?= $appointment->start_time->format('h:i A') ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-25">

                <div class="mb-4">
                    <label class="text-muted small text-uppercase mb-3 d-block">Purpose of Visit</label>
                    <div class="p-3 rounded border border-secondary border-opacity-25" style="background: rgba(255,255,255,0.03);">
                        <p class="mb-0 text-light"><?= h($appointment->purpose ?: 'No specific notes provided.') ?></p>
                    </div>
                </div>

                <div class="d-grid gap-2">
                   <?= $this->Html->link(__('<i class="bi bi-file-earmark-pdf-fill me-2"></i> Download Official Appointment Letter'), 
                    [
                        'action' => 'pdf', 
                        $appointment->id, 
                        '_ext' => 'pdf'
                    ], 
                    ['class' => 'btn btn-danger py-3 fw-bold shadow', 'escapeTitle' => false, 'target' => '_blank']) 
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; background: #1a1a1a;">
        <div class="card-body p-4 text-center">
            <label class="text-info small text-uppercase fw-bold mb-3 d-block">Digital Validation</label>
            
            <div class="bg-white p-3 d-inline-block rounded-3 mb-3 shadow">
                <div id="qrcode"></div> </div>
            
            <p class="small text-light opacity-75 mb-0">Scan this code to download your official appointment letter directly to your phone.</p>
        </div>
    </div>
    
  

<script>
    // Link direct ke PDF
    var qrLink = "<?= Router::url(['action' => 'pdf', $appointment->id, '_ext' => 'pdf'], true) ?>";

    // Kita tunggu page siap load baru lukis QR
    window.onload = function() {
        new QRCode(document.getElementById("qrcode"), {
            text: qrLink,
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    };
</script>
                
                <p class="small text-light opacity-75 mb-0">Scan this code to verify your appointment status at the clinic counter.</p>
            </div>
        </div>

        <div class="card border-0 bg-info bg-opacity-10" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-info-circle fs-4 text-info me-2"></i>
                    <h6 class="fw-bold mb-0 text-info">Important Notice</h6>
                </div>
                <ul class="small text-muted ps-3 mb-0">
                    <li class="mb-2">Please arrive 15 minutes early.</li>
                    <li class="mb-2">Bring your original Identification Card (IC).</li>
                    <li>Fast for 8 hours if blood test is required.</li>
                </ul>
            </div>
        </div>
    </div>
</div>