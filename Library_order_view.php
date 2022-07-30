<?php include('header.php');?> 

<?php


  	$strSql = '
		SELECT * FROM cin_order r1
        INNER JOIN
		member m ON  m.lMemberID=r1.lMemberID
       	WHERE  r1.order_id='.$_REQUEST["order_id"];
		
	$dtOrder = getDatatable($strSql);
	
	
	
	//--------------------------------------------------------------order--item-------------------------//
	
	$strSql_details = '
		SELECT * FROM cin_order r1
        INNER JOIN
        cin_order_details r2 ON r1.order_id = r2.order_id
		WHERE  r1.order_id='.$_REQUEST["order_id"];
		
	$dtOrder_details = getDatatable($strSql_details);
	
	    
	
	//-------------------------------------------------------------------------------------------------//
	
	
	
	
	
	
	
	
	
	
	
	
?> 

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container"> 
  <!-- BEGIN PAGE HEAD -->
  <div class="page-head">
    <div class="container">  
    </div>
  </div>
  <!-- END PAGE HEAD --> 
  <!-- BEGIN PAGE CONTENT -->
  <div class="page-content">
    <div class="container">   
      <!-- BEGIN PAGE CONTENT INNER -->
      <div class="row">
        <div class="col-md-12">
          <div class="portlet box green">
            <div class="portlet-title">
              <div class="caption"> <i class="fa fa-pencil-square-o"></i>Order Details</div>
            </div>
            <div class="portlet-body form"> 
              <!-- BEGIN FORM-->
              <form action="" class="form-horizontal" id="ksp_form">
                <div class="form-body">
                  <h3 class="form-section small">Order Information</h3>
                  
                  
                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Company</label>
                        <div class="col-md-9">
                         
						 <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sCompany'];?>" disabled data-required="1">
						 </div>
                      </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Address</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sAddress'];?>" name="user_no" disabled data-required="1">
                        </div>
                      </div>
                    </div>
                    <!--/span--> 
                  </div>
                 
                  
                 <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Phone</label>
                        <div class="col-md-9">
                         
						 <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sPhone'];?>" disabled data-required="1">
						 </div>
                      </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Email</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sEmail'];?>"  disabled data-required="1">
                        </div>
                      </div>
                    </div>
                    <!--/span--> 
                  </div>
                  
				  
				  
				  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Mobile</label>
                        <div class="col-md-9">
                         
						 <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sMobile'];?>" disabled data-required="1">
						 </div>
                      </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Contact Name</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sContactName'];?>"  disabled data-required="1">
                        </div>
                      </div>
                    </div>
                    <!--/span--> 
                  </div>
                   
				   
				   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Contact Phone</label>
                        <div class="col-md-9">
                         
						 <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sContactPhone'];?>" disabled data-required="1">
						 </div>
                      </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Contact Email</label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" value="<?php echo $dtOrder[0]['sContactEmail'];?>"  disabled data-required="1">
                        </div>
                      </div>
                    </div>
					
					
					
					
					
					
					
					
					
					<!--/span--> 
                  </div>
				  
				   <table border="1">
				   <thead>
								    <tr>
								      <th width="15%" scope="col">City</th>
								      <th scope="col">Screen<br/> Type</th>
								      <th scope="col">Cinema <br/>Chain</th>
								      <th scope="col">Hall</th>
								      <th scope="col">Audi<br/> No</th>
								      <th scope="col">Audi <br/>Capacity</th>
								      <th scope="col">Branding<br/> Type</th>
								      <th scope="col">Length <br/>(secs)</th>
								      <th scope="col">Duration<br/> (weeks)</th>
								      
								      
								    </tr>
								  </thead>
								  
								 <?php
								 for($iRowCount=0;$iRowCount<=count($dtOrder_details)-1;$iRowCount++)
								 {
									 $cin_hall_screen_branding=getDatatable("SELECT * FROM `cin_hall_screen_branding` WHERE `hall_screen_branding_id`='".$dtOrder_details[$iRowCount]['hall_screen_branding_id']."'");
								
								       $cin_cinema_hall_screen=getDatatable("SELECT * FROM `cin_cinema_hall_screen` WHERE `cinema_hall_screen_id` ='".$cin_hall_screen_branding[0]['cinema_hall_screen_id']."'");
								    
									$cin_cinema_hall=getDatatable("SELECT * FROM `cin_cinema_hall` WHERE `cin_cinema_hall_id`='".$cin_cinema_hall_screen[0]['cin_cinema_hall_id']."'");
								
								   $cin_city=getDatatable("SELECT * FROM `cin_city` WHERE `cin_city_id` ='".$cin_cinema_hall[0]['cin_city_id']."'");
								   
								   $cin_screen_type=getDatatable("SELECT * FROM `cin_screen_type` WHERE `cin_screen_type_id`='".$cin_cinema_hall[0]['cin_screen_type_id']."'");
								   
								   $cin_cinema_chain=getDatatable("SELECT * FROM `cin_cinema_chain` WHERE `cin_cinema_chain_id`='".$cin_cinema_hall[0]['cin_cinema_chain_id']."'");
								  
								  $cin_branding_type=getDatatable("SELECT * FROM `cin_branding_type` WHERE cin_branding_type_id='".$cin_hall_screen_branding[0]['cin_branding_type_id']."'");
								?>	
								  <tr>
								      <td><?php echo $cin_city[0]['cin_city_name'];?></th>
								      <td><?php echo $cin_screen_type[0]['cin_screen_type_name'];?></td>
								      <td><?php echo $cin_cinema_chain[0]['cin_cinema_chain_name'];?></td>
								      <td><?php echo $cin_cinema_hall[0]['cin_cinema_hall_name'];?></td>
								      <td><?php echo $cin_cinema_hall_screen[0]['cinema_hall_screen_name'];?></td>
								      <td><?php echo $cin_cinema_hall_screen[0]['cinema_hall_screen_total_seat'];?></td>
								      <td><?php echo $cin_branding_type[0]['cin_branding_type_name'];?></td>
								      <td><?php echo $dtOrder[0]['order_duration_sec'];?> sec <!--<a href="#" class="gb-btn-edit"></a>--></td>
								      <td><?php echo $dtOrder[0]['order_total_week'];?> <!--<a href="#" class="gb-btn-edit"></a>--></td>
								      <!--<td></td>-->
								     
								    </tr>
								 <?php			 
					                }	 
					              ?> 
				   
				   <tr>
				    <td colspan="9"><b>Order Amount:</b> <font color='red'>Rs.<?php echo $tot_amount=$dtOrder[0]['order_amount'];?></font></td>
				    </tr>
				   
				   <tr>
				    <td colspan="9"><b>Less : - Discount:</b> <font color='red'>Rs.<?php echo $dtOrder[0]['order_discount'];?></font></td>
				    </tr>
					
					 <tr>
				    <td colspan="9"><b>Add :- GST 18%:</b> <font color='red'>Rs.<?php echo $dtOrder[0]['order_gst_amount'];?></font></td>
				    </tr>
					
                  <tr>
				    <td colspan="9"><b>Total Amount:</b> <font color='red'>Rs.<?php echo $tot_amount=$dtOrder[0]['order_amount']-$dtOrder[0]['order_discount']+$dtOrder[0]['order_gst_amount'];?></font></td>
				  
				  </tr>
				  
                </div>
                <div class="form-actions" style="border-top:1px solid #35aa47">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                          
                         <a href="cin_order.php"><button type="button" id="btn_form_cancel" class="btn default">Back<i class="fa fa-times"></i></button></a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
              </form>
              <!-- END FORM--> 
            </div>
          </div>
        </div>
      </div>
      <!-- END PAGE CONTENT INNER --> 
    </div>
  </div>
  <!-- END PAGE CONTENT --> 
</div>
<!-- END PAGE CONTAINER --> 
<script>
var innovation_logo = '<?php echo $innovation_logo;?>';
</script>
<?php include('footer.php');?>
