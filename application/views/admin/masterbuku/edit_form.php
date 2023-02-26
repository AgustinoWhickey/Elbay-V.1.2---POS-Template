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

						<a href="<?php echo site_url('dashboard/masterbuku') ?>"><i class="fas fa-arrow-left"></i> Back</a>
					</div>
					<div class="card-body">

						<input type="hidden" id="idbook" name="id" value="<?= $buku[0]['id_book'] ?>" />

						<div class="form-group">
							<label for="judulbuku">Judul Buku</label>
							<input class="form-control" type="text" name="judulbuku" id="judulbuku" placeholder="Judul Buku" value="<?= $buku[0]['judul_buku'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="pengarang">Pengarang</label>
							<input class="form-control" type="text" name="pengarang" id="pengarang" placeholder="Pengarang" value="<?= $buku[0]['pengarang'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="jenisbuku">Jenis Buku</label>
							<input class="form-control" type="text" name="jenisbuku" id="jenisbuku" placeholder="Jenis Buku" value="<?= $buku[0]['jenis_buku'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="hargasewa">Harga Sewa Per Hari</label>
							<input class="form-control" type="text" name="hargasewa" id="hargasewa" placeholder="Harga Sewa Per Hari" value="<?= $buku[0]['harga_sewa_perhari'] ?>" />
						</div>

						<input class="btn btn-success" type="button" id="updatemasterbuku" name="btn" value="Update" />

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
				$('#updatemasterbuku').click(function(){
					var idbook = $('#idbook').val();
					var judulbuku = $('#judulbuku').val();
					var pengarang = $('#pengarang').val();
					var jenisbuku = $('#jenisbuku').val();
					var hargasewa = $('#hargasewa').val();
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/updatemasterbuku') ?>",
						data: "id_book="+idbook+"&judul_buku="+judulbuku+"&pengarang="+pengarang+"&jenis_buku="+jenisbuku+"&harga_sewa_perhari="+hargasewa,
						success: function(data){
							if(data != 1){
								swal("Data Gagal Diubah!","Data Tidak Bisa Diubah","error");
							}else{
								swal("Data Berhasil Diubah!","Data Sudah Diubah","success")
								.then((value) => {
								  document.location.href = '<?php echo base_url('dashboard/masterbuku') ?>';
								});
							}
						}
					});
				});
			});
		</script>

</body>

</html>
