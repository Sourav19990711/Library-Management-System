//Javascript Document
/*document ready starts*/
jQuery(document).ready(function(e) {
	get_data(init());
});
/*document ready ends*/
/*function for fetching data from database starts*/
function get_data(func)
{
	var param={
					'sp_name'				:		'cin_get_calender_working_year',
					'action'				:		'select',
					'param_list'			:		{
														'flag' 						: 		'calender_working_year_list',
														'current_page' 				: 		''
													}
			 };
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
					build_datatable(response,func);
			});
}
/*function for fetching data from database ends*/
/*function for building datatable starts*/
function build_datatable(data,func)
{
	/*
	var user_permission_str=window.localStorage.getItem('user_permission');
	dtUserPermission=JSON.parse(user_permission_str);
	
	for(iRowCount=0;iRowCount<=dtUserPermission.length-1;iRowCount++)
	{
		if(parseInt(dtUserPermission[iRowCount]['form_id'])==12)
		{
			//strAdd = dtUserPermission[iRowCount]['permission_add'];
			strEdit = dtUserPermission[iRowCount]['permission_edit'];
			strView = dtUserPermission[iRowCount]['permission_view'];
			strDelete = dtUserPermission[iRowCount]['permission_delete'];	
			
			if(dtUserPermission[iRowCount]['permission_add']=='N')
			{
				jQuery('#btnAdd').detach();	
			}
			if(dtUserPermission[iRowCount]['permission_view']=='N')
			{
				go_to('dashboard.php');	
			}
		}	
	}
	*/
	strEdit = 'Y';
	strView = 'Y';
	strDelete = 'Y';	
	
	if(strView=='Y')
	{

	//console.log(data);
	var table_html='<table class="table table-striped table-bordered table-hover" id="sample_1">';
	/*Table Header starts*/
		table_html+='<thead>';
        table_html+='<tr>';
		table_html+='<th width="40%" >Year Name</th>';
        table_html+='<th width="15%" >Start Date</th>';
		table_html+='<th width="15%" >End Date</th>';
		table_html+='<th width="10%" >Status</th>';
		table_html+='<th width="20%"></th>';
        table_html+='</tr>';
        table_html+='</thead>';
	/*Table Header ends*/
	/*Table Body starts*/
		table_html+='<tbody>';
		if(data.datatable_1!==undefined && data.datatable_1.length > 0)
		{
			for(var i=0;i<data.datatable_1.length;i++)
			{
				var active=(data.datatable_1[i]['calender_working_year_status']=='A')?'Active':'Inactive';
				table_html+='<tr>';
				table_html+='<td>'+data.datatable_1[i]['calender_working_year_name']+'</td>';
				table_html+='<td>'+data.datatable_1[i]['calender_working_year_st_date']+'</td>';
				table_html+='<td>'+data.datatable_1[i]['calender_working_year_end_date']+'</td>';
				table_html+='<td>'+active+'</td>';
        		table_html+='<td>';
				table_html+='<div class="details" style="display:inline-block;float:left;width:50%;">';
				if(strEdit=='Y')
				{
				table_html+='<a href="cinema_calender_working_year_update.php?calender_working_year_id='+data.datatable_1[i]['calender_working_year_id']+'" class="btn green">Edit <i class="fa fa-pencil-square-o"></i></a>';
				
				}
				table_html+='</div>';
				table_html+='<div class="details" style="display:inline-block;float:right;width:50%;">';
				if(strDelete=='Y')
				{
				table_html+='<a href="javascript:void(0)" style="float:right;" onclick="delete_record('+data.datatable_1[i]['calender_working_year_id']+')" class="btn red">Delete <i class="fa fa-trash-o" ></i></a>';
				
				}
				table_html+='</div>';
				table_html+='</td>';
        		table_html+='</tr>';
			}
			jQuery('.page-footer').css({position:'fixed'});
		}
		else
		{
			jQuery('.page-footer').css({position:'fixed'});
		}
		table_html+='</tbody>';
	/*Table Body ends*/
		table_html+='</table>';
	document.getElementById('table_container').innerHTML=table_html;
	TableAdvanced.init();
	jQuery('#sample_1').find('th:eq(0)').trigger('click');
	if(typeof(func)==='function')
		{
			func();
		}
	}
}
/*function for building datatable ends*/
/*document ready callback starts*/
function init()
{
	Metronic.init();
	Layout.init();
	Demo.init();
  	FormSamples.init();
	jQuery('body').HideLoader();
	SetMenu();
	jQuery('#menu_working_year').addClass('open');
}
/*document ready callback ends*/
/*function for deleting user starts*/
function delete_record(calender_working_year_id)
{
	
	//delete user
	jQuery('body').ShowLoader();
	var param={
					'sp_name'				:		'cin_delete_calender_working_year',
					'action'				:		'delete',
					'param_list'			:		{
														'calender_working_year_id' 			: 		''+calender_working_year_id,
														'current_page' 						: 		''
													}
			};
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
							get_data(function(){
							jQuery('body').HideLoader();
							})
			});
			
}
/*function for deleting user ends*/
jQuery(document).on('click','#btn_export_csv',function(e){
	//jQuery('#sample_1').tableExport({type:'excel',htmlContent:true,escape:'false',ignoreColumn:'[4]'});

     jQuery('#sample_1').table2excel({
				    //exclude: ".noExl",
                    filename: "Your_File_Name.xls"
                });		
});