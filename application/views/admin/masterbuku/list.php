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
						<a href="<?php echo site_url('dashboard/addmasterbuku') ?>"><i class="fas fa-plus"></i> Add New</a>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover" id="table-datatables" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>ID Buku</th>
										<th>Judul Buku</th>
										<th>Pengarang</th>
										<th>Jenis Buku</th>
										<th>Harga Sewa Per Hari</th>
										<th style="text-align:center;">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bukus as $buku): ?>
									<tr>
										<td><?= $buku->id_book ?></td>
										<td><?= $buku->judul_buku ?></td>
										<td><?= $buku->pengarang ?></td>
										<td><?= $buku->jenis_buku ?></td>
										<td><?= $buku->harga_sewa_perhari ?></td>
										<td width="250" style="text-align:center;">
											<a  href="<?php echo base_url('dashboard/editmasterbuku/'.$buku->id_book) ?>" id="editmasterbuku" iduser="<?= $buku->id_book ?>" class="btn btn-small"><i class="fas fa-edit"></i> </a>
											<a id="deletemasterbuku" idbuku="<?= $buku->id_book ?>" class="btn btn-small text-danger"><i class="fas fa-trash"></i></a>
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
			$('#table-datatables').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel', 'pdf', 'print']
			});
			$('td #deletemasterbuku').click(function(){
				var idbuku = $(this).attr('idbuku');
				swal({
					title: "Anda yakin ingin menghapus buku ini?",
					text: "Jika sudah dihapus, data tidak akan bisa dikembalikan",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete)=>{
					if(willDelete){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('dashboard/deletemasterbuku') ?>",
							data: "idbuku="+idbuku,
							success: function(data){
								if(data == 0){
									swal("Data Gagal Dihapus!","Data Tidak Bisa Dihapus","error");
								}else{
									swal("Data Berhasil Dihapus!","Data SUdah Dihapus","success")
									.then((value) => {
									  document.location.href = '<?php echo base_url('dashboard/masterbuku') ?>';
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
