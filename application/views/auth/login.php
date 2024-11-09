<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="<?= base_url(); ?>assets/img/login.jpg" class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <h1 class="text-center mb-4">Login</h1>
		<div class="form-outline mb-4">
			<input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>"/>
		</div>
		<div class="form-outline mb-4">
			<input type="password" id="password" name="password" placeholder="Password" class="form-control form-control-lg" />
		</div>
		<button class="btn btn-primary btn-lg btn-block" id="signin">Sign in</button>
		<br>
		<div class="d-flex justify-content-around align-items-center mb-4">
			<a href="#!">Forgot password?</a>
			<a href="#!">Create an Account!</a>
		</div>
      </div>
    </div>
  </div>
</section>

<script>
	$(document).ready(function(){
		$('#signin').click(function(){
			var email = $('#email').val();
			var pass = $('#password').val();
			if(email != '' && pass != '' ){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('auth/check_login') ?>",
					data: "email="+email+"&password="+pass,
					success: function(data){
						// console.log(data);
						var res = JSON.parse(data);
						// console.log(res.status);
						if(res.status == true){
							Swal.fire({
								icon: 'success',
								title: 'Login Sukses!',
								text: 'Selamat Datang',
								timer: 2000,
								showConfirmButton: false 
							})
							.then((value) => {
								document.location.href = '<?php echo base_url('auth/set_login?email=') ?>'+email;
							});
						}else{
							Swal.fire({
								icon: 'error',
								title: 'Login Gagal!',
								text: 'Pastikan Semua Benar',
								timer: 2000,
							});
						}
					}
				});
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