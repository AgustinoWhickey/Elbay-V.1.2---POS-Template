<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col-lg-12 text-right">
      <a href="" class="btn btn-primary mb-3" id="add" data-toggle="modal" data-target="#itemModal">
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
              <th>Kode</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Stock</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
                  
                </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>

<!-- End of Main Content -->

<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content" style="width:200%;margin-left:-40%;">
        <div class="modal-header">
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                  <h1 class="h3 mb-4 text-gray-800">Tambah Product</h1>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-md-2 form-group">
                <label>Nama Item: </label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Input Nama">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="gambar" name="gambar">
              </div>
              <div class="col-md-2 form-group">
                <label>Kode: </label>
                <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Input Barcode">
              </div>
              <div class="col-md-2 form-group">
                <label>Kategori: </label>
                <select name="kategori" id="kategori" class="form-control">
                  <?php foreach($category as $cat){ ?>
                      <option value="<?= $cat->id ?>"><?= $cat->nama ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2 form-group">
                <label>Harga: </label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Input Harga">
              </div>
              <div class="col-md-3 form-group">
                <label>Gambar: </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="image" name="image">
                  <label for="image" class="custom-file-label">Choose file</label>
                </div>
              </div>
              <div class="col-md-2 form-group" id="stockinput" style="display:none;">
                <label>Stock: </label>
                <input type="text" class="form-control" id="stock" name="stock" disabled>
              </div>

            </div>
          </div>
        </div>

        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Menu Product</h6>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 form-group">
                <label>Nama Bahan: </label>
                <input type="hidden" id="idbahan" name="idbahan" value="1">
                <input type="hidden" id="selectedbahan" name="selectedbahan">
                <select name="namabahan" id="namabahan" class="form-control">
                  <option value="" selected>-- Pilih Bahan --</option>
                  <?php foreach($unititems as $item){ ?>
                      <option value="<?= $item->id ?>" desc="<?= $item->name ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 form-group">
                <label>Qty: </label>
                <input type="number" class="form-control" id="qtybahan" name="qtybahan">
              </div>
              <div class="col-md-2" style="padding-top: 31px;">
                  <a href="#" class="btn btn-primary mb-3" id="tambahbahan"> Tambah  </a>
              </div>  
            </div>

            <div class="table-responsive">
              <table class="table table-bordered" id="tablebahan" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bahan</th>
                    <th>Qty</th>
                    <th>Aksi</th>
                  <tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="submitmenu" class="btn btn-primary">Simpan</button>
        </div>
      </div>
  </div>
</div>

<script>

  $(document).ready(function() {
    var edit = false;
    var url = '';
    var urlMenuItem = '';
    var alertText = '';

    $('#table1').DataTable({
      "processing": true,
      "ajax": {
        "url": "<?= site_url('item/get_ajax'); ?>",
        "type": "POST"
      },
      "columnDefs": [
        {
          "targets": [4,5],
          "className": 'text-right'
        },
        {
          "targets": [6],
          "className": 'text-center'
        }
      ]
    });

  $('#add').on('click',function(){
    $('#nama').val('');
    $('#barcode').val('');
    $('#kategori').val('');
    $('#harga').val('');
    $('#stock').val('');
    $('#image').val('');
    $('#id').val('');

    $('#tablebahan tbody').empty();
    $('#stockinput').hide();

    edit = false;
  });

  $(document).on("click",".edit-item",function() {
    itemId = $(this).data('id');
    $('#itemModal').modal('show');
    $.ajax({
        url: "<?= base_url('item/edit/'); ?>"+itemId,
        type: 'GET',
        success: function(res) {
          data = JSON.parse(res);
          onemenuitem = data.onemenuitem;
          edit = true;
          $('#stockinput').show();
          $('#id').val(data.oneitem.id);
          $('#nama').val(data.oneitem.name);
          $('#gambar').val(data.oneitem.image);
          $('#barcode').val(data.oneitem.barcode);
          $('#kategori').val(data.oneitem.category_id);
          $('#harga').val(data.oneitem.price);
          $('#stock').val(data.oneitem.stock);
          if(onemenuitem.length != 0) {
            $.ajax({
              url: "<?= base_url('itemmenu/edit_menu_item/'); ?>"+onemenuitem[0].product_id,
              type: 'GET',
              success: function(result) {
                resultData = JSON.parse(result);
                for(i=0; i< resultData.length; i++){
                  var newdata = "<tr><td>"+(i+1)+"</td><td>"+resultData[i].name+"</td><td>"+resultData[i].qty+"</td><td><input type='hidden' name='bahan"+resultData[i].item_id+"' value='"+resultData[i].item_id+"'><input type='hidden' name='qty"+resultData[i].item_id+"' value='"+resultData[i].qty+"'><a href='#' id='deletebahan' class='btn btn-xs btn-danger'>Delete</a></td></tr>";
                  $("#tablebahan tbody").append(newdata);
                }
              }
            });
          }
        }
    });
  });

  $("#namabahan").change(function(){ 
      var element = $(this).find('option:selected'); 
      var myTag = element.attr("desc");

      $('#selectedbahan').val(myTag); 
  }); 

  $(document).on("click","#submitmenu",function() {
    if(edit) {
      url = "<?php echo base_url('item/update') ?>";
      urlMenuItem = "<?php echo base_url('item/update_menu_item') ?>";
      alertText = 'Ubah';
    } else {
      url = "<?php echo base_url('item/input') ?>";
      urlMenuItem = "<?php echo base_url('item/input_menu_item') ?>";
      alertText = 'Tambah';
    }
    const items = {};
    $("#tablebahan > tbody > tr").each(function () {
      items[$(this).find('td').eq(3).find('input').val()] = $(this).find('td').eq(2).text();
    });
    event.preventDefault();
    var id = $('#id').val();
    var nama = $('#nama').val();
    var barcode = $('#barcode').val();
    var kategori = $('#kategori').val();
    var harga = $('#harga').val();
    var gambar = $('#gambar').val();
    var image = $('#image').prop('files')[0];

    var form_data = new FormData();
    form_data.append('id', id);
    form_data.append('nama', nama);
    form_data.append('barcode', barcode);
    form_data.append('kategori', kategori);
    form_data.append('harga', harga);
    form_data.append('gambar', gambar);
    form_data.append('image', image);
    form_data.append('items', JSON.stringify(items));
    if(nama == '' && barcode == ''){
      swal("Masukkan Nama Item atau Barcode terlebih dahulu!","Cek lagi form Anda","warning");
    } else {
      $.ajax({
          url: url, 
          dataType: 'text', 
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function (res) {
            result = JSON.parse(res);
            $.ajax({
              type: "POST",
              url: urlMenuItem,
              data: {
                product: edit ? id : result.data,
                items: JSON.stringify(items),
              },
              success: function(data){
                swal("Item Menu Berhasil Di" + alertText, alertText + " Data Sukses","success")
                .then((value) => {
                  location.reload();
                });
              }
            });
          },
          error: function (res) {
            console.log(res);
          }
      });
    }
  });

  $('#tambahbahan').on('click', function(e){
    var idbahan = $('#idbahan').val();
    var namaid = $('#namabahan').val();
    var selectedbahan = $('#selectedbahan').val();
    var qty = $('#qtybahan').val();

    if(namaid != '' && qty != ''){
      id = parseInt(idbahan);
      $('#idbahan').val(id+1);
      $('#namabahan').val('');
      $('#qtybahan').val('');

      var newdata = "<tr><td>"+idbahan+"</td><td>"+selectedbahan+"</td><td>"+qty+"</td><td><input type='hidden' name='bahan"+idbahan+"' value='"+namaid+"'><input type='hidden' name='qty"+idbahan+"' value='"+qty+"'><a href='#' id='deletebahan' class='btn btn-xs btn-danger'>Delete</a></td></tr>";

      $("#tablebahan tbody").append(newdata);
    } else {
      swal("Pilih bahan dan masukkan quantity terlebih dahulu!","Cek lagi form Anda","warning");
    }
  });

  $(document).on('click', '#deletebahan', function () {
    $(this).closest('tr').remove();
  });

  $(document).on('click', '.delete-item', function () {
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
            url: "<?php echo base_url('item/delete') ?>",
            data: {
              id: itemId,
              gambar: image
            },
            success: function(data){
              var res = JSON.parse(data);
              if(res.status == true){
                $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('item/delete_menu_item') ?>",
                  data: {
                    id: itemId,
                  },
                  success: function(data){
                    var res = JSON.parse(data);
                    if(res.status == true){
                      swal("Data Berhasil Dihapus!","Hapus Data Sukses","success")
                      .then((value) => {
                        location.reload();
                      });
                    }else{
                      swal("Hapus Data Gagal!","Silahkan Coba Beberapa Saat Lagi","error")
                      .then((value) => {
                        location.reload();
                      });
                    }
                  }
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