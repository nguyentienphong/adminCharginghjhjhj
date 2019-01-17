

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add New Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">O</li>
      </ol>
    </section>
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-info">
        <!--div class="box-header with-border">

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div-->
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
        <div class="col-md-12 col-xs-12">
          
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

         
            <form class="form-horizontal" role="form" action="<?php base_url('Controller_Order_Manager/create') ?>" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                <div class="row">
					<div class="form-group">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-sm-2 control-label">Order file(.xlsx)</label>
								Select Excel file:
								<input type="file" name="fileToUpload" id="fileToUpload">
								<!--div class="offset-sm-2" style="margin-left: 170px;">
									<input class="btn btn-success " type="submit" value="Upload Order" name="submit">
								</div-->
								<input type="hidden" name="uploadSuc" id="uploadSuc"  value="<?php if(isset($_POST['uploadSuc'])){echo $_POST['uploadSuc'];}else{echo $upload_file;} ?>"/>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-4">
							<label class="col-sm-2 control-label" for="partner_name">Partner</label>
							<select class="form-control" id="partner_name" name="partner_name">
								<option value="">Select Partner</option>
								<?php foreach ($partners as $k => $v): ?>
								<option value="<?php echo $v['partner_id'].':'.$v['partner_username'] ?>" <?php if ($_POST['partner_name'] == $v['partner_id'].':'.$v['partner_username'] ) echo 'selected' ; ?>><?php echo $v['partner_username'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						
						<div class="col-md-4">
							<label class="col-sm-2 control-label" for="telco">Provider</label>
							<select class="form-control" id="telco" name="telco">
								<option value="">Select Telco</option>
								<option value="VTT" <?php if ($_POST['telco'] == 'VTT' ) echo 'selected' ; ?>>Viettel</option>
								<option value="VNP" <?php if ($_POST['telco'] == 'VNP' ) echo 'selected' ; ?>>Vinaphone</option>
								<option value="VMS" <?php if ($_POST['telco'] == 'VMS' ) echo 'selected' ; ?>>Mobifone</option>
							</select>
						</div>
						
						<div class="col-md-4">
							<label class="col-sm-4 control-label" for="order_expire">Expire date</label>
							<input type="text" class="form-control" id="order_expire" name="order_expire" placeholder="YYYY/MM/DD" autocomplete="off">
						</div>
					</div>

					<div class="form-group">
                
						<div class="col-md-4">
							<label for="order_name">Order name</label>
							<input readonly type="text" class="form-control" id="order_name" name="order_name" placeholder="Order name" value="<?php if(isset($_POST['order_name'])){echo $_POST['order_name'];} ?>">
						</div>

						<div class="col-md-6">
							<label for="order_remark">Order remark</label>
							<textarea class="form-control" rows="3 " name="order_remark" placeholder="Enter ..." value="<?php if(isset($_POST['order_remark'])){echo $_POST['order_remark'];} ?>"></textarea>
						</div>
					</div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save & Close</button>
                <a href="<?php echo base_url('Controller_Order_Manager/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       
      </div>
      <!-- /.box -->

    </section>
	
	<script type="text/javascript">
$( function() {
    $( "#order_expire" ).datepicker({ dateFormat: 'dd/mm/yy'});
	var today = new Date();
	var month = today.getMonth() + 1;
	var date = today.getDate() + 2;
	
	if (date < 10) {
		date = '0' + date;
	}

	if(month < 10){
		month = '0' + month;
	}
	
	$('#order_expire').val(date + '/' + month + '/' + today.getFullYear());
	
	
	$('#partner_name').change(function(){
		if($('#partner_name').val() != '' && $('#telco').val() != ''){
			var url = '/Controller_Order_Manager/create_order_name/'+ $('#partner_name').val() + '/' + $('#telco').val();
			$.ajax({
				url: url,
				type: 'POST',
				dataType : 'json',
				data:{}
			}).done(function(data) {
				console.log(data);
				$("#order_name").val('');
				$("#order_name").val(data.html);
				
			});
		}
	});
	
	$('#telco').change(function(){
		if($('#partner_name').val() != '' && $('#telco').val() != ''){
			var url = '/Controller_Order_Manager/create_order_name/'+ $('#partner_name').val() + '/' + $('#telco').val();
			$.ajax({
				url: url,
				type: 'POST',
				dataType : 'json',
				data:{}
			}).done(function(data) {
				console.log(data);
				$("#order_name").val('');
				$("#order_name").val(data.html);
				
			});
		}
	});
	
});
	
	

</script>