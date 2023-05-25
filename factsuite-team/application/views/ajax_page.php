
<div class="box-body">
	
	<div class="table-responsive">
		<table class="table no-margin">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Candidate Name</th>
					<th>Contact</th>
					<th>Email</th>
					<th>DOB</th>
					<th>Created At</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php if( ! empty($products)) { ?>
			<?php foreach($products as $product){ ?>
				<tr>
					<td width="40px"><?php echo $product->candidate_id ?></a></td>
					<td><?php echo $product->first_name ?></td>
					<td><?php echo $product->phone_number  ?></td>
					<td><?php echo $product->email_id  ?></td>
					<td><?php echo $product->date_of_birth  ?></td>
					 
					<td><?php echo $product->created_date  ?></td>
					<td class="action">
						<?php echo anchor('', 'Edit', array('title' => 'Edit'))?>
					</td>
				</tr>
			<?php } ?>
			<?php } else { ?>
			<tr><td colspan="8" class="no-records">No records</td></tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="box-footer">
	<ul class="pagination">
		<?php echo $pagelinks ?>
	</ul>
</div>