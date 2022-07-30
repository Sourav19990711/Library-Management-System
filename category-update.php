<?php include('header.php');?> 
<script type="text/javascript">var current_category_id=<?php echo $categories_id=(isset($_GET['categories_id']))?$_GET['categories_id']:'0'?>;</script>
<?php
$form_title=(isset($_GET['categories_id']))?"Update Category":"Add Category";
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
              <div class="caption"> <i class="fa fa-pencil-square-o"></i><?php echo $form_title;?> </div>
            </div>
            <div class="portlet-body form"> 
              <!-- BEGIN FORM-->
              <form action="" class="form-horizontal" id="ksp_form">
                <div class="form-body">
                  <h3 class="form-section small">Category Information</h3>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label col-md-3">Name *</label>
                        <div class="col-md-9">
                           <input type="text" class="form-control" placeholder="Name" name="categories_name" id="categories_name" data-required="1">
                          <span class="help-block message"> Enter user name here </span><span class="help-block error-message"> *Required field </span> </div>
                      </div>
                    </div>
                    
                    <!--/span-->
                    <!--/span--> 
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                           <input type="checkbox" style="float:left;" name="is_static" id="is_static" value="Y"><label class="col-md-3">Static</label>
                          <span class="help-block message"></span><span class="help-block error-message"> *Required field </span> </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                           <input type="checkbox" style="float:left;" name="is_active" id="is_active" value="Y"><label class="col-md-3">Active</label>
                          <span class="help-block message"></span><span class="help-block error-message"> *Required field </span> </div>
                      </div>
                    </div>
                  </div>
                  
                  
                  <!--<div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Static *</label>
                        <div class="col-md-9">
                         <input type="checkbox" class="form-control" name="is_static" id="is_static" value="Y">
                          <span class="help-block message"></span> <span class="help-block error-message"> *Required field </span></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label col-md-3">Active *</label>
                        <div class="col-md-9">
                         <input type="checkbox" class="form-control" name="is_active" id="is_active" value="Y">
                          <span class="help-block message"></span> <span class="help-block error-message"> *Required field </span></div>
                      </div>
                    </div>
                    
                  </div>-->
                  
                  
                  <div class="row">
                    <label class="control-label col-md-3">Select Parent Category</label>
                    <div class="col-md-9">
                      <div id="category_tree" class="demo"></div>
                    </div>
                    
                    <!--/span-->
                    
                    <!--/span--> 
                  </div>
                  
                  <!--/row-->
                  
                  <div class="row">
                    
                    <!--/span-->
                    
                    <!--/span--> 
                  </div>
                  <!--/row--> 
                </div>
                <div class="form-actions" style="border-top:1px solid #35aa47">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                        	<input type="hidden" id="is_valid" value="1">
                          <button type="button" id="btn_form_submit" class="btn green">Submit <i class="fa fa-pencil"></i></button>
                          <button type="button" id="btn_form_cancel" class="btn default">Cancel <i class="fa fa-times"></i></button>
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
<?php include('footer.php');?>