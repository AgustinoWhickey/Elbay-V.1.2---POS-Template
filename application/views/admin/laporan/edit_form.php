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

						<a href="<?php echo site_url('dashboard/transaksipeminjaman') ?>"><i class="fas fa-arrow-left"></i> Back</a>
					</div>
					<div class="card-body">

						<input type="hidden" id="idtrans" name="id" value="<?= $transaksi[0]['id_transaksi'] ?>" />

						<div class="form-group">
							<label for="judulbuku">Judul Buku</label>
							<select class="form-control" id="judulbuku">
							<?php
								foreach($bukus as $buku){
									if($buku->id_book == $transaksi[0]['id_book']){
										echo "<option value='$buku->id_book' selected>$buku->judul_buku</option>";
									}else{
										echo "<option value='$buku->id_book'>$buku->judul_buku</option>";
									}
								}
							?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="pengarang">Pengarang</label>
							<input class="form-control" type="text" name="pengarang" id="pengarang" readonly="readonly" placeholder="Pengarang" value="<?= $transaksi[0]['pengarang'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="jenisbuku">Jenis Buku</label>
							<input class="form-control" type="text" name="jenisbuku" id="jenisbuku" readonly="readonly" placeholder="Jenis Buku" value="<?= $transaksi[0]['jenis_buku'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="hargasewa">Harga Sewa Per Hari</label>
							<input class="form-control" type="text" name="hargasewa" id="hargasewa" readonly="readonly" placeholder="Harga Sewa Per Hari" value="<?= $transaksi[0]['harga_sewa_perhari'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="tglmulai">Tanggal Mulai Peminjaman</label>
							<input class="form-control" type="date" id="tglmulai" name="tglmulai" placeholder="Tanggal Mulai Peminjaman" value="<?= $transaksi[0]['tgl_pinjam'] ?>" />
						</div>
						
						<div class="form-group">
							<label for="tglselesai">Tanggal Selesai Peminjaman</label>
							<input class="form-control" type="date" id="tglselesai" name="tglselesai" placeholder="Tanggal Selesai Peminjaman" value="<?= $transaksi[0]['tgl_selesai'] ?>" />
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
				$('#judulbuku').change(function(){
					var idbuku = $(this).val();
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/getmasterbuku') ?>",
						data: "idbuku="+idbuku,
						success: function(data){
							var res = JSON.parse(data)[0];
							$('#pengarang').val(res.pengarang);
							$('#jenisbuku').val(res.jenis_buku);
							$('#hargasewa').val(res.harga_sewa_perhari);
						}
					});
				});
				
				$('#updatemasterbuku').click(function(){
					var idtrans 	= $('#idtrans').val();
					var idbuku 		= $('#judulbuku').val();
					var tglmulai 	= $('#tglmulai').val();
					var tglselesai 	= $('#tglselesai').val();
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/updatetransaksi') ?>",
						data: "idtrans="+idtrans+"&idbuku="+idbuku+"&tglmulai="+tglmulai+"&tglselesai="+tglselesai,
						success: function(data){
							if(data != 1){
								swal("Data Gagal Diubah!","Data Tidak Bisa Diubah","error");
							}else{
								swal("Data Berhasil Diubah!","Data Sudah Diubah","success")
								.then((value) => {
								  document.location.href = '<?php echo base_url('dashboard/transaksipeminjaman') ?>';
								});
							}
						}
					});
				});
			});
		</script>

</body>

</html>
