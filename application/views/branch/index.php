 <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#branchModal">
          <i class="fa fa-user-plus"></i>  Tambah Cabang
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Cabang</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($branches as $branch){ 
					  ?>
    					<tr>
    						<td scope="row" style="width:5%;"><?= $i++; ?></td>
    						<td><?= $branch->name; ?></td>
    						<td><?= $branch->phone; ?></td>
    						<td><?= $branch->address; ?></td>
    						<td><?= $branch->description; ?></td>
    						<td style="width: 15%;">
                  <button type="button" class="btn btn-xs btn-info edit-branch" data-id="<?= $branch->id ?>">Edit</button>
                  <button type="button" class="btn btn-xs btn-danger delete-branch" data-id="<?= $branch->id ?>">Delete</button>
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

<div class="modal fade" id="branchModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Tambah Cabang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Cabang: </label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
          <input type="hidden" id="id">
        </div>
        <div class="form-group">
          <label>No Telepon: </label>
          <input type="text" class="form-control" id="phone" name="phone" placeholder="Input No Telepon">
        </div>
        <div class="form-group">
            <label>Alamat: </label>
            <textarea class="form-control" id="address" name="address"></textarea> 
        </div>
        <div class="form-group">
            <label>Deskripsi: </label>
            <textarea class="form-control" id="description" name="description"></textarea> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-branch">Tambah</button>
        <button type="button" class="btn btn-primary branch-edit" style="display:none;">Ubah</button>
      </div>
		</div>
	</div>
</div>

<script>
  $('#add').on('click',function(){
    $('#name').val('');
    $('#id').val('');
    $('#phone').val('');
    $('#address').val('');
    $('#description').val('');
    $('.branch-edit').hide();
    $('.add-branch').show();
  });

  $('.add-branch').on('click',function(){
    var nama = $('#name').val();
    var phone = $('#phone').val();
    var address = $('#address').val();
    var description = $('#description').val();
    if(nama != '' && phone != '' && address != '' ){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('branch/input') ?>",
        data: {
          nama: nama,
          phone: phone,
          address: address,
          description: description,
        },
        success: function(data){
          var res = JSON.parse(data);
          console.log(res.status);
          if(res.status == true){
            Swal.fire({
              icon: 'success',
              title: 'Cabang Baru Berhasil Ditambahkan!',
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
    }else{
      Swal.fire({
        icon: 'warning',
        title: 'Pastikan semua form sudah terisi!',
        text: 'Cek lagi form Anda',
        timer: 2000,
        showConfirmButton: false 
      });
    }
  });

  $('.delete-branch').on('click',function(){
    const branchId = $(this).data('id');
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
            url: "<?php echo base_url('branch/delete') ?>",
            data: "id="+branchId,
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
   
  $('.edit-branch').on('click',function(){
    $('.add-branch').hide();
    $('.branch-edit').show();
    const branchId = $(this).data('id');
    $('#branchModal').modal('show');
    $.ajax({
        url: "<?= base_url('branch/edit/'); ?>"+branchId,
        type: 'GET',
        success: function(res) {
            data = JSON.parse(res);
            $('#name').val(data.name);
            $('#id').val(data.id);
            $('#phone').val(data.phone);
            $('#address').val(data.address);
            $('#description').val(data.description);
        }
    });
  });

  $('.branch-edit').on('click',function(){
    var nama = $('#name').val();
    var id = $('#id').val();
    var phone = $('#phone').val();
    var address = $('#address').val();
    var description = $('#description').val();
    if(nama != '' && phone != '' && address != '' ){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('branch/update') ?>",
        data: {
          branch_id: id,
          nama: nama,
          phone: phone,
          address: address,
          description: description,
       },
        success: function(data){
          var res = JSON.parse(data);
          if(res.status == true){
            Swal.fire({
              icon: 'success',
              title: 'Cabang Baru Berhasil Diupdate!',
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
    }else{
      Swal.fire({
        icon: 'warning',
        title: 'Pastikan semua form sudah terisi!',
        text: 'Cek lagi form nama',
        timer: 2000,
        showConfirmButton: false 
      });
    }
  });
</script>