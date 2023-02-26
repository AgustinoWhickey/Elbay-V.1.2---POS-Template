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
						<a href="<?php echo site_url('dashboard/masterbuku') ?>"><i class="fas fa-arrow-left"></i> Back</a>
					</div>
					<div class="card-body">

						<div class="form-group">
							<label for="judulbuku">Judul Buku</label>
							<input class="form-control" type="text" id="judulbuku" name="judulbuku" placeholder="Judul Buku" />
						</div>
						
						<div class="form-group">
							<label for="pengarang">Pengarang</label>
							<input class="form-control" type="text" id="pengarang" name="pengarang" placeholder="Pengarang" />
						</div>
						
						<div class="form-group">
							<label for="jenisbuku">Jenis Buku</label>
							<input class="form-control" type="text" id="jenisbuku" name="jenisbuku" placeholder="Jenis Buku" />
						</div>
						
						<div class="form-group">
							<label for="hargasewa">Harga Sewa Per Hari</label>
							<input class="form-control" type="text" id="hargasewa" name="hargasewa" placeholder="Harga Sewa Per Hari" />
						</div>

						<input class="btn btn-success" type="button" name="btn" id="addmasterbuku" value="Add Master Buku" />

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
				$('#addmasterbuku').click(function(){
					var judulbuku = $('#judulbuku').val();
					var pengarang = $('#pengarang').val();
					var jenisbuku = $('#jenisbuku').val();
					var hargasewa = $('#hargasewa').val();
					if(judulbuku != '' && pengarang != '' && jenisbuku != '' && hargasewa != ''){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('dashboard/insertmasterbuku') ?>",
							data: "judulbuku="+judulbuku+"&pengarang="+pengarang+"&jenisbuku="+jenisbuku+"&hargasewa="+hargasewa,
							success: function(data){
								if(data == 0){
									swal("Input Master Buku Gagal!","Pastikan Semua Form Sudah Terisi","error");
								}else{
									swal("Input Master Buku Sukses!","Anda Akan Kembali ke Halaman Master Buku","success")
									.then((value) => {
									  document.location.href = '<?php echo base_url('dashboard/masterbuku') ?>';
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

</body>

</html>
