<?php 
include('header.php');


    /*if(isset($_REQUEST['duration_id']))
	{
      	execute_query("DELETE FROM `rdo_length` WHERE `duration_id`='".$_REQUEST['duration_id']."' ");
    }*/
	
	$strSql = '
		SELECT * FROM cin_order r1
        INNER JOIN
		member m ON  m.lMemberID=r1.lMemberID 
	';
	
	
	 
     	/* $strSql="SELECT * FROM cin_order r1 
		  INNER JOIN member m ON m.lMemberID=r1.lMemberID
		  INNER JOIN cin_order_details ON cin_order_details.order_id=r1.order_id";*/
	 
	
		
	$dtOrder = getDatatable($strSql);
	
	
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container"> 
  <!-- BEGIN PAGE HEAD -->
  <div class="page-head">
    <div class="container"> </div>
  </div>
  <!-- END PAGE HEAD --> 
  <!-- BEGIN PAGE CONTENT -->
  <div class="page-content">
    <div class="container"> 
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="row">
        <div class="col-md-12"> 
          <!-- BEGIN EXAMPLE TABLE PORTLET-->
          <div class="portlet light">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-cogs font-green-sharp"></i> <span class="caption-subject font-green-sharp bold uppercase">Manage Order</span> </div>
             <div class="tools"><!--<a id="btnAdd" href="rdo_frequency_update.php" class="btn green" style="height:35px;">Add Duration <i class="fa fa-plus"></i></a>--></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                
                </div>
                <div class="col-md-6 col-sm-12">
                <a href="#" id="btn_export_csv" class="btn green" style="height:35px;float:right;margin-right:10px;">Export to XLS <i class="fa fa-file-excel-o"></i></a>
                
                </div>
              </div>
            <div class="portlet-body" id="table_container">
			            <?php
						if(isset($message_str))
						{
                         echo "<font color='red'>".$message_str."</font>";
                        }						
						?>
              <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                  <tr>
                    <th width="40%">Company Name</th>
					<th width="10%">Email Id</th>
					<th width="10%">Order Date</th>
					<th width="10%">Total Amount</th>
                    <th width="10%">Order Start Date - Order Off Date</th>
					<th width="10%">Order Status</th>
					<th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>
				<?php
					for($iRowCount=0;$iRowCount<=count($dtOrder)-1;$iRowCount++)
					{
				?>		
                <tr>	
                    <td><?php echo $dtOrder[$iRowCount]['sCompany'];?></td>
					<td><?php echo $dtOrder[$iRowCount]['sEmail'];?></td>
					<td><?php echo $dtOrder[$iRowCount]['order_date'];?></td>
					<td><?php echo $tot_amount=$dtOrder[$iRowCount]['order_amount']-$dtOrder[$iRowCount]['order_discount']+$dtOrder[$iRowCount]['order_gst_amount'];?></td>
                    <td><?php 
					$dt = date_create($dtOrder[$iRowCount]['order_st_date']);
					echo $dt=date_format($dt,'d/m/Y');?>
					
					-<?php 
					$dt1=date_create($dtOrder[$iRowCount]['order_end_date']);
					echo $dt1=date_format($dt1,'d/m/Y');?>
					</td>
					<td>
					<?php 
					if($dtOrder[$iRowCount]['order_status']=="N")
					{
					  echo 	"New Order";
					}	
					if($dtOrder[$iRowCount]['order_status']=="D")
					{
					  echo 	"Order Done";
					}
					if($dtOrder[$iRowCount]['order_status']=="C")
					{
					  echo 	"Order Cancelled";
					}
					?>
					</td>
					<td><a href="cin_order_view.php?order_id=<?php echo $dtOrder[$iRowCount]['order_id'];?>">View</a></td>
                </tr>
				<?php
				}
				?>
				
                </tbody>
              </table>
            </div>
          </div>
          <!-- END EXAMPLE TABLE PORTLET--> 
        </div>
      </div>
      <!-- END PAGE CONTENT INNER --> 
    </div>
  </div>
  <!-- END PAGE CONTENT --> 
</div>
<!-- END PAGE CONTAINER -->
<?php include('footer.php');?>