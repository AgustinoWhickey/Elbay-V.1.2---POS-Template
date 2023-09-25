  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Elbay Software <?= date('Y',$user['date_created']); ?></span>
      </div>
    </div>
  </footer>

   </div>

 </div>

 <a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
         <button class="close" type="button" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
         </button>
       </div>
       <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
       <div class="modal-footer">
         <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
         <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
       </div>
     </div>
   </div>
 </div>

 <?php
 $tgl_penjualan=array();
 $tgl_pengeluaran=array();
 $tanggal=array();
 $terjual=array();
 $pengeluaran=array();
 $output=array();
 if(isset($chart_year)){
   $months =["January","February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
   foreach($chart as $val) {
     array_push($tgl_penjualan, $val->tgl);
     array_push($terjual, $val->total_penjualan);
   }
   foreach($chart2 as $val) {
     array_push($tgl_pengeluaran, $val->tgl);
     array_push($pengeluaran, $val->total_pengeluaran);
   }
   $output = array_values(array_unique(array_merge($tgl_penjualan, $tgl_pengeluaran)));

    usort( $output , function($a, $b){
      $monthA = date_parse($a);
      $monthB = date_parse($b);

      return $monthA["month"] - $monthB["month"];
   });
 } else {
   foreach($chart as $val) {
     array_push($tgl_penjualan, date('d M',$val->date));
     array_push($terjual, $val->total_penjualan);
   }
   foreach($chart2 as $val) {
     array_push($tgl_pengeluaran, date('d M',$val->created));
     array_push($pengeluaran, $val->total_pengeluaran);
   }
   $output =array_unique(array_merge($tgl_penjualan, $tgl_pengeluaran));
 }
 $listbarang = json_encode($output);
 $listterjual = json_encode($terjual);
 $listpengeluaran = json_encode($pengeluaran);
 ?> 
 
 <script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

 <script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

 <script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
 
 <script>
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
 // *     example: number_format(1234.56, 2, ',', ' ');
 // *     return: '1 234,56'
 number = (number + '').replace(',', '').replace(' ', '');
 var n = !isFinite(+number) ? 0 : +number,
   prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
   sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
   dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
   s = '',
   toFixedFix = function(n, prec) {
     var k = Math.pow(10, prec);
     return '' + Math.round(n * k) / k;
   };
 // Fix for IE parseFloat(0.55).toFixed(0) = 0;
 s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
 if (s[0].length > 3) {
   s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
 }
 if ((s[1] || '').length < prec) {
   s[1] = s[1] || '';
   s[1] += new Array(prec - s[1].length + 1).join('0');
 }
 return s.join(dec);
}

var list = <?=$listbarang?>;
var terjual = <?=$listterjual?>;
var pengeluaran = <?=$listpengeluaran?>;
console.log(list);
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
 type: 'line',
 data: {
   labels: 
     list
   ,
   datasets: [{
     label: "Penjualan",
     lineTension: 0.3,
     backgroundColor: "rgba(78, 115, 223, 0.05)",
     borderColor: "rgba(78, 115, 223, 1)",
     pointRadius: 3,
     pointBackgroundColor: "rgba(78, 115, 223, 1)",
     pointBorderColor: "rgba(78, 115, 223, 1)",
     pointHoverRadius: 3,
     pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
     pointHoverBorderColor: "rgba(78, 115, 223, 1)",
     pointHitRadius: 10,
     pointBorderWidth: 2,
     data: terjual,
   },{
     label: "Pengeluaran",
     lineTension: 0.3,
     backgroundColor: "rgba(204,0,51,0.1)",
     borderColor: "rgba(204, 115, 223, 1)",
     pointRadius: 3,
     pointBackgroundColor: "rgba(204, 115, 223, 1)",
     pointBorderColor: "rgba(204,0,51,1)",
     pointHoverRadius: 3,
     pointHoverBackgroundColor: "rgba(204,0,51,1)",
     pointHoverBorderColor: "rgba(204,0,51,1)",
     pointHitRadius: 10,
     pointBorderWidth: 2,
     data: pengeluaran,
   },],
 },
 options: {
   maintainAspectRatio: false,
   layout: {
     padding: {
       left: 10,
       right: 25,
       top: 25,
       bottom: 0
     }
   },
   scales: {
     xAxes: [{
       time: {
         unit: 'date'
       },
       gridLines: {
         display: false,
         drawBorder: false
       },
       ticks: {
         maxTicksLimit: 7
       }
     }],
     yAxes: [{
       ticks: {
         maxTicksLimit: 5,
         padding: 10,
         // Include a dollar sign in the ticks
         callback: function(value, index, values) {
           return number_format(value);
         }
       },
       gridLines: {
         color: "rgb(234, 236, 244)",
         zeroLineColor: "rgb(234, 236, 244)",
         drawBorder: false,
         borderDash: [2],
         zeroLineBorderDash: [2]
       }
     }],
   },
   legend: {
     display: false
   },
   tooltips: {
     backgroundColor: "rgb(255,255,255)",
     bodyFontColor: "#858796",
     titleMarginBottom: 10,
     titleFontColor: '#6e707e',
     titleFontSize: 14,
     borderColor: '#dddfeb',
     borderWidth: 1,
     xPadding: 15,
     yPadding: 15,
     displayColors: false,
     intersect: false,
     mode: 'index',
     caretPadding: 10,
     callbacks: {
       label: function(tooltipItem, chart) {
         var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
         return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' ';
       }
     }
   }
 }
});

 </script>

 <script>
   $('.custom-file-input').on('change',function(){
     let filename = $(this).val().split('\\').pop();
     $(this).next('.custom-file-label').addClass('selected').html(filename);
   });

   $('.form-check-input').on('click',function(){
     const menuId = $(this).data('menu');
     const roleId = $(this).data('role');

     $.ajax({
       url: "<?= base_url('admin/changeaccess'); ?>",
       type: 'post',
       data: {
         menuId: menuId,
         roleId: roleId
       },
       success: function(){
         document.location.href = "<?= base_url('admin/roleaccess/'); ?>"+roleId
       }
     });
   });

   $('#logout').on('click',function(){
    Swal.fire({
      title: "Anda yakin ingin logout?",
      text: "Anda akan diarahkan ke halaman login",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willLogout)=>{
      if(willLogout){
        document.location.href = '<?php echo base_url('auth/logout') ?>';
      }else{
        Swal.fire({
					icon: 'warning',
					title: 'Anda Memilih Tidak Logout!',
					text: 'Tidak Jadi Logout',
					timer: 2000,
					showConfirmButton: false 
				});
      }
    });
   });
 </script>

</body>

</html>
