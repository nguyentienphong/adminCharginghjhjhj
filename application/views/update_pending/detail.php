
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Pending</li>
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

         
            <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                <div class="row">
					<div class="form-group">
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">request_id</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->request_id; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">partner_id</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->partner_id; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">card_pin</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->card_pin; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">card_serial</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->card_serial; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">receive_date</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->receive_date; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">response_date</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->response_date; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">request_status</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->request_status; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">remark</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->remark; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">provider_code</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->provider_code; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">partner_username</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->partner_username; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">request_id_telco</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->request_id_telco; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">provider_status</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->provider_status; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">provider_message</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->provider_message; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">update_date</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->update_date; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">check_pending_time</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->check_pending_time; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">post_amount</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->post_amount; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">target_account</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->target_account; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">order_detail_id</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->order_detail_id; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">gateway_id</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->gateway_id; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">sub_partner_id</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->sub_partner_id; ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">sub_partner_username</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->sub_partner_username; ?>">
						</div>
						<div class="col-md-3">
							<label class="col-sm-2 control-label" for="partner_name">real_amount</label>
							<input readonly type="text" class="form-control" value="<?php echo $transaction_detail->real_amount; ?>">
						</div>
					</div>
					
						<div class="form-group">
							<div class="col-md-3">
								<label class="col-sm-2 control-label" for="partner_name">final_status</label>
								<select name='final_status' class="form-control" >
									<option value="">Thành công</value>
									<option value="">Thất bại</value>
								</select>
							</div>
							<div class="col-md-3">
								<label class="col-sm-2 control-label" for="partner_name">response_amount</label>
								
								<select name='response_amount' class="form-control">
									<option value="10000">10,000</option>
									<option value="20000">20,000</option>
									<option value="30000">30,000</option>
									<option value="50000">50,000</option>
									<option value="100000">100,000</option>
									<option value="200000">200,000</option>
									<option value="300000">300,000</option>
									<option value="500000">500,000</option>
									<option value="1000000">1,000,000</option>
									<option value="2000000">2,000,000</option>
								</select>
							</div>
						</div>
						
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save & Close</button>
                <a href="<?php echo base_url('Controller_Update_Pending/') ?>" class="btn btn-warning">Back</a>
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