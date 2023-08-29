<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">

	<?php $this->load->view("admin/_partials/navbar.php") ?>
	<div id="wrapper">

		<?php $this->load->view("admin/_partials/sidebar.php") ?>

		<div id="content-wrapper">

			<div class="container-fluid">

				<?php $this->load->view("admin/_partials/breadcrumb.php") ?>

				<div class="card mb-3">
					<div class="card-header">
						<a href="<?php echo site_url('dashboard/adduser') ?>"><i class="fas fa-plus"></i> Add New</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>ID User</th>
										<th>Password</th>
										<th>Nama User</th>
										<th>Role</th>
										<th style="text-align:center;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($users as $user): ?>
									<tr>
										<td><?= $user->id_user ?></td>
										<td><?= $user->password ?></td>
										<td><?= $user->nama_user ?></td>
										<td><?= $user->role ?></td>
										<td width="250" style="text-align:center;">
											<a  href="<?php echo base_url('dashboard/edit/'.$user->id_user) ?>" id="edituser" iduser="<?= $user->id_user ?>" class="btn btn-small"><i class="fas fa-edit"></i> </a>
											<a id="deleteuser" iduser="<?= $user->id_user ?>" class="btn btn-small text-danger"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

			<?php $this->load->view("admin/_partials/footer.php") ?>

		</div>

	</div>

	<?php $this->load->view("admin/_partials/scrolltop.php") ?>
	<?php $this->load->view("admin/_partials/modal.php") ?>

	<?php $this->load->view("admin/_partials/js.php") ?>

	<script>
		$(document).ready(function(){
			$('td #deleteuser').click(function(){
				var iduser = $(this).attr('iduser');
				Swal.fire({
					title: "Anda yakin ingin menghapus user ini?",
					text: "Jika sudah dihapus, data tidak akan bisa dikembalikan",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete)=>{
					if(willDelete){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('dashboard/deleteuser') ?>",
							data: "iduser="+iduser,
							success: function(data){
								if(data == 0){
									Swal.fire({
										icon: 'error',
										title: 'Data Gagal Dihapus!',
										text: 'Data Tidak Bisa Dihapus',
										timer: 2000,
									});
								}else{
									Swal.fire({
										icon: 'success',
										title: 'Data Berhasil Dihapus!',
										text: 'Data SUdah Dihapus',
										timer: 2000,
										showConfirmButton: false 
									})
									.then((value) => {
									  document.location.href = '<?php echo base_url('dashboard/users') ?>';
									});
								}
							}
						});
					}else{
						Swal.fire({
							icon: 'warning',
							title: 'Anda Memilih Tidak Menghapus!',
							text: 'Tidak Jadi Menghapus',
							timer: 2000,
							showConfirmButton: false 
						});
					}
				});
			});
		});
	</script>
</body>

</html>
