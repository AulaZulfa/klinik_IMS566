<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */
?>
<div class="row text-body-secondary">
    <div class="col-10">
        <h1 class="my-0 page_title"><?php echo $title; ?></h1>
        <h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
    </div>
    <div class="col-2 text-end mt-3">
        <?= $this->Html->link(__('<i class="fa-regular fa-pen-to-square"></i> Edit Profile'), ['action' => 'edit', $patient->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
	  <div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
        <div class="card-body">
            <div class="card-title">Disclaimer</div>
            <div class="tricolor_line mb-3"></div>
            All information is belongs to the system.
        </div>
      </div>
	</div>

	<div class="col-md-9">
		<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
			<div class="card-body text-body-secondary">
           
    <div class="table-responsive">
        <table class="table">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($patient->name) ?></td>
                </tr>
                 <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($patient->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Street 1') ?></th>
                    <td><?= h($patient->street_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Street 2') ?></th>
                    <td><?= h($patient->street_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($patient->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('State') ?></th>
                    <td><?= h($patient->state) ?></td>
                </tr>
                <tr>
                    <th><?= __('IC') ?></th>
                    <td><?= h($patient->ic) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($patient->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Postcode') ?></th>
                    <td><?= h($patient->postcode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td>
						<?php 
						if ($patient->status == 0){
							echo '<span class="badge text-bg-secondary">Inactive</span>';
						}elseif ($patient->status == 1){
							echo '<span class="badge text-bg-success">Active</span>';
						}else
							echo '<span class="badge text-bg-danger">Error</span>';
						?>
					</td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($patient->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($patient->modified) ?></td>
                </tr>
            </table>
            </div>

			</div>
		</div>