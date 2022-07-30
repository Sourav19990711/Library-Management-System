//Javascript Document
var dtCinemaHall;
/*document ready starts*/
jQuery(document).ready(function(e) {
	$('#full').modal('show');
	get_data(init());
});
/*document ready ends*/
/*function for fetching data from database starts*/
function get_data(func)
{
	var param={
					'sp_name'				:		'cin_get_cinema_hall_seconds',
					'action'				:		'select',
					'param_list'			:		{
														'flag' 						: 		'cin_cinema_hall_seconds_page_load',
														'current_page' 				: 		''
													}
			 };
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
					build_load_filter(response,func);
			});
}
/*function for fetching data from database ends*/
/*function for building datatable starts*/
function build_load_filter(data,func)
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
	
	
	var dtCinemaHallLocal = [{0:"0",1:"Select Bhk"}];
	fill_combo('cin_cinema_hall_id',dtCinemaHallLocal,0);
	jQuery('#cin_cinema_hall_id').select2();
	
	
	if(strView=='Y')
	{
		
		if(data.datatable_1!==undefined && data.datatable_1.length > 0)
		{
			var dtSeconds = [{0:"0",1:"Select Seconds"}];
			dtSeconds = dtSeconds.concat(data.datatable_1);
			fill_combo('cin_seconds_id',dtSeconds,0);
			
			jQuery('#cin_seconds_id').select2();
		}
		
		if(data.datatable_2!==undefined && data.datatable_2.length > 0)
		{
			var dtCity = [{0:"0",1:"Select City"}];
			dtCity = dtCity.concat(data.datatable_2);
			fill_combo('cin_city_id',dtCity,0);
			
			jQuery('#cin_city_id').select2();
		}
		
		if(data.datatable_3!==undefined && data.datatable_2.length > 0)
		{
			dtCinemaHall = data.datatable_3;
		}
		

	
	
		if(typeof(func)==='function')
		{
			func();
		}
	}
}
/*function for building datatable ends*/

/* START - LOADING CINEMA HALL ON CITY CHNAGE */
function load_hall()
{
	var dtCinemaHallFilter = [];
	var cin_city_id = document.getElementById('cin_city_id').value;
	var dtCinemaHallLocal = [{0:"0",1:"Select Hall"}];
	var drRow;
	var bFiltered = 0;
	if(parseInt(cin_city_id)!=0)
	{
		for(iRow=0;iRow<=dtCinemaHall.length-1;iRow++)
		{
			if(parseInt(dtCinemaHall[iRow]['cin_city_id'])==parseInt(cin_city_id))
			{
				bFiltered = 1;
				drRow = [{0:dtCinemaHall[iRow]['cin_cinema_hall_id'],1:dtCinemaHall[iRow]['cin_cinema_hall_name']}];
				dtCinemaHallFilter = dtCinemaHallFilter.concat(drRow);	
			}	
		}
		if(bFiltered==1)
		{
			dtCinemaHallLocal = dtCinemaHallLocal.concat(dtCinemaHallFilter);
		}
	}
	fill_combo('cin_cinema_hall_id',dtCinemaHallLocal,0);
	
	jQuery('#cin_cinema_hall_id').select2();		
}
/* END - LOADING CINEMA HALL ON CITY CHNAGE */

/*document ready callback starts*/
function init()
{
	Metronic.init();
	Layout.init();
	Demo.init();
  	FormSamples.init();
	jQuery('body').HideLoader();
	SetMenu();
	jQuery('#menu_hall_scheme').addClass('open');
}
/*document ready callback ends*/
/*function for deleting user starts*/
function delete_record(cin_cinema_hall_seconds_id)
{
	
	//delete user
	jQuery('body').ShowLoader();
	var param={
					'sp_name'				:		'cin_delete_cinema_hall',
					'action'				:		'delete',
					'param_list'			:		{
														'cin_cinema_hall_seconds_id' 		: 		''+cin_cinema_hall_seconds_id,
														'current_page' 						: 		''
													}
			};
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
					loadSearchDetails();
			});
			
}
/*function for deleting user ends*/
jQuery(document).on('click','#btn_export_csv',function(e){
	jQuery('#sample_1').tableExport({type:'excel',htmlContent:true,escape:'false',ignoreColumn:'[6]'});	
});

jQuery(document).on('click','.filter_search_button',function(){
	jQuery('#full').modal('hide');	
	loadSearchDetails();
});
function loadSearchDetails()
{
	jQuery('body').ShowLoader();
	var param={
					'sp_name'				:		'cin_get_cinema_hall_seconds',
					'action'				:		'select',
					'param_list'			:		{
														'flag' 						: 		'cin_cinema_hall_seconds_list',
														'cin_seconds_id' 			: 		''+get_value('cin_seconds_id'),
														'cin_city_id' 				: 		''+get_value('cin_city_id'),
														'cin_cinema_hall_id' 		: 		''+get_value('cin_cinema_hall_id'),
														'current_page' 				: 		''
													}
			 };
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
					build_datatable(response);
			});
}
function build_datatable(data)
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
		table_html+='<th width="10%" >City</th>';
        table_html+='<th width="30%" >Hall</th>';
		table_html+='<th width="20%" >Seconds</th>';
        table_html+='<th width="10%" >Price</th>';
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
				var active=(data.datatable_1[i]['cin_cinema_hall_seconds_enum']=='A')?'Active':'Inactive';
				table_html+='<tr>';
				table_html+='<td>'+data.datatable_1[i]['cin_city_name']+'</td>';
				table_html+='<td>'+data.datatable_1[i]['cin_cinema_hall_name']+'</td>';
				table_html+='<td>'+data.datatable_1[i]['cin_seconds_value']+'</td>';
				table_html+='<td>'+data.datatable_1[i]['cin_cinema_hall_week_price']+'</td>';
				table_html+='<td>'+active+'</td>';
        		table_html+='<td>';
				table_html+='<div class="details" style="display:inline-block;float:left;width:50%;">';
				if(strEdit=='Y')
				{
				table_html+='<a href="cinema_hall_seconds_update.php?cin_cinema_hall_seconds_id='+data.datatable_1[i]['cin_cinema_hall_seconds_id']+'" class="btn green">Edit <i class="fa fa-pencil-square-o"></i></a>';
				
				}
				table_html+='</div>';
				table_html+='<div class="details" style="display:inline-block;float:right;width:50%;">';
				if(strDelete=='Y')
				{
				table_html+='<a href="javascript:void(0)" style="float:right;" onclick="delete_record('+data.datatable_1[i]['cin_cinema_hall_seconds_id']+')" class="btn red">Delete <i class="fa fa-trash-o" ></i></a>';
				
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
	jQuery('body').HideLoader();
	
	}
}