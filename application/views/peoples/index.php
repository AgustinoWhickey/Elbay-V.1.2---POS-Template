<div class="container mt-3">
	<h3>Daftar Peoples</h3>

	<div class="row">
		<div class="col-md-5">
			<form action="<?= base_url('peoples'); ?>" method="post">
				<div class="input-group mb-3">
					<input type="text" class="form-control" name="keyword" placeholder="Search Keyword" autocomplete="off" autofocus>
					<div class="input-group-append">
						<input class="btn btn-primary" type="submit" name="submit" id="button-addon2">
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h5>Results: <?= $total_rows; ?></h5>
			<table class="table">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php if(empty($people)){ ?>
						<tr>
							<td colspan="4">
								<div class="alert alert-danger" role="alert">
									Data not found!
								</div>
							</td>
						</tr>
					<?php } ?>
					<?php foreach($people as $pep){ ?>
						<tr>
							<td><?= ++$start; ?></td>
							<td><?= $pep['name']; ?></td>
							<td><?= $pep['address']; ?></td>
							<td><?= $pep['email']; ?></td>
							<td>
								<a href="#" class="badge badge-warning">Detail</a>
								<a href="#" class="badge badge-success">Edit</a>
								<a href="#" class="badge badge-danger">Delete</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?= $this->pagination->create_links(); ?>
		</div>
	</div>
</div>