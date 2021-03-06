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
    Cache Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Cache Manager</li>
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
        <span> Thẻ bị caching: <input name="txtCard" type="text" value="<?php if(isset($_POST['txtCard'])){echo $_POST['txtCard'];} ?>"></span><input type="submit" value="Search" name="searchCard">
        <br>
        Fromdate: <input name="fromDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} ?>" id="datepicker" autocomplete="off">
        Todate: <input name="toDate" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['toDate'];} ?>" id="datepicker1" autocomplete="off">
        OrderId: <input name="orderId" type="text" value="<?php if(isset($_POST['orderId'])){ echo $_POST['orderId'];} ?>"  autocomplete="off">
        Server: <select name="slServer">
                <option value="N/A"<?php if($slServer['interest'] == 'N/A'){ echo ' selected="selected"'; } ?>>----All-----</option>
                <option value="N/A"<?php if($slServer['interest'] == '192.168.1.48'){ echo ' selected="selected"'; } ?>>192.168.1.48</option>
                <option value="N/A"<?php if($slServer['interest'] == '192.168.0.49'){ echo ' selected="selected"'; } ?>>192.168.0.49</option>
                </select>
        Sim status: <select name="simStatus">
        <option value="2"<?php if($slServer['simStatus'] == '2'){ echo ' selected="selected"'; } ?>>Online</option>
        <option value="1"<?php if($slServer['simStatus'] == '1'){ echo ' selected="selected"'; } ?>>Stop</option>
        </select>
        <input type="submit" value="Search">
        <input type="submit" value="ExportXLS" name="export">
        <input type="submit" value="Clear_Pending_List" name="clearpending">
        </form>
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