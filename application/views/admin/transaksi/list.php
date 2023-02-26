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
						<a href="<?php echo site_url('dashboard/addtransaksi') ?>"><i class="fas fa-plus"></i> Tambah Sewa Baru</a>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>ID Transaksi</th>
										<th>Judul Buku</th>
										<th>Pengarang</th>
										<th>Jenis Buku</th>
										<th>Harga Sewa Per Hari</th>
										<th>Tanggal Mulai Peminjaman</th>
										<th>Tanggal Selesai Peminjaman</th>
										<th style="text-align:center;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($transaksis as $transaksi): ?>
									<tr>
										<td><?= $transaksi['id_transaksi'] ?></td>
										<td><?= $transaksi['judul_buku'] ?></td>
										<td><?= $transaksi['pengarang'] ?></td>
										<td><?= $transaksi['jenis_buku'] ?></td>
										<td><?= $transaksi['harga_sewa_perhari'] ?></td>
										<td><?= $transaksi['tgl_pinjam'] ?></td>
										<td><?= $transaksi['tgl_selesai'] ?></td>
										<td width="250" style="text-align:center;">
											<a  href="<?php echo base_url('dashboard/edittransaksi/'.$transaksi['id_transaksi']) ?>" id="edittransaksi" idtrans="<?= $transaksi['id_transaksi'] ?>" class="btn btn-small"><i class="fas fa-edit"></i> </a>
											<a id="deletetransaksi" idtrans="<?= $transaksi['id_transaksi'] ?>" class="btn btn-small text-danger"><i class="fas fa-trash"></i></a>
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
			$('td #deletetransaksi').click(function(){
				var idtrans = $(this).attr('idtrans');
				swal({
					title: "Anda yakin ingin menghapus transaksi ini?",
					text: "Jika sudah dihapus, data tidak akan bisa dikembalikan",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete)=>{
					if(willDelete){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('dashboard/deletetransaksi') ?>",
							data: "idtrans="+idtrans,
							success: function(data){
								if(data == 0){
									swal("Data Gagal Dihapus!","Data Tidak Bisa Dihapus","error");
								}else{
									swal("Data Berhasil Dihapus!","Data Sudah Dihapus","success")
									.then((value) => {
									  document.location.href = '<?php echo base_url('dashboard/transaksipeminjaman') ?>';
									});
								}
							}
						});
					}else{
						swal("Anda Memilih Tidak Menghapus!","Tidak Jadi Menghapus","warning");
					}
				});
			});
		});
	</script>
</body>

</html>
