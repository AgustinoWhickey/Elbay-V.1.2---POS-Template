 <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#kategoriModal">
          <i class="fa fa-user-plus"></i>  Tambah Kategori
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Kategori</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($categories as $cat){ 
					  ?>
    					<tr>
    						<td scope="row" style="width:5%;"><?= $i++; ?></td>
    						<td><?= $cat->nama; ?></td>
    						<td style="width: 15%;">
                  <button type="button" class="btn btn-xs btn-info edit-category" data-id="<?= $cat->id ?>">Edit</button>
                  <button type="button" class="btn btn-xs btn-danger delete-category" data-id="<?= $cat->id ?>">Delete</button>
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

<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Tambah Kategori</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Kategori: </label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
          <input type="hidden" id="id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-category">Tambah</button>
        <button type="button" class="btn btn-primary category-edit" style="display:none;">Ubah</button>
      </div>
		</div>
	</div>
</div>

<script>
  $('#add').on('click',function(){
    $('#name').val('');
    $('#id').val('');
    $('.category-edit').hide();
    $('.add-category').show();
  });

  $('.add-category').on('click',function(){
    var nama = $('#name').val();
    if(nama != '' ){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('category/input') ?>",
        data: "nama="+nama,
        success: function(data){
          var res = JSON.parse(data);
          console.log(res.status);
          if(res.status == true){
            Swal.fire({
              icon: 'success',
              title: 'Kategory Baru Berhasil Ditambahkan!',
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
        title: 'Pastikan nama sudah terisi!',
        text: 'Cek lagi form Anda',
        timer: 2000,
        showConfirmButton: false 
      });
    }
  });

  $('.delete-category').on('click',function(){
    const catId = $(this).data('id');
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
            url: "<?php echo base_url('category/delete') ?>",
            data: "id="+catId,
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
   
  $('.edit-category').on('click',function(){
    $('.add-category').hide();
    $('.category-edit').show();
    const catId = $(this).data('id');
    $('#kategoriModal').modal('show');
    $.ajax({
        url: "<?= base_url('category/edit/'); ?>"+catId,
        type: 'GET',
        success: function(res) {
            data = JSON.parse(res);
            $('#name').val(data.nama);
            $('#id').val(data.id);
        }
    });
  });

  $('.category-edit').on('click',function(){
    var nama = $('#name').val();
    var id = $('#id').val();
    if(nama != '' ){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('category/update') ?>",
        data: {
         category_id: id,
         nama: nama
       },
        success: function(data){
          var res = JSON.parse(data);
          if(res.status == true){
            Swal.fire({
              icon: 'success',
              title: 'Kategory Baru Berhasil Diupdate!',
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
        title: 'Pastikan nama sudah terisi!',
        text: 'Cek lagi form nama',
        timer: 2000,
        showConfirmButton: false 
      });
    }
  });
</script>