<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $patient->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $patient->id), 'class' => 'dropdown-item', 'escapeTitle' => false]
            ) ?>
            <?= $this->Html->link(__('List Patients'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
				</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

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
				  <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning']); ?>
				  <?= $this->Form->button(__('Submit'),['type' => 'submit', 'class' => 'btn btn-outline-primary']) ?>
                </div>
        <?= $this->Form->end() ?>
    </div>
</div>