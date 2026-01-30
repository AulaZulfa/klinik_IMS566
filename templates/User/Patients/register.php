<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Register New Profile</h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">Please complete your details to facilitate appointment arrangements.</p>
                <?= $this->Form->create($patient) ?>
                <fieldset>
                    <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->control('name',['label'=>'Fullname']); ?>
                    </div>
                    <div class="col-md-6">
                         <?php echo $this->Form->control('email', ['placeholder'=>'username@gmail.com']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('ic', ['placeholder'=>'990102101111']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->control('phone',['placeholder'=>'0123456789']); ?>
                    </div>
                </div>

                 <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('street_1'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('street_2'); ?>
                        </div>
                    </div>
                    
                    <div class="row">
                <div class="col-md-4">
                    <?php echo $this->Form->control('postcode'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->Form->control('city'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $this->Form->control('state',[
                        'options' => [
                            'Kedah' => 'Kedah',
                            'Pahang' => 'Pahang',
                            'Perlis' => 'Perlis',
                            'Pulau Pinang' => 'Pulau Pinang',
                            'Perak' => 'Perak',
                            'Selangor' => 'Selangor',
                            'Negeri Sembilan' => 'Negeri Sembilan',
                            'Melaka' => 'Melaka',
                            'Johor' => 'Johor',
                            'Terengganu' => 'Terengganu',
                            'Kelantan' => 'Kelantan',
                            'Sabah' => 'Sabah',
                            'Sarawak' => 'Sarawak',
                            'Wilayah Persekutuan Kuala Lumpur' => 'Wilayah Persekutuan Kuala Lumpur',
                            'Wilayah Persekutuan Putrajaya' => 'Wilayah Persekutuan Putrajaya',
                            'Wilayah Persekutuan Labuan' => 'Wilayah Persekutuan Labuan',
                        ],
                        'class'=> 'form-control form-select',
                        'empty' => 'Select State'
                    ]); ?>
            </div>
            <div class="com-md-6">
						<?php echo $this->Form->control('status',[
								'options'=>[
									1 => 'Active',
									0 => 'Inactive',
								],
								'empty' => 'Select Status',
								'class' => 'form-control form-select'
							]); ?>
					</div>
                    </div>
                </fieldset>
                <div class="text-end">
                    <?= $this->Form->button(__('Register Now'), ['class' => 'btn btn-success']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>