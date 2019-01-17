 <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Partners Orders Detail
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders Detail</li>
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

        <form name="inputform" action="" method="post" >
        Partner username: <input name="partnerUsrname" type="text" value="<?php if(isset($_POST['partnerUsrname'])){echo $_POST['partnerUsrname'];} ?>">
        Fromdate: <input name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} ?>" id="datepicker" autocomplete="off">
        Todate: <input name="toDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['toDate'];} ?>" id="datepicker1" autocomplete="off">
        <input type="submit" text="Search">
        </form>
        <div class="box">
        <div class="box-body">
            <?php if (isset($results)) { ?>
                <table id="manageTable" class="table table-bordered table-striped" style="width: 100%;display: block;overflow-x: auto;white-space: nowrap;">
                    <tr>
                    <th>Order Id</th>
                    <th>Phone number</th>
                    <th>Payment status</th>
                    <th>Charge Amt</th>
                    <th>Expect Amt</th>
                    <th>Created Date</th>
                    <th>Latest Update</th>
                    </tr>
                     
                    <?php foreach ($results as $data) { ?>
                        <tr>
                            <td><?php echo $data->order_id ?></td>
                            <td><?php echo $data->phone_number ?></td>
                            <td><?php echo $data->payment_status ?></td>
                            <td><?php echo number_format($data->charged_amount) ?></td>
                            <td><?php echo number_format($data->expect_amount) ?></td>
                            <td><?php echo $data->created_date ?></td>
                            <td><?php echo $data->lastest_update ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div>Total Amount: <?php echo number_format($totalAmount)?></div>
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
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>