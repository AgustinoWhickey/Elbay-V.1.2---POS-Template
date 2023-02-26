<div class="container">
	<div class="row mt-3">
		<div class="col-md-6">
			<?php if($this->session->flashdata()) : ?>
				<?= $this->session->flashdata('message'); ?>
			<?php endif; ?>
			<a href="<?= base_url('forum/tambahkategori'); ?>" class="btn btn-primary">
				Add Data Kategori Forum
			</a>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-6">
			<?php foreach ($allkategori as $allkat){ ?>
				<h4><?= $allkat['nama_kategori']; ?></h4>
				<?php foreach ($topik as $tpk){ ?>
					<?php if($allkat['id'] == $tpk['id_kategori']){ ?>
						<div class="card-body">
			                <?= $tpk['subjek']; ?>
				                <hr>
				                <div class="comment-card">
				                	<?php foreach ($tanggapan as $tgp){ ?>
		                				<?php if($tpk['id'] == $tgp['id_topik']){ ?>
						                	<small class="comment-item text-muted">
						                		<p class="mb-2">
						                			<?= $tgp['tgl_tanggapan']; ?> 
						                		</p>
						                		<p><?= $tgp['isi_tanggapan']; ?> </p> 
						                	</small>
						                	<hr>
						            	<?php } ?>
			            			<?php } ?>
			                		<div class="form-group mb-0">
			                		<a href="#" class="btn btn-info btn-sm ml-0 comment-form-toggle show_login waves-effect waves-light" data-toggle="modal" id="comment" topikid="<?= $tpk['id']; ?>" data-target="#newAddCommentLabel">Add comment</a>
			                	</div>
			                </div>
			            </div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<div class="modal fade" id="newAddCommentLabel" tabindex="-1" role="dialog" aria-labelledby="newAddCommentLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Add Comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('forum/tambah_tanggapan'); ?>" method="post">
				<div class="modal-body">
					<input type="hidden" name="topikid" id="topikid">
					<div class="form-group">
						<textarea class="form-control" name="tanggapan" id="tanggapan"></textarea> 
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.comment-card #comment').on('click',function(){
			var topikid = $(this).attr('topikid');
			$('#topikid').val(topikid);
		});
	});
</script>