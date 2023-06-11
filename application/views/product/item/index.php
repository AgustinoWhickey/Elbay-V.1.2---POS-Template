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
  
    
  var edit = false;
  var alertText = '';

  $('#add').on('click',function(){
    $('#name').val('');
    $('#barcode').val('');
    $('#kategori').val('');
    $('#harga').val('');
    $('#image').val('');
    $('#id').val('');

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
          edit = true;
          console.log(data);
          // $('#name').val(data.name);
          // $('#id').val(data.id);
          // $('#image').val(data.image);
          // $('#unit').val(data.unit);
          // $('#unit_price').val(data.unit_price);
          // $('#stock').val(data.stock);
        }
    });
  });

  $('#bahan1').select2();
  $('#bahan1').on('change', function(e){
    alert('ahha');
  });

  $("#namabahan").change(function(){ 
      var element = $(this).find('option:selected'); 
      var myTag = element.attr("desc");

      $('#selectedbahan').val(myTag); 
  }); 

  $(document).on("click","#submitmenu",function() {
    alertText = 'Tambah';
    const items = {};
    $("#tablebahan > tbody > tr").each(function () {
      items[$(this).find('td').eq(3).find('input').val()] = $(this).find('td').eq(2).text();
    });
    event.preventDefault();
    var nama = $('#nama').val();
    var barcode = $('#barcode').val();
    var kategori = $('#kategori').val();
    var harga = $('#harga').val();
    var image = $('#image').prop('files')[0];

    var form_data = new FormData();
    form_data.append('nama', nama);
    form_data.append('barcode', barcode);
    form_data.append('kategori', kategori);
    form_data.append('harga', harga);
    form_data.append('image', image);
    form_data.append('items', JSON.stringify(items));
      if(nama == '' && barcode == ''){
      alert('Masukkan Nama Item atau Barcode terlebih dahulu!');
    } else {
      $.ajax({
          url: "<?php echo base_url('item/input') ?>", 
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
              url: "<?php echo base_url('item/input_menu_item') ?>",
              data: {
                product: result.data,
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

  // $(document).on("click","#submitmenu",function() {
  //   event.preventDefault();
  //   var nama = $('#name').val();
  //   var barcode = $('#barcode').val();
  //   var kategori = $('#kategori').val();
  //   var harga = $('#harga').val();
  //   if(nama == '' && barcode == ''){
  //     alert('Masukkan Nama Item atau Barcode terlebih dahulu!');
  //   } else {
  //     // $("#tablebahan > tbody > tr").each(function () {
  //     //   console.log($(this).find('td').eq(1).text() + " " + $(this).find('td').eq(2).text() );
  //     // });
  //     $('form#menuform').submit();
  //     // $.ajax({
  //     //   type: "POST",
  //     //   url: "<?php echo base_url('item/input') ?>",
  //     //   data: {
  //     //     nama: nama,
  //     //     barcode: barcode,
  //     //     kategori: kategori,
  //     //     harga: harga
  //     //  },
  //     //   success: function(data){
  //     //     var res = JSON.parse(data);
  //     //     console.log(res);
  //     //   }
  //     // });
  //   }
  // });

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
      alert('Pilih bahan dan masukkan quantity terlebih dahulu!');
    }
  });

  $("#tablebahan").on('click', '#deletebahan', function () {
    $(this).closest('tr').remove();
  });
});
</script>