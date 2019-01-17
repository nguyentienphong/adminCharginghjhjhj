
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
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
					  Dùng đơn hàng
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							Bạn có chắc chắn muốn dừng đơn hàng <b><?php echo $order_info->order_name; ?></b>
						  </div>
						  <div class="modal-footer">
							<form action="<?php echo base_url('Controller_Order_Manager/stop_order/') . $order_info->order_id; ?>" method="post">
								<button class="btn btn-secondary btn-sm " data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-danger" value="approve">Xác nhận</button>
							</form>
						  </div>
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
