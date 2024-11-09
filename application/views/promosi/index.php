 <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#promosiModal">
          <i class="fa fa-user-plus"></i>  Kelola Promosi
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Promosi</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Product</th>
                <th>Tipe</th>
                <th>Total Promo %</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($promoses as $promo){ 
					  ?>
    					<tr>
    						<td scope="row" style="width:5%;"><?= $i++; ?></td>
    						<td><?= $promo->nama; ?></td>
    						<td><?= $promo->id_product; ?></td>
    						<td><?= $promo->tipe; ?></td>
    						<td><?= $promo->total_promo; ?></td>
    						<td><?= Date("d/m/Y", strtotime($promo->start_date)) ?></td>
    						<td><?= Date("d/m/Y", strtotime($promo->end_date)) ?></td>
    						<td><?= $promo->deskripsi; ?></td>
    						<td style="width: 15%;">
                  <button type="button" class="btn btn-xs btn-info edit-userbranch" data-id="<?= $promo->id ?>">Edit</button>
                  <button type="button" class="btn btn-xs btn-danger delete-userbranch" data-id="<?= $promo->id ?>">Delete</button>
    						</td>
    					</tr>
    				<?php } ?>
    			  </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

</div>

<div class="modal fade" id="promosiModal" tabindex="-1" role="dialog" aria-labelledby="promosiModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="promosiModalLabel">Kelola Promosi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
      <div class="modal-body">
        <div class="form-group">
            <label>Nama: </label>
            <input type="hidden" id="id" name="id">
            <input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
        </div>
        <div class="form-group">
          <label>Produk: </label>
          <select name="produk" id="produk" class="form-control">
            <?php foreach($items as $item){ ?>
                <option value="<?= $item->id ?>"><?= $item->name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
            <label>Tipe: </label>
            <select name="tipe" id="tipe" class="form-control">
              <option value="one_item">Satu Item</option>
              <option value="all_item">Semua Item</option>
            </select>
        </div>
        <div class="form-group">
            <label>Total Promo %: </label>
            <input type="text" class="form-control" id="promo" name="promo" placeholder="Input Total Promo">
        </div>
        <div class="form-group">
            <label>Tanggal Mulai: </label>
            <input type="date" class="form-control" id="mulai" name="mulai" placeholder="Input Tanggal Mulai">
        </div>
        <div class="form-group">
            <label>Tanggal Berakhir: </label>
            <input type="date" class="form-control" id="akhir" name="akhir" placeholder="Input Tanggal Berakhir">
        </div>
        <div class="form-group">
            <label>Deskripsi: </label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-promosi">Tambah</button>
        <button type="button" class="btn btn-primary promosi-edit" style="display:none;">Ubah</button>
      </div>
		</div>
	</div>
</div>

<script>
  $('#add').on('click',function(){
    $('#id').val('');
    $('.promosi-edit').hide();
    $('.add-promosi').show();
  });

  $('.add-promosi').on('click',function(){
    var nama = $('#name').val();
    var produk = $('#produk').val();
    var tipe = $('#tipe').val();
    var total_promo = $('#promo').val();
    var date_start = $('#mulai').val();
    var date_end = $('#akhir').val();
    var deskripsi = $('#deskripsi').val();
    // console.log(nama+' '+produk+' '+tipe+' '+total_promo+' '+date_start+' '+date_end+' '+deskripsi);
      $.ajax({
        type: "POST",
        url: "<?= base_url('promosi/input') ?>",
        data: {
          nama: nama,
          produk: produk,
          tipe: tipe,
          total_promo: total_promo,
          date_start: date_start,
          date_end: date_end,
          deskripsi: deskripsi,
        },
        success: function(data){
          var res = JSON.parse(data);
          if(res.status == true){
            Swal.fire({
              icon: 'success',
              title: 'User Cabang Baru Berhasil Ditambahkan!',
              text: 'Input Data Sukses',
              timer: 2000,
              showConfirmButton: false 
            })
            .then((value) => {
              location.reload();
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Input Data Gagal!',
              text: 'Silahkan Coba Beberapa Saat Lagi',
              timer: 2000,
            });
          }
        }
      });
  });

  $('.delete-userbranch').on('click',function(){
    const userbranchId = $(this).data('id');
    Swal.fire({
        title: "Anda yakin ingin menghapus data ini?",
        text: "Data yang sudah dihapus tidak akan bisa dikembalikan",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete)=>{
        if(willDelete){
          $.ajax({
            type: "POST",
            url: "<?php echo base_url('userbranch/delete') ?>",
            data: "id="+userbranchId,
            success: function(data){
              var res = JSON.parse(data);
              if(res.status == true){
                Swal.fire({
                  icon: 'success',
                  title: 'Data Berhasil Dihapus!',
                  text: 'Hapus Data Sukses',
                  timer: 2000,
                  showConfirmButton: false 
                })
                .then((value) => {
                  location.reload();
                });
              }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Hapus Data Gagal!',
                  text: 'Silahkan Coba Beberapa Saat Lagi',
                  timer: 2000,
                });
              }
            }
          });
        }else{
          Swal.fire({
            icon: 'warning',
            title: 'Anda Memilih Tidak Menghapus!',
            text: 'Tidak Jadi Menghapus',
            timer: 2000,
            showConfirmButton: false 
          });
        }
      });
  });
   
  $('.edit-userbranch').on('click',function(){
    $('.add-userbranch').hide();
    $('.userbranch-edit').show();
    const userbranchId = $(this).data('id');
    $('#userBranchModal').modal('show');
    $.ajax({
        url: "<?= base_url('userbranch/edit/'); ?>"+userbranchId,
        type: 'GET',
        success: function(res) {
            data = JSON.parse(res);
            $('#cabang').val(data.branch_id);
            $('#id').val(data.userbranchid);
            $('#user').val(data.user_id);
        }
    });
  });

  $('.userbranch-edit').on('click',function(){
    var cabang = $('#cabang').val();
    var id = $('#id').val();
    var user = $('#user').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('userbranch/update') ?>",
      data: {
        userbranch_id: id,
        cabang: cabang,
        user: user,
      },
      success: function(data){
        var res = JSON.parse(data);
        if(res.status == true){
          Swal.fire({
            icon: 'success',
            title: 'User Cabang Baru Berhasil Diupdate!',
            text: 'Update Data Sukses',
            timer: 2000,
            showConfirmButton: false 
          })
          .then((value) => {
            location.reload();
          });
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Update Data Gagal!',
            text: 'Silahkan Coba Beberapa Saat Lagi',
            timer: 2000,
          });
        }
      }
    });
  });
</script>