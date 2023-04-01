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
        </form>
      </div>
    </div>
  </div>
</section>

<?php $this->load->view("admin/_partials/js.php") ?>

<script>
	$(document).ready(function(){
		$('#signin').click(function(){
			var email = $('#email').val();
			var pass = $('#password').val();
			if(email != '' && pass != '' ){
				$.ajax({
					type: "POST",
					url: "http://localhost/Elbay/Elbay-V.1.2/api/login",
					data: "X-API-KEY=restapi123&email="+email+"&password="+pass,
					success: function(data){
						if(data == 0){
							swal("Login Gagal!","Pastikan Semua Benar","error");
						}else{
							swal("Login Sukses!","Selamat Datang","success")
							.then((value) => {
								document.location.href = '<?php echo base_url('auth') ?>';
							});
						}
					}
				});
			}else{
				swal("Pastikan semua sudah terisi!","Cek lagi form Anda","warning");
			}
		});
	});
</script>