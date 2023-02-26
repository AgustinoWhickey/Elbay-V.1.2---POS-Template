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
						<a href="<?php echo site_url('dashboard/transaksipeminjaman') ?>"><i class="fas fa-arrow-left"></i> Back</a>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label for="judulbuku">Judul Buku</label>
							<select class="form-control" id="judulbuku">
								<option value="">-- Pilih Judul Buku --</option>
							<?php
								foreach($bukus as $buku){
									echo "<option value='$buku->id_book'>$buku->judul_buku</option>";
								}
							?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="pengarang">Pengarang</label>
							<input class="form-control" type="text" id="pengarang" name="pengarang" readonly="readonly" placeholder="Pengarang" />
						</div>
						
						<div class="form-group">
							<label for="jenisbuku">Jenis Buku</label>
							<input class="form-control" type="text" id="jenisbuku" name="jenisbuku" readonly="readonly" placeholder="Jenis Buku" />
						</div>
						
						<div class="form-group">
							<label for="hargasewa">Harga Sewa Per Hari</label>
							<input class="form-control" type="text" id="hargasewa" name="hargasewa" readonly="readonly" placeholder="Harga Sewa Per Hari" />
						</div>
						
						<div class="form-group">
							<label for="tglmulai">Tanggal Mulai Peminjaman</label>
							<input class="form-control" type="date" id="tglmulai" name="tglmulai" placeholder="Tanggal Mulai Peminjaman" />
						</div>
						
						<div class="form-group">
							<label for="tglselesai">Tanggal Selesai Peminjaman</label>
							<input class="form-control" type="date" id="tglselesai" name="tglselesai" placeholder="Tanggal Selesai Peminjaman" />
						</div>

						<input class="btn btn-success" type="button" name="btn" id="addtransaksi" value="Sewa Buku" />

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
				
				$('#addtransaksi').click(function(){
					var idbuku = $('#judulbuku').val();
					var tglmulai = $('#tglmulai').val();
					var tglselesai = $('#tglselesai').val();
					if(judulbuku != '' && tglmulai != '' && tglselesai != ''){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('dashboard/inserttransaksi') ?>",
							data: "idbuku="+idbuku+"&tglmulai="+tglmulai+"&tglselesai="+tglselesai,
							success: function(data){
								if(data == 0){
									swal("Input Transaksi Peminjaman Gagal!","Pastikan Semua Form Sudah Terisi","error");
								}else{
									swal("Input Transaksi Peminjaman Sukses!","Anda Akan Kembali ke Halaman Transaksi Peminjaman","success")
									.then((value) => {
									  document.location.href = '<?php echo base_url('dashboard/transaksipeminjaman') ?>';
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
