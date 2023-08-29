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

				<div class="card mb-3">
					<div class="card-header">
						<a href="<?php echo site_url('dashboard/users/') ?>"><i class="fas fa-arrow-left"></i> Back</a>
					</div>
					<div class="card-body">

						<div class="form-group">
							<label for="name">Username</label>
							<input class="form-control" type="text" id="username" name="name" placeholder="Username" />
						</div>
						
						<div class="form-group">
							<label for="pass">Password</label>
							<input class="form-control" type="password" id="pass" name="pass" placeholder="Password" />
						</div>
						
						<div class="form-group">
							<label for="pass2">Confirm Password</label>
							<input class="form-control" type="password" id="pass2" name="pass2" placeholder="Confirm Password" />
						</div>
						
						<div class="form-group">
							<label for="role">Role</label>
							<select class="form-control" name="role" id="role">
								<option value="Admin">Admin</option>
								<option value="Penyewa">Penyewa</option>
							</select>
						</div>

						<input class="btn btn-success" type="button" name="btn" id="adduser" value="Add User" />

					</div>

					<div class="card-footer small text-muted">
						
					</div>


				</div>
				
				<?php $this->load->view("admin/_partials/footer.php") ?>

			</div>

		</div>


		<?php $this->load->view("admin/_partials/scrolltop.php") ?>
		<?php $this->load->view("admin/_partials/js.php") ?>
		
		<script>
			$(document).ready(function(){
				$('#adduser').click(function(){
					var username = $('#username').val();
					var pass = $('#pass').val();
					var pass2 = $('#pass2').val();
					var role = $('#role').val();
					if(username != '' && pass != '' && pass2 != ''){
						if(pass == pass2){
							$.ajax({
								type: "POST",
								url: "<?php echo base_url('register/insertregister') ?>",
								data: "username="+username+"&password="+pass,
								success: function(data){
									if(data == 0){
										Swal.fire({
											icon: 'error',
											title: 'Registrasi Gagal!',
											text: 'Pastikan Password Sama',
											timer: 2000,
										});
									}else{
										Swal.fire({
											icon: 'success',
											title: 'Registrasi Sukses!',
											text: 'Silahkan login',
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
								title: 'Pastikan Password Sudah Sama!',
								text: 'Cek lagi form Anda',
								timer: 2000,
								showConfirmButton: false 
							});
						}
					}else{
						Swal.fire({
							icon: 'warning',
							title: 'Pastikan semua sudah terisi!',
							text: 'Cek lagi form Anda',
							timer: 2000,
							showConfirmButton: false 
						});
					}
				});
			});
		</script>

</body>

</html>
