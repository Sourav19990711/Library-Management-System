<?php include('header.php');?>
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
              <div class="caption"> <i class="fa fa-cogs font-green-sharp"></i> <span class="caption-subject font-green-sharp bold uppercase">Manage Categories</span> </div>
             <div class="tools"><a id="btnAdd" href="category-update.php" class="btn green" style="height:35px;">Add Category <i class="fa fa-plus"></i></a> </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                
                </div>
                <div class="col-md-6 col-sm-12">
                <a href="#" id="btn_export_csv" class="btn green" style="height:35px;float:right;margin-right:10px;">Export to XLS <i class="fa fa-file-excel-o"></i></a>
                
                </div>
              </div>
            <div class="portlet-body" id="table_container">
              <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                  <tr>
                    <th> Name </th>
                   
                    <th> Action </th>
                  </tr>
                </thead>
                
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