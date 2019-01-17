
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Order Detail
  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Manage Order</li>
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

        <!--div class="box"-->
			<div class="box box-info">
			
				<div class="box-header with-border">
					<div class="row">
						<div class="col-md-3">
							<div class="callout callout-info">
								<h4>Order Name</h4>
								<p><?php echo $order_info->order_name; ?></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="callout callout-success">
								<h4>Total Amount</h4>
								<p><?php echo number_format($order_info->order_total_amount); ?></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="callout callout-warning">
								<h4>Total Quantity</h4>
								<p><?php echo number_format($order_info->order_total_quantity); ?></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="callout callout-info">
								<h4>Charged Success Amount</h4>
								<p><?php echo number_format($data->charged_success_amt) ?></p>
							</div>
						</div>
					</div>
				</div>
				
				<div class="box-body">
					<div class="col-sm-12" style="overflow-x: auto;">
						<table id="manageTable" class="table table-bordered table-hover" style="width: 100%;overflow-x: auto;white-space: nowrap;">
							<thead>
								<tr>
									<th>Phone Number</th>
									<th>Expect Amount</th>
									<th>Payment Status</th>
									<th>Created Date</th>
									<th>Charged Amount</th>
									<th>Payment Message</th>
									<th>Charge Type</th>
								</tr>
							</thead>
							
							<tbody>
								<?php foreach ($list_order_detail as $order_detail) { ?>
								<tr>
									<td><?php echo $order_detail->phone_number ?></td>
									<td style="text-align: right;"><?php echo number_format($order_detail->expect_amount) ?></td>
									<td><?php echo $order_detail->payment_status ?></td>
									<td><?php echo $order_detail->created_date ?></td>
									<td style="text-align: right;"><?php echo number_format($order_detail->charged_amount) ?></td>
									<td><?php echo $order_detail->payment_message ?></td>
									<td><?php echo $order_detail->charge_type ?></td>
									
								</tr>
								<?php } ?>
							</tbody>
							
						</table>
					</div>
				</div>
			
            </div>
        <!--/div-->
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
	$('#manageTable').DataTable({
	  "searching": false,
	  "info": false
	});
  } );


</script>
