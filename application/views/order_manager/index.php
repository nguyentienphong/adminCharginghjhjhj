
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Partners Orders
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
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
				<form class="form-horizontal" name="inputform" action="" method="post" >
					<div class="form-group">
						<label class="col-sm-1 control-label">Fromdate</label>
						<div class="col-sm-3">
							<input class="form-control" name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} ?>" id="datepicker" autocomplete="off">
						</div>
						
						<label class="col-sm-1 control-label">Todate</label>
						<div class="col-sm-3">
							<input class="form-control" name="toDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['toDate'];} ?>" id="datepicker1" autocomplete="off">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-1 control-label">Trạng thái đơn hàng</label>
						<div class="col-sm-3">
							<select class="form-control" name="order_status" >
								<option value="">All</option>
								<option value="">Đang chạy</option>
								<option value="">Tạm dừng</option>
								<option value="">Dừng</option>
								<option value="">Hủy</option>
							</select>
						</div>
						
						<label class="col-sm-1 control-label">Partner</label>
						<div class="col-sm-3">
							<select class="form-control" name="partner_id" >
								<option value="">All</option>
								<?php foreach($list_partner as $partner): ?>
								<option value="<?php echo $partner->partner_id; ?>"><?php echo $partner->partner_username ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<input class="btn btn-primary" type="submit" value="Search" text="Tìm kiếm">
					
					<a href="<?php echo base_url('Controller_Order_Manager/create') ?>" class="btn btn-success">Add New</a>
						
				</form>
			</div>
        <div class="box-body">
            <?php if (isset($results)) { ?>
                <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;overflow-x: auto;white-space: nowrap;">
					<thead>
						<tr>
							<th>Order Id</th>
							<th>Order Name</th>
							<th>Provider</th>
							<th>Created Date</th>
							<th>Expire Date</th>
							<th>Order Status</th>
							<th>Total Amt</th>
							<th>Quantity</th>
							<th>Stop date</th>
							<th></th>
						</tr>
                    </thead>
					<tbody>
                    <?php foreach ($results as $data) { ?>
                        <tr>
                            <td><?php echo $data->order_id ?></td>
                            <td><a href="<?php echo base_url('Controller_Order_Manager/detail/') . $data->order_id; ?>"><?php echo $data->order_name ?></a></td>
                            <td><?php echo $data->provider_code ?></td>
                            <td><?php echo $data->order_created_date ?></td>
                            <td><?php echo $data->order_expire_date ?></td>
                            <td><?php echo $data->order_status ?></td>
                            <td><?php echo number_format($data->order_total_amount) ?></td>
                            <td><?php echo $data->order_total_quantity ?></td>
                            <td><?php echo $data->stopup_date ?></td>
                            <td>
								<a href="<?php echo base_url('Controller_Order_Manager/detail/') . $data->order_id; ?>" class="btn btn-success btn-sm ">Chi tiết</a>
								<a href="<?php echo base_url('Controller_Order_Manager/stop_order/') . $data->order_id; ?>" class="btn btn-danger btn-sm ">Dừng đơn hàng</a>
							</td>
                        </tr>
                    <?php } ?>
					</tbody>
                </table>
                
            <?php } else { ?>
                <div>No trans(s) found.</div>
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
	
	$('#manageTable').DataTable({
	  "searching": false,
	  "info": false
	});
	
    $( "#datepicker" ).datepicker({ format: 'dd-mm-yyyy', todayHighlight: true, autoclose: true });

    $( "#datepicker1" ).datepicker({ format: 'dd-mm-yyyy', todayHighlight: true, autoclose: true });
	
	var fromDate = new Date();
	fromDate.setDate(fromDate.getDate() - 30);
	var fromDay = fromDate.getDate();
	var fromMonth = fromDate.getMonth() + 1;
	if (fromDay < 10) {
		fromDay = '0' + fromDay;
	}
	if(fromMonth < 10){
		fromMonth = '0' + fromMonth;
	}
	if($( "#datepicker" ).val() == ''){
		$('#datepicker').val((fromDay) + '-' + fromMonth + '-' + fromDate.getFullYear());
	}
	
	var today = new Date();
	var month = today.getMonth() + 1;
	var date = today.getDate();
	
	if (date < 10) {
		date = '0' + date;
	}
	if(month < 10){
		month = '0' + month;
	}
	if($( "#datepicker1" ).val() == ''){
		$('#datepicker1').val(date + '-' + month + '-' + today.getFullYear());
	}
});


</script>
