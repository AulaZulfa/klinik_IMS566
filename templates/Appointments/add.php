<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Appointment $appointment
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title"><?php echo $title; ?></h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
            <?= $this->Html->link(__('List Appointments'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
				</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<!-- Form Section -->

<div class="row mb-3">
    <div class="col-md-3">
        <div class="card bg-body-tertiary border-0 rounded-0">
            <div class="card-body">
                <div class="card-title">Instructions</div>
                <div class="tricolor_line mb-3"></div>
                Please fill all the required input.
            </div>
        </div>
    </div>
    <div class="col-md-9">
<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
    <div class="card-body text-body-secondary">
            <?= $this->Form->create($appointment) ?>
            <fieldset>
                
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('patient_id', ['options' => $patients, 'class'=> 'form-control form-select',
                        'empty' => 'Select Patient']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('doctor_id', ['options' => $doctors, 'class'=> 'form-control form-select',
                        'empty' => 'Select Doctor']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('date'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('start_time'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('end_time'); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('status', [
                            'options' => [
                                0 => 'Rejected',
                                1 => 'Approved',
                            ],
                            'empty' => 'Select Status',
                            'class' => 'form-control form-select'
                        ]); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('purpose',['type'=>'textarea', 'class'=>'form-control']); ?>
                    </div>
                    
                </div>
               
            </fieldset>
				<div class="text-end">
				  <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
				  <?= $this->Form->button(__('Submit'),['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
                </div>
        <?= $this->Form->end() ?>
    </div>
</div>