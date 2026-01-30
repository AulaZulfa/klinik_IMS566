<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Appointment> $appointments
 */
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h1 class="my-0 page_title"><?= h($title) ?></h1>
        <h6 class="text-muted"><?= h($system_name) ?></h6>
    </div>
</div>

<div class="line mb-4"></div>

<div class="card bg-body-tertiary border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th>Doctor</th>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($appointments->isEmpty()): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No appointments found.</td>
                        </tr>
                    <?php else: ?>
                        <?php $counter = 1; foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td>
                                <div class="fw-bold text-primary"><?= $appointment->hasValue('doctor') ? h($appointment->doctor->name) : '-' ?></div>
                                <small class="text-muted">Specialist</small>
                            </td>
                            <td><?= $appointment->date?->format('d/m/Y') ?></td>
                            <td><?= $appointment->start_time?->format('h:i A') ?></td>
                            <td><?= h($appointment->purpose) ?></td>
                            <td class="text-center">
                                <?php if ($appointment->status == 1): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php elseif ($appointment->status == 2): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <?= $this->Html->link(__('<i class="bi bi-eye"></i>'), ['action' => 'view', $appointment->id], ['class' => 'btn btn-sm btn-outline-primary', 'escapeTitle' => false, 'title' => 'View Details']) ?>
                                    
                                    <?= $this->Html->link(__('<i class="bi bi-filetype-pdf"></i>'), ['action' => 'pdf', $appointment->id, '_ext' => 'pdf'], ['class' => 'btn btn-sm btn-outline-danger', 'escapeTitle' => false, 'target' => '_blank', 'title' => 'Download Letter']) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                <?= $this->Paginator->counter('Showing {{current}} of {{count}} records') ?>
            </small>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <?= $this->Paginator->prev('<') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('>') ?>
                </ul>
            </nav>
        </div>
    </div>
</div>