  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#supplierModal">
          <i class="fa fa-user-plus"></i>  Tambah Supplier
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Supplier</h6>
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
                    foreach($suppliers as $sup){ 
                    ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $sup->name; ?></td>
                        <td><?= $sup->phone; ?></td>
                        <td><?= $sup->address; ?></td>
                        <td><?= $sup->description; ?></td>
                        <td>
                            <button type="button" class="btn btn-xs btn-info edit-supplier" data-id="<?= $sup->id?>">Edit</button>
                            <button type="button" class="btn btn-xs btn-danger delete-supplier" data-id="<?= $sup->id?>">Delete</button>
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

<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
            <form id="supplier-form" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama: </label>
                        <input type="hidden" id="id" name="id">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
                    </div>
                    <div class="form-group">
                        <label>Telepon: </label>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Input No Telepon">
                    </div>
                    <div class="form-group">
                        <label>Alamat: </label>
                        <textarea class="form-control" id="address" name="address">Input Alamat</textarea> 
                    </div>
                    <div class="form-group">
                        <label>Deskripsi: </label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi">Input Deskripsi</textarea> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submitsupplier" class="btn btn-primary">Simpan</button>
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
        $('#telepon').val('');
        $('#address').val('');
        $('#deskripsi').val('');

        edit = false;
    });

    $(document).on("click",".edit-supplier",function() {
        supplierId = $(this).data('id');
        $('#supplierModal').modal('show');
        $.ajax({
            url: "<?= base_url('supplier/edit/'); ?>"+supplierId,
            type: 'GET',
            success: function(res) {
                data = JSON.parse(res);
                edit = true;
                $('#id').val(data.supplier.id);
                $('#name').val(data.supplier.name);
                $('#telepon').val(data.supplier.phone);
                $('#address').val(data.supplier.address);
                $('#deskripsi').val(data.supplier.description);
            }
        });
    });

    $('#supplier-form').submit(function(event) {
        event.preventDefault(); 
        var formData = new FormData(this); 
        if(edit) {
            url = "<?php echo base_url('supplier/update') ?>";
            alertText = 'Ubah';
        } else {
            url = "<?php echo base_url('supplier/input') ?>";
            alertText = 'Tambah';
        }

        var nama = $('#name').val();
        var telepon = $('#telepon').val();
        var address = $('#address').val();
        if(nama != '' || telepon != '' || address != ''){
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    var res = JSON.parse(data);
                    console.log(res.status);
                    if(res.status == true){
                        swal("Supplier Berhasil Di" + alertText, alertText + " Data Sukses","success")
                        .then((value) => {
                        location.reload();
                        });
                    }else{
                        swal("Input Data Gagal!","Silahkan Coba Beberapa Saat Lagi","error");
                    }
                }
            });
        }else{
        swal("Pastikan semua form sudah terisi!","Cek lagi form nama","warning");
        }
    });

    $('.delete-supplier').on('click',function(){
        const suppId = $(this).data('id');
        swal({
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
                    url: "<?php echo base_url('supplier/delete') ?>",
                    data: "id="+suppId,
                    success: function(data){
                        var res = JSON.parse(data);
                        if(res.status == true){
                            swal("Data Berhasil Dihapus!","Hapus Data Sukses","success")
                            .then((value) => {
                            location.reload();
                            });
                        }else{
                            swal("Hapus Data Gagal!","Silahkan Coba Beberapa Saat Lagi","error");
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