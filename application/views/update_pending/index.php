
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Update Pending
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
							
						<label class="col-sm-1 control-label">Request id</label>
						<div class="col-sm-3">
							<input class="form-control" name="request_id" type="text" value="<?php if(isset($_POST['request_id'])){echo $_POST['request_id'];} ?>">
						</div>
					</div>
					<input class="btn btn-primary" type="submit" value="Search" text="Search">
					
					<!--a href="<?php echo base_url('Controller_Order_Manager/create') ?>" class="btn btn-success">Add New</a-->
						
				</form>
			</div>
        <div class="box-body">
            <?php if (isset($results)) { ?>
                <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;overflow-x: auto;white-space: nowrap;">
                    <tr>
						<th>Reuest Id</th>
						<th>Reuest Status</th>
						<th>Final status</th>
						<th>Provider code</th>
						<th>Partner Username</th>
						<th>Check pending time</th>
						<th>Post amount</th>
						<th>Real amount</th>
						<th>Receive Date</th>
						<th>Target Account</th>
						<th></th>
                    </tr>
                     
                    <?php foreach ($results as $data) { ?>
                        <tr>
                            <td><?php echo $data->request_id ?></td>
                            <td><?php echo $data->request_status ?></td>
                            <td><?php echo $data->final_status ?></td>
                            <td><?php echo $data->provider_code ?></td>
                            <td><?php echo $data->partner_username ?></td>
                            <td><?php echo $data->check_pending_time ?></td>
                            <td><?php echo number_format($data->post_amount) ?></td>
                            <td><?php echo number_format($data->real_amount) ?></td>
                            <td><?php echo $data->receive_date ?></td>
                            <td><?php echo $data->target_account ?></td>
							<td><a class="btn btn-warning" href="<?php echo base_url('Controller_Update_Pending/Update_Pending/') . $data->request_id; ?>">Update</a></td>
                        </tr>
                    <?php } ?>
                </table>
                <!--div>Total Amount: <?php echo number_format($totalAmount)?></div-->
            <?php } else { ?>
                <div>No trans(s) found.</div>
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
    $( "#datepicker" ).datepicker({ format: 'dd-mm-yyyy', todayHighlight: true, autoclose: true });
  
    $( "#datepicker1" ).datepicker({ format: 'dd-mm-yyyy', todayHighlight: true, autoclose: true });
	
	
	var fromDate = new Date();
	fromDate.setDate(fromDate.getDate() - 1);
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
	
	$('#manageTable').DataTable({     

      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 5
       });
	
  } );


</script>
