 <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#userBranchModal">
          <i class="fa fa-user-plus"></i>  Kelola User Cabang
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table User Cabang</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Cabang</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($userbranches as $userbranch){ 
					  ?>
    					<tr>
    						<td scope="row" style="width:5%;"><?= $i++; ?></td>
    						<td><?= $userbranch->username; ?></td>
    						<td><?= $userbranch->name; ?></td>
    						<td style="width: 15%;">
                  <button type="button" class="btn btn-xs btn-info edit-userbranch" data-id="<?= $userbranch->userbranchid ?>">Edit</button>
                  <button type="button" class="btn btn-xs btn-danger delete-userbranch" data-id="<?= $userbranch->userbranchid ?>">Delete</button>
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

<div class="modal fade" id="userBranchModal" tabindex="-1" role="dialog" aria-labelledby="userBranchModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userBranchModalLabel">Kelola Cabang User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
      <div class="modal-body">
        <div class="form-group">
          <label>Cabang: </label>
          <select name="cabang" id="cabang" class="form-control">
            <?php foreach($cabang as $cab){ ?>
                <option value="<?= $cab->id ?>"><?= $cab->name ?></option>
            <?php } ?>
          </select>
          <input type="hidden" id="id" name="id">
        </div>
        <div class="form-group">
          <label>User: </label>
          <select name="user" id="user" class="form-control">
            <?php foreach($users as $user){ ?>
                <option value="<?= $user->userid ?>"><?= $user->name ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add-userbranch">Tambah</button>
        <button type="button" class="btn btn-primary userbranch-edit" style="display:none;">Ubah</button>
      </div>
		</div>
	</div>
</div>

<script>
  $('#add').on('click',function(){
    $('#id').val('');
    $('.userbranch-edit').hide();
    $('.add-userbranch').show();
  });

  $('.add-userbranch').on('click',function(){
    var cabang = $('#cabang').val();
    var user = $('#user').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('userbranch/input') ?>",
        data: {
          cabang: cabang,
          user: user,
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