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

				<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php endif; ?>

				<!-- Card  -->
				<div class="card mb-3">
					<div class="card-header">

						<a href="<?php echo site_url('dashboard/users') ?>"><i class="fas fa-arrow-left"></i> Back</a>
					</div>
					<div class="card-body">

						<input type="hidden" id="iduser" name="id" value="<?= $user[0]['id_user'] ?>" />

						<div class="form-group">
							<label for="name">Username</label>
							<input class="form-control" type="text" name="name" id="nameuser" placeholder="Product name" value="<?= $user[0]['nama_user'] ?>" />
						</div>

						<div class="form-group">
							<label for="role">Role</label>
							<select class="form-control" id="rolename" name="role">
								<?php 
									if($user[0]['role']=='Admin'){
								?>
									<option value="Admin" selected>Admin</option>
									<option value="Penyewa">Penyewa</option>
								<?php 
									} else {
								?>
									<option value="Admin">Admin</option>
									<option value="Penyewa" selected>Penyewa</option>
								<?php } ?>
							</select>
						</div>

						<input class="btn btn-success" type="button" id="updateuser" name="btn" value="Update" />

					</div>

					<div class="card-footer small text-muted">
						
					</div>


				</div>
				
				<?php $this->load->view("admin/_partials/footer.php") ?>

			</div>

		</div>
		<!-- /#wrapper -->

		<?php $this->load->view("admin/_partials/scrolltop.php") ?>

		<?php $this->load->view("admin/_partials/js.php") ?>
		
		<script>
			$(document).ready(function(){
				$('#updateuser').click(function(){
					var iduser = $('#iduser').val();
					var nameuser = $('#nameuser').val();
					var rolename = $('#rolename').val();
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/updateuser') ?>",
						data: "iduser="+iduser+"&nama_user="+nameuser+"&role="+rolename,
						success: function(data){
							if(data != 1){
								swal("Data Gagal Diubah!","Data Tidak Bisa Diubah","error");
							}else{
								swal("Data Berhasil Diubah!","Data SUdah Diubah","success")
								.then((value) => {
								  document.location.href = '<?php echo base_url('dashboard/users') ?>';
								});
							}
						}
					});
				});
			});
		</script>

</body>

</html>
