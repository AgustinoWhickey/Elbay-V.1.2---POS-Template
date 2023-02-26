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
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover" id="tbl-attendance" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Judul Buku</th>
										<th>Pengarang</th>
										<th>Jenis Buku</th>
										<th>Harga Sewa Per Hari</th>
										<th>Jumlah Hari Sewa</th>
										<th>Total Sewa</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($laporans as $laporan): ?>
									<tr>
										<td><?= $laporan['judul_buku'] ?></td>
										<td><?= $laporan['pengarang'] ?></td>
										<td><?= $laporan['jenis_buku'] ?></td>
										<td><?= $laporan['harga_sewa_perhari'] ?></td>
										<td><?= $laporan['jml_hari_sewa'] ?></td>
										<td><?= $laporan['total_sewa'] ?></td>
									</tr>
									<?php endforeach; ?>

								</tbody>
								<tfoot>
									<tr><th></th><th></th><th></th><th colspan="2" style="text-align:right;"></th><th></th></tr>
								</tfoot>
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
			 $('#tbl-attendance').dataTable({
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
		
					var intVal = function ( i ) {
						return typeof i === 'string' ?
							i.replace(/[\$,]/g, '')*1 :
							typeof i === 'number' ?
								i : 0;
					};
	   
					total = api
						.column( 5 )
						.data()
						.reduce( function (a, b) {
							return intVal(a) + intVal(b);
						}, 0 );
		
					pageTotal = api
						.column( 5, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
							return intVal(a) + intVal(b);
						}, 0 );
		
					$( api.column( 4 ).footer() ).html(
						 'Grand Total Sewa' 
					);
					
					$( api.column( 5 ).footer() ).html(
						 total 
					);
				} 
            });
		});
	</script>
</body>

</html>
