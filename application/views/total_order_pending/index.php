
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
		Total Order Pending
  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Total Order Pending</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>
		<div class="box box-info">
			<div class="box-header with-border">
				<form class="form-horizontal" action="" method="post" >
					
					<!--div class="form-group">
						<label class="col-sm-1 control-label">Fromdate</label>
						<div class="col-sm-3">
							<input class="form-control" name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} ?>" id="datepicker" autocomplete="off">
						</div>
						
						<label class="col-sm-1 control-label">Todate</label>
						<div class="col-sm-3">
							<input class="form-control" name="toDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['toDate'];} ?>" id="datepicker1" autocomplete="off">
						</div>
					</div-->
					
					<!--div class="form-group">
						<label class="col-sm-1 control-label">Provider</label>
						<div class="col-sm-3">
							<select class="form-control" name="Provider">
								<option value="">Chọn đối tác</option>
								<?php if(!empty($list_provider)): ?>
									<?php foreach($list_provider as $provider): ?>
									<option value="<?php echo $provider->provider_shortcode; ?>" <?php echo set_select('Provider', $provider->provider_shortcode); ?>>
										<?php echo $provider->provider_fullname ?>
									</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
						
						<label class="col-sm-1 control-label">Partner</label>
						<div class="col-sm-3">
							<select class="form-control" name="partner_id">
								<option value="">Chọn Partner</option>
								<?php if(!empty($list_partner)): ?>
									<?php foreach($list_partner as $partner): ?>
									<option value="<?php echo $partner->partner_id; ?>" <?php echo set_select('partner_id', $partner->partner_id); ?>>
										<?php echo $partner->partner_username ?>
									</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div-->
				
					<!--input class="btn btn-primary" type="submit" value="Search" text="Search"-->
				</form>
			</div>
        
			<div class="box-body">
				<?php if (isset($results)) { ?>
					<?php if(isset($results['KH']) && $results['KH']): ?>
						<h3 class="box-title">Đơn hàng khớp thẻ</h3>
						<table id="manageTable" class="table table-bordered table-striped" style="width: 100%;overflow-x: auto;white-space: nowrap;">
							<thead>
								<tr>
									<th>Total Pending Amount</th>
									<th>Order Name</th>
									<th>Provider</th>
								</tr>
							</thead> 
							<tbody>
								<?php foreach($results['KH'] as $char_pending): ?>
									<tr>
										<td><?php echo number_format($char_pending->total_pendingamount) ?></td>
										<td><?php echo $char_pending->order_name ?></td>
										<td><?php echo $char_pending->provider_code ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
					<?php if(isset($results['TU']) && $results['TU']): ?>
						<h3 class="box-title">Đơn hàng TOPUP</h3>
						<table id="manageTable" class="table table-bordered table-striped" style="width: 100%;overflow-x: auto;white-space: nowrap;">
							<thead>
								<tr>
									<th>Total Pending Amount</th>
									<th>Order Name</th>
									<th>Provider</th>
								</tr>
							</thead> 
							<tbody>
								<?php foreach($results['TU'] as $topup_penindg): ?>
									<tr>
										<td><?php echo number_format($topup_penindg->total_pendingamount) ?></td>
										<td><?php echo $topup_penindg->order_name ?></td>
										<td><?php echo $topup_penindg->provider_code ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				<?php } else { ?>
					<div>No data found.</div>
				<?php } ?>
				<?php if (isset($links)) { ?>
					<?php echo $links ?>
				<?php } ?>
            </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
$( function() {
    $( "#datepicker" ).datepicker({ format: 'yyyy-mm-dd', todayHighlight: true, autoclose: true });
  
    $( "#datepicker1" ).datepicker({ format: 'yyyy-mm-dd', todayHighlight: true, autoclose: true });
  } );

</script>
