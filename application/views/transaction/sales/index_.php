  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Proses Pemesanan</h6>
      </div>
      <div class="card-body">
      <section class="content">
        <div class="row">
          <div class="col-12 products">
            <div class="col-12 col-sm-12">
              <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                  <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="semua" data-toggle="pill" href="#semua" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                    </li>
                    <?php foreach($category as $cat){ ?>
                      <li class="nav-item">
                        <a class="nav-link" id="<?= $cat->nama; ?>" id-cat="<?= $cat->id; ?>" data-toggle="pill" href="#<?= $cat->nama; ?>" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true"><?= $cat->nama;?></a>
                      </li>
                    <?php } ?>
                  </ul>
                </div>
                <div class="card-body" style="overflow-y: scroll;height:600px;">
                  <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                      <div class="container">
                        <div id="prod-content" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-6">
                        <?php foreach($items as $item){ ?>
                          <div class="col mb-5">
                            <a href="#" id="item" stock="<?= $item->stock; ?>" iditem="<?= $item->id; ?>" product="<?= $item->name; ?>" price="<?= $item->price; ?>">
                              <div class="card h-100">
                                <?php if($item->image != '') { ?>
                                  <img class="card-img-top" src="<?= base_url('assets/img/upload/products/'.$item->image); ?>" alt="..." />
                                <?php } else { ?>
                                  <img class="card-img-top" src="<?= base_url('assets/img/upload/products/default-product-img.jpg'); ?>" alt="..." />
                                <?php } ?>
                                <div class="card-body p-4">
                                      <div class="text-center">
                                          <h5 class="fw-bolder"><?= $item->name; ?></h5>
                                          <?= indo_currency($item->price); ?>
                                      </div>
                                  </div>
                              </div>
                            </a>
                          </div>
                        <?php } ?>
                  </div>
              </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <div class="col-4 order" style="display: none;">
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Products</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Harga</th>
                    <th>Hapus</th>
                  </tr>
                  </thead>
                </table>
                <table id="cart_table" class="table table-striped table-valign-middle detail-order">
                  <tbody>
                  </tbody>
                  <tfoot class="table-active">
                    <tr>
                      <td colspan="2">Total</td>
                      <td id="grand_total"></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-info float-right" id="proses" data-toggle="modal" data-target="#newUserModal"> Proses</button>
              </div>
            </div>
          </div>
        </div>
    </section>

      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Detail Pesanan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
				<div class="modal-body">
					<div class="form-group">
            			<label>Total: </label>
						<input type="text" class="form-control" id="inputtotal" name="total" disabled>
					</div>
					<div class="form-group">
						<label>Discount: </label>
						<input type="text" class="form-control" id="diskon" name="diskon" value="0">
					</div>
          		<div class="form-group">
           		 	<label>Cash: </label>
            <input type="text" class="form-control" id="cash" name="cash" value="0">
					</div>
          <div class="form-group">
            			<label>Kembalian: </label>
						<input type="text" class="form-control" id="change" name="change" disabled>
					</div>
					<div class="form-group">
           		 		<label>Note: </label>
						<textarea class="form-control" id="note" name="note"></textarea> 
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" id="process_payment">Tambah</button>
				</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {

      $("#proses").click(function(event){
        var total = $('#grand_total').text();

        $('#inputtotal').val(total);
      }); 

      $(document).on('keyup', '#cash', function() {
        var total = $('#inputtotal').val();
        var diskon = $('#diskon').val();
        var cash = $(this).val();
        var kembalian = cash - (total - diskon);
        $('#change').val(kembalian);
      });

      $(".nav-item a").click(function(event){
        var tabid = $(this).attr('id-cat');
        $.ajax({
          url: "<?= base_url('item/get_product_by_category'); ?>",
          type: 'post',
          data: {
            idcat: tabid,
          },
          success: function(data){
            $('#prod-content').html(data);
          }
        });
      });

      $(document).on('change', '#cart_table #cart_qty', function() {
        var qty = parseInt($(this).val());
        var price = parseInt($(this).attr('price'));
        var stock = parseInt($(this).attr('stock'));
        var product = $(this).attr('product');
        var newtotal = parseInt(qty) * parseInt(price);
        if(qty > stock){
          Swal.fire({
            icon: 'warning',
            title: 'Stock '+product+' kurang dari jumlah pesanan',
            text: 'Silahkan input sesuai stock',
            timer: 2000,
          });
          $(this).val(1);
        }
        $(this).parent().parent().find('#total').text(newtotal);
        calculate();
      });

      $(document).on('click', '.row #item', function() {
        $('.products').removeClass('col-12');
        $('.products').addClass('col-8');
        $('#prod-content').removeClass('row-cols-xl-6');
        $('#prod-content').addClass('row-cols-xl-4');
        $('.order').show();
        
        var product = $(this).attr('product');
        var price = $(this).attr('price');
        var stock = $(this).attr('stock');
        var iditem = $(this).attr('iditem');
        $('.detail-order tbody').after('<tr><td>'+product+'</td><td><input id="cart_qty" iditem="'+iditem+'" product="'+product+'" stock="'+stock+'" price="'+price+'" type="number" value="1" style="width:65px"></td><td id="total">'+price+'</td><td><button id="del_cart" type="button" class="btn btn-danger float-right"><i class="fas fa-trash"></i></button></td></tr>');
        calculate();
      });

      $(document).on('click', '#add_cart', function() {
        var item_id = $('#item_id').val();
        var price = $('#price').val();
        var stock = $('#stock').val();
        var qty = $('#qty').val();
        var qty_cart = $('#qty_cart').val();
        if(item_id == ''){
          Swal.fire({
            icon: 'warning',
            title: 'Produk belum dipilih',
            text: 'Silahkan pilih produk terlebih dahulu',
            timer: 1500,
          });
          $('#barcode').focus();
        } else if(stock < 1 || parseInt(stock) < (parseInt(qty_cart) + parseInt(qty))){
          Swal.fire({
            icon: 'warning',
            title: 'Stock tidak mencukupi',
            text: 'Silahkan cek stock produk terlebih dahulu',
            timer: 1500,
          });
          $('#item_id').val('');
          $('#barcode').val('');
          $('#barcode').focus();
        } else {
          $.ajax({
            type: 'POST',
            url: '<?= site_url('sale/proses') ?>',
            data: {'add_cart': true, 'item_id':item_id, 'price': price, 'qty':qty},
            dataType: 'json',
            success: function(result){
              if(result == 1){
                $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function(){
                  calculate();
                  $('#item_id').val('');
                  $('#barcode').val('');
                  $('#barcode').focus();
                  $('#qty').val(1);
                });
              }else {
                Swal.fire({
                  icon: 'error',
                  title: 'Tambah cart gagal!',
                  text: 'Silahkan Coba Beberapa Saat Lagi',
                  timer: 2000,
                });
              }
            }
          });
        }
      });

      $(document).on('click', '#del_cart', function() {
        $(this).closest('tr').remove();
      });

      function calculate(){
        var subtotal = 0;
        var qtycart = 0;
        $('#cart_table tr').each(function() {
          if($(this).find('#total').text().length > 0){
            subtotal += parseInt($(this).find('#total').text());
          }
        });
        isNaN(subtotal) ? $('#grand_total').text(0) : $('#grand_total').text(subtotal);
      }

      $(document).on('keyup mouseup', '#discount, #cash', function(){
        calculate();
      });

      $(document).on('click', '#process_payment', function(){
        var discount = $('#diskon').val();
        var grandtotal = $('#inputtotal').val();
        var cash = $('#cash').val();
        var change = $('#change').val();
        var note = $('#note').val();

        $('#cart_table tr').each(function() {
          if($(this).find('#cart_qty').attr('product') != undefined){
            $.ajax({
              type: 'POST',
              url: '<?= site_url('sale/addcart') ?>',
              data: {
                item_id: $(this).find('#cart_qty').attr('iditem'),
                price: $(this).find('#cart_qty').attr('price'),
                qty: $(this).find('#cart_qty').val()
              },
              success: function(data){
                var res = JSON.parse(data);
                if(res.status == true){
                  if(cash < 1){
                    Swal.fire({
                      icon: 'warning',
                      title: 'Jumlah uang cash belum diinput!',
                      text: 'Silahkan input uang cash',
                      timer: 2000,
                    });
                  } else {
                    Swal.fire({
                    title: "Anda yakin ingin memproses transaksi ini?",
                    text: "Jika sudah diproses, transaksi tidak akan bisa dikembalikan",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willProcess)=>{
                    if(willProcess){
                      $.ajax({
                        type: 'POST',
                        url: '<?= site_url('sale/add_sale')?>',
                        data: {
                          discount: discount,
                          grandtotal: grandtotal,
                          cash: cash,
                          change: change,
                          note: note
                        },
                        success: function(result){
                          var res = JSON.parse(result);
                          if(res.status == true){
                            $.ajax({
                              url: "<?= base_url('sale/process_payment'); ?>",
                              type: 'post',
                              data: {
                                saleid: res.data,
                              },
                              success: function(data){
                                Swal.fire({
                                  icon: 'success',
                                  title: 'Transaksi Berhasil!',
                                  text: 'Transaksi Telah Diproses',
                                  timer: 2000,
                                  showConfirmButton: false 
                                })
                                .then((value) => {
                                  window.open('<?= site_url('sale/cetak/')?>' + res.data, '_blank');
                                });
                              }
                            });
                          } else {
                            Swal.fire({
                              icon: 'error',
                              title: 'Transaksi gagal!',
                              text: 'Silahkan Cek Data Transaksi Lagi',
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
                  }
                }else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Tambah cart gagal!',
                    text: 'Silahkan Coba Beberapa Saat Lagi',
                    timer: 2000,
                  });
                }
              }
            });
          }
        });
      });
    });
</script>