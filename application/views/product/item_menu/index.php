  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-12 text-right">
        <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#itemMenuModal">
          <i class="fa fa-user-plus"></i>  Tambah Item
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Item</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Stock</th>
                <th>Unit</th>
                <th>Harga Per Unit</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </thead>
            <tbody>
            <?php
    					$i = 1; 
    					foreach($items as $it){ 
					  ?>
    					<tr>
    						<th scope="row"><?= $i++; ?></th>
    						<td><?= $it->name; ?></td>
                <td><?= $it->stock; ?></td>
    						<td><?= $it->unit; ?></td>
    						<td><?= indo_currency($it->unit_price); ?></td>
    						<td><img src=<?= base_url('assets/img/upload/items/'.$it->image) ?> class="img" style="width:100px"></td>
                <td style="width: 15%;">
                  <button type="button" class="btn btn-xs btn-info edit-item-menu" data-id="<?= $it->id ?>">Edit</button>
                  <button type="button" class="btn btn-xs btn-danger delete-item-menu" data-id="<?= $it->id ?>" data-image="<?= $it->image ?>">Delete</button>
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

<div class="modal fade" id="itemMenuModal" tabindex="-1" role="dialog" aria-labelledby="itemMenuModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="itemMenuModal">Tambah Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
      <form id="itemmenu-form" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group" id="item-menu-form">
            <label>Nama Item: </label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="image" name="image">
					</div>
          <div class="form-group">
            <label>Unit: </label>
						<input type="text" class="form-control" id="unit" name="unit" placeholder="Input Unit">
					</div>
          <div class="form-group">
            <label>Harga Per Unit: </label>
						<input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="Input Harga">
					</div>
          <div class="form-group">
            <label>Stock: </label>
						<input type="number" class="form-control" id="stock" name="stock" placeholder="Input Stock">
					</div>
          <div class="form-group">
            <label>Gambar: </label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="image" name="image">
              <label for="image" class="custom-file-label">Choose file</label>
            </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary add-item-menu">Tambah</button>
          <button type="submit" class="btn btn-primary item-menu-edit" style="display:none;">Ubah</button>
				</div>
      </form>
		</div>
	</div>
</div>

<script>
  var edit = false;
  var itemId = '';
  var url = '';
  var alertText = '';

  $(document).ready(function() {
    $('#table1').DataTable();
  });

  $('#add').on('click',function(){
    $('#name').val('');
    $('#unit').val('');
    $('#unit_price').val('');
    $('#stock').val('');
    $('#image').val('');
    $('#id').val('');

    $('.item-menu-edit').hide();
    $('.add-item-menu').show();

    edit = false;
  });

  $('.edit-item-menu').on('click',function(){
    $('.add-item-menu').hide();
    $('.item-menu-edit').show();
    itemId = $(this).data('id');
    $('#itemMenuModal').modal('show');
    $.ajax({
        url: "<?= base_url('itemmenu/edit/'); ?>"+itemId,
        type: 'GET',
        success: function(res) {
          data = JSON.parse(res);
          edit = true;
          $('#name').val(data.name);
          $('#id').val(data.id);
          $('#image').val(data.image);
          $('#unit').val(data.unit);
          $('#unit_price').val(data.unit_price);
          $('#stock').val(data.stock);
        }
    });
  });

  $('#itemmenu-form').submit(function(event) {
    event.preventDefault(); 
    var formData = new FormData(this); 
    if(edit) {
      url = "<?php echo base_url('itemmenu/update') ?>";
      alertText = 'Ubah';
    } else {
      url = "<?php echo base_url('itemmenu/input') ?>";
      alertText = 'Tambah';
    }
    
    $.ajax({
      type: 'POST',
      url: url,
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        var res = JSON.parse(data);
        if(res.status == true){
          swal("Item Menu Berhasil Di" + alertText, alertText + " Data Sukses","success")
          .then((value) => {
            location.reload();
          });
        }else{
          swal("Pastikan nama sudah terisi!","Cek lagi form nama","warning");
        }
      }
    });
  });

  $('.delete-item-menu').on('click',function(){
    const itemId = $(this).data('id');
    const image = $(this).data('image');
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
            url: "<?php echo base_url('itemmenu/delete') ?>",
            data: {
              id: itemId,
              gambar: image
            },
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
</script>