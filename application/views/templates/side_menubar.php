
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li id="brandNav">
              <a href="<?php echo base_url('Controller_Partner_Transaction/') ?>">
                <i class="fa fa-list"></i> <span>Total Transaction</span>
              </a>
            </li>
        <li id="brandNav">
              <a href="<?php echo base_url('Controller_transaction/') ?>">
                <i class="fa fa-bookmark-o"></i> <span>Chi tiết giao dịch</span>
              </a>
            </li>
			<li id="brandNav">
              <a href="<?php echo base_url('Controller_transaction_new/') ?>">
                <i class="fa fa-building-o"></i> <span>Transaction new</span>
              </a>
            </li>
            <li id="brandNav">
              <a href="<?php echo base_url('Controller_Change_Pass/') ?>">
                <i class="fa fa-reorder"></i> <span>Change password</span>
              </a>
            </li>
            <li id="brandNav">
              <a href="<?php echo base_url('Controller_Members/') ?>">
                  <i class="fa fa-cloud"></i> <span>Partners</span>
              </a>
          </li>
          <li id="brandNav">
              <a href="<?php echo base_url('Controller_Order_Manager/') ?>">
                  <i class="fa fa-shopping-cart"></i> <span>Order</span>
              </a>
          </li>
		  <li>
              <a href="<?php echo base_url('Controller_Update_Pending/') ?>">
                  <i class="fa fa-check-circle"></i> <span>Cập nhật Pending</span>
              </a>
          </li>
		  
		  <li>
              <a href="<?php echo base_url('Controller_Total_Transaction/') ?>">
                  <i class="fa fa-list"></i> <span>Tổng hợp giao dịch</span>
              </a>
          </li>
		  
		  <li>
              <a href="<?php echo base_url('Controller_Total_Order_Pending/') ?>">
                  <i class="fa fa-list"></i> <span>Tổng hợp đơn hàng pending</span>
              </a>
          </li>
		  
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>