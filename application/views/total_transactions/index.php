
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Partners Transactions
  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Summary Report</li>
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
					
					<div class="form-group">
					
						<label class="col-sm-1 control-label">Partner Username</label>
						<div class="col-sm-3">
							<input class="form-control" name="partnerUsrname" type="text" value="<?php if(isset($_POST['partnerUsrname'])){echo $_POST['partnerUsrname'];} ?>">
						</div>
						
						<label class="col-sm-1 control-label">Fromdate</label>
						<div class="col-sm-3">
							<input class="form-control" name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} ?>" id="datepicker" autocomplete="off">
						</div>
						
						<label class="col-sm-1 control-label">Todate</label>
						<div class="col-sm-3">
							<input class="form-control" name="toDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['toDate'];} ?>" id="datepicker1" autocomplete="off">
						</div>
					</div>
				
					<input class="btn btn-primary" type="submit" value="Search" text="Search">
				</form>
			</div>
        
			<div class="box-body">
				<?php if (isset($results)) { ?>
					<div>Total Amount: <?php echo number_format($totalAmount)?></div>
					<table class="table table-bordered table-striped" style="width: 100%;display: block;overflow-x: auto;white-space: nowrap;">
						<thead>
							<tr>
								<th>Quantity</th>
								<th>Total Amount</th>
								<th>Partner username</th>
								<th>Partner Id</th>
								<th>Provider Code</th>
							</tr>
						</thead> 
						<tbody>
						<?php foreach ($results as $data) { ?>
							<tr>
								<td><?php echo $data->quantity ?></td>
								<td><?php echo number_format($data->total_amount) ?></td>
								<td><?php echo $data->partner_username ?></td>
								<td><?php echo $data->partner_id ?></td>
								<td><?php echo $data->provider_code ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					
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
    $( "#datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );

  $( function() {
    $( "#datepicker1" ).datepicker({ dateFormat: 'dd/mm/yy' });
  } );


</script>
