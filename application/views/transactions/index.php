
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
		Chi tiết giao dịch
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Transactions</li>
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
							<input class="form-control" name="fromDate" type="text" value="<?php if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])){ echo $_POST['fromDate'];}else{echo $_SESSION['storeValues'][2];} ?>" id="datepicker" autocomplete="off">
						</div>
						
						<label class="col-sm-1 control-label">Todate</label>
						<div class="col-sm-3">
							<input class="form-control" name="toDate" type="text" value="<?php if(isset($_POST['toDate']) && !empty($_POST['toDate'])){echo $_POST['toDate'];}else{echo $_SESSION['storeValues'][3];} ?>" id="datepicker1" autocomplete="off">
						</div>
						
						<label class="col-sm-1 control-label">Partner username</label>
						<div class="col-sm-3">
							<select class="form-control" name="partner_id" >
								<option value="">All</option>
								<?php foreach($list_partner as $partner): ?>
								<option value="<?php echo $partner->partner_id; ?>"><?php echo $partner->partner_username ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label">Reqid</label>
						<div class="col-sm-3">
							<input class="form-control" name="requestId" type="text" value="<?php if(isset($_POST['requestId'])){echo $_POST['requestId'];}else{echo $_SESSION['storeValues'][1];} ?>">
						</div>
						
						<label class="col-sm-1 control-label">Serial</label>
						<div class="col-sm-3">
							<input class="form-control" name="serial" type="text" value="<?php if(isset($_POST['serial'])){echo $_POST['serial'];}else{echo $_SESSION['storeValues'][4];} ?>">
						</div>
						
						<label class="col-sm-1 control-label">Status</label>
						<div class="col-sm-3">
							<select class="form-control" name="slFinalStatus">
								<option value="" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "0" ? "selected" : "" ?>>Chọn trạng thái</option> 
								<option value="00" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "00" ? "selected" : "" ?>>Thành công</option>
								<option value="99" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "99" ? "selected" : "" ?>>Pending</option>
								<option value="-1" <?php echo isset($_POST["slFinalStatus"]) && $_POST["slFinalStatus"] == "-1" ? "selected" : "" ?>>Thất bại</option>
							</select>
						</div>
					</div>
				
				<input class="btn btn-primary" type="submit" name="submit" value='Tìm kiếm' class="button">
				<input class="btn btn-success" type="submit" name="submit_checkpending" value="Re-Checkpending" class="button">
				</form>
			</div>
			<div class="box-body">
				<?php if (isset($results)) { ?>
					<table id="manageTable" class="table table-bordered table-striped" style="width: 100%;display: block;overflow-x: auto;white-space: nowrap;">
						<thead>
							<tr>
								<th>Request Id</th>
								<th>Username</th>
								<th>Card Seri</th>
								<th>Card Pin</th>
								<th>Status</th>
								<th>Provider</th>
								<th>Received date</th>
								<th>Response date</th>
								<th>Telco Stt</th>
								<th>Message</th>
								<th>Amount</th>
								<th>Print Amount</th>
								<th>Chk_Pdtime</th>
								<th>Update pending</th>
								<th>P Id</th>
								<th>TelcoRqId</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($results as $data) { ?>
								<tr>
									<td><?php echo $data->request_id ?></td>
									<td><?php echo $data->partner_username ?></td>
									<td><?php echo $data->card_serial ?></td>
									<td><?php echo $data->card_pin ?></td>
									<td><?php echo $data->final_status ?></td>
									<td><?php echo $data->provider_code ?></td>
									<td><?php echo $data->receive_date ?></td>
									<td><?php echo $data->response_date ?></td>
									<td><?php echo $data->provider_status ?></td>
									<td><?php echo $data->provider_message ?></td>
									<td><?php echo $data->response_amount ?></td>
									<td><?php echo $data->post_amount ?></td>
									<td><?php echo $data->check_pending_time ?></td>
									<td><?php echo $data->update_date ?></td>
									<td><?php echo $data->partner_id ?></td>
									<td><?php echo $data->request_id_telco ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<div>No data found.</div>
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
	fromDate.setDate(fromDate.getDate() - 2);
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
	
  } );

</script>
