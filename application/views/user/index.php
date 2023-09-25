  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#userModal">
          <i class="fa fa-user-plus"></i>  Tambah User
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table User</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Role</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php
                    $i = 1; 
                    foreach($users as $us){ 
                    ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $us->name; ?></td>
                        <td><?= $us->email; ?></td>
                        <td><?= $us->is_active == 1 ? "Aktif" : "Tidak Aktif";  ?></td>
                        <td><?= $us->role;  ?></td>
                        <td>
                            <button type="button" class="btn btn-xs btn-info edit-user" data-id="<?= $us->id?>">Edit</button>
                            <button type="button" class="btn btn-xs btn-danger delete-user" data-id="<?= $us->id?>">Delete</button>
                        </td>
                    </tr>
    				<?php } ?>
    			</tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Tambah User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form id="user-form" method="post">
				<div class="modal-body">
					<div class="form-group">
                        <label>Nama: </label>
                        <input type="hidden" id="id" name="id">
						<input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
					</div>
                    <div class="form-group">
                        <label>Email: </label>
						<input type="text" class="form-control" id="email" name="email" placeholder="Input Email">
					</div>
                    <div class="form-group">
                        <label>Password: </label>
                        <input type="hidden" id="oldpass" name="oldpass">
						<input type="password" class="form-control" id="pass" name="pass">
					</div>
                    <div class="form-group">
                        <label>Confirm Password: </label>
						<input type="password" class="form-control" id="confpass" name="confpass">
					</div>
                    <?php if($this->session->userdata('role_id') == 1) { ?>
                        <div class="form-group">
                        <label>Role: </label>
                        <select name="role" id="role" class="form-control">
                            <option value="2">Admin</option>
                            <option value="3">User</option>
                        </select>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Status: </label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>

  $(document).ready(function() {
    var edit = false;
    var url = '';
    var alertText = '';

    $('#add').on('click',function(){
        $('#id').val('');
        $('#name').val('');
        $('#email').val('');
        $('#pass').val('');
        $('#confpass').val('');
        $('#role').val('');
        $('#status').val('');

        edit = false;
    });

    $('#user-form').submit(function(event) {
        event.preventDefault(); 
        var formData = new FormData(this); 
        if(edit) {
            url = "<?php echo base_url('user/update') ?>";
            alertText = 'Ubah';
        } else {
            url = "<?php echo base_url('user/input') ?>";
            alertText = 'Tambah';
        }

        var id          = $('#id').val('');
        var name        = $('#name').val();
        var email       = $('#email').val();
        var pass        = $('#pass').val();
        var confpass    = $('#confpass').val();
        var role        = $('#role').val();
        var status      = $('#status').val();
        if(name != '' || email != '' || pass != '' || role != '' || status != '' || pass != ''){
            if(pass == confpass){
                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        var res = JSON.parse(data);
                        if(res.status == true){
                            Swal.fire({
								icon: 'success',
								title: "User Berhasil Di" + alertText,
								text: alertText + " Data Sukses",
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
                    icon: 'error',
                    title: 'Pastikan password sudah sesuai!',
                    text: 'Cek lagi form password Anda',
                    timer: 2000,
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Pastikan semua form sudah terisi!',
                text: 'Cek lagi form Anda',
                timer: 2000,
            });
        }
    });

    $(document).on("click",".edit-user",function() {
        userId = $(this).data('id');
        $('#userModal').modal('show');
        $.ajax({
            url: "<?= base_url('user/edit/'); ?>"+userId,
            type: 'GET',
            success: function(res) {
                data = JSON.parse(res);
                edit = true;
                $('#id').val(data.oneuser.id);
                $('#name').val(data.oneuser.name);
                $('#email').val(data.oneuser.email);
                $('#oldpass').val(data.oneuser.password);
                $('#role').val(data.oneuser.role_id);
                $('#status').val(data.oneuser.is_active);
            }
        });
    });

    $('.delete-user').on('click',function(){
        const userId = $(this).data('id');
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
                    url: "<?php echo base_url('user/delete') ?>",
                    data: "id="+userId,
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

  });
</script>