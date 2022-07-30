//Javascript Document
var arr_all_data = new Array();
var arr_search_data = new Array();
var iPaggingValue = 10;

/*document ready starts*/
jQuery(document).ready(function(e) {
	//get_data(init());
	
	// jQuery('body').HideLoader();
	refreshData(init());
});
/*document ready ends*/
function refreshData(func)
{
	
	strEdit = 'Y';
	strView = 'Y';
	strDelete = 'Y';	
	
	if(strView=='Y')
	{
		if(arr_search!==undefined && arr_search.length > 0)
		{
			arr_all_data = arr_search;
			arr_search_data = arr_search;
			getListView(1);
			
			jQuery('#current_page_index').html(iCurrentPageQS);
			
			jQuery('#sample_1_info').html('Showing '+iStartValueQS+' to '+iEndIndexQS+' of '+iTotalSearchRowCountQS+' entries');
			// iCurrentPage
		}
		else
		{
			jQuery('.page-footer').css({position:'fixed'});
		}
		
		//TableAdvanced.init();
		//jQuery('#sample_1').find('th:eq(0)').trigger('click');
		if(typeof(func)==='function')
		{
			func();
		}
	}
}


/*function for fetching data from database starts*/
function get_data(func)
{
	var param={
					'sp_name'				:		'cin_get_cinema_hall',
					'action'				:		'select',
					'param_list'			:		{
														'flag' 						: 		'cin_cinema_hall_list',
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
		if(data.datatable_1!==undefined && data.datatable_1.length > 0)
		{
			arr_all_data = data.datatable_1;
			arr_search_data = data.datatable_1;
			getListView(1);
		}
		else
		{
			jQuery('.page-footer').css({position:'fixed'});
		}
		
		//TableAdvanced.init();
		//jQuery('#sample_1').find('th:eq(0)').trigger('click');
		if(typeof(func)==='function')
		{
			func();
		}
	}
}
function getListView(iCurrentPage)
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
	var bPresent = 0;
	
	if(strView=='Y')
	{

	//console.log(data);
	var table_html='<table class="table table-striped table-bordered table-hover" id="sample_1">';
	/*Table Header starts*/
		table_html+='<thead>';
        table_html+='<tr>';
		table_html+='<th width="70%" >Campaign Name</th>';
        table_html+='<th width="10%" >Date</th>';
		table_html+='<th width="20%"></th>';
        table_html+='</tr>';
        table_html+='</thead>';
	/*Table Header ends*/
	/*Table Body starts*/
		table_html+='<tbody>';
		if(arr_search_data!==undefined && arr_search_data.length > 0)
		{
			var iStartIndex = (iCurrentPage * iPaggingValue) - iPaggingValue;
			var iEndIndex = iCurrentPage * iPaggingValue;
			
			if(arr_search_data.length <= iEndIndex )
			{
				iEndIndex = arr_search_data.length;	
			}
			
			for(var i=iStartIndex;i<=iEndIndex-1;i++)
			//for(var i=0;i<arr_search_data.length;i++)
			{
				bPresent = 1;
				
				//var active=(arr_search_data[i]['cin_cinema_hall_status']=='A')?'Active':'Inactive';
				table_html+='<tr>';
				table_html+='<td>'+arr_search_data[i]['campaign_name']+'</td>';
				table_html+='<td>'+arr_search_data[i]['campaign_date']+'</td>';
        		table_html+='<td>';
				table_html+='<div class="details" style="display:inline-block;float:left;width:50%;">';
				if(strEdit=='Y')
				{
				table_html+='<a href="cinema_calender_proposal.php?campaign_id='+arr_search_data[i]['campaign_id']+'" class="btn green">Edit <i class="fa fa-pencil-square-o"></i></a>';
				
				}
				table_html+='</div>';
				table_html+='<div class="details" style="display:inline-block;float:right;width:50%;">';
				if(strDelete=='Y')
				{
				table_html+='<a href="javascript:void(0)" style="float:right;" onclick="delete_record('+arr_search_data[i]['campaign_id']+')" class="btn red">Delete <i class="fa fa-trash-o" ></i></a>';
				
				}
				table_html+='</div>';
				table_html+='</td>';
        		table_html+='</tr>';
			}
			
			jQuery('.page-footer').css({position:'fixed'});
			document.getElementById('lblPage').innerHTML = 'Manage Cinema Hall - Total '+arr_search_data.length+' rows found';
			
			if(bPresent)
			{
				jQuery('#sample_1_info').html('Showing '+iStartIndex+' to '+iEndIndex+' of '+arr_search_data.length+' entries');
				jQuery('#current_page_index').html(iCurrentPage);
			}
			
		}
		else
		{
			jQuery('.page-footer').css({position:'fixed'});
		}
		table_html+='</tbody>';
	/*Table Body ends*/
		table_html+='</table>';
		if(bPresent)
		{
			document.getElementById('table_container').innerHTML=table_html;
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
	jQuery('#menu_proposal').addClass('open');
}
/*document ready callback ends*/
/*function for deleting user starts*/
function delete_record(campaign_id)
{
	if(confirm('Do you want to delete this record?'))
	{
	//delete user
	jQuery('body').ShowLoader();
	var param={
					'sp_name'				:		'cin_delete_campaign',
					'action'				:		'delete',
					'param_list'			:		{
														'campaign_id' 				: 		''+campaign_id,
														'current_page' 						: 		''
													}
			};
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
							go_to('cinema_calender_proposal_list.php');
							/*
							get_data(function(){
							jQuery('body').HideLoader();
							})
							*/
			});
	}
			
}
/*function for deleting user ends*/
jQuery(document).on('click','#btn_export_csv',function(e){
	
	var table_html='<table class="table table-striped table-bordered table-hover" id="sample_exp">';
		table_html+='<thead>';
        table_html+='<tr>';
		table_html+='<th width="80%" >Cinema Campaign Name</th>';
        table_html+='<th width="20%" >Date</th>';
        table_html+='</tr>';
        table_html+='</thead>';
		table_html+='<tbody>';
			
		for(var i=0;i<arr_search_data.length;i++)
		{
			//var active=(arr_all_data[i]['cin_cinema_hall_status']=='A')?'Active':'Inactive';
			table_html+='<tr>';
			
			table_html+='<td>'+arr_search_data[i]['campaign_name']+'</td>';
			table_html+='<td>'+arr_search_data[i]['campaign_date']+'</td>';
			
			table_html+='</tr>';
		}
		table_html+='</tbody>';
		table_html+='</table>';
		document.getElementById('sample_exp_container').innerHTML = table_html;
	
	jQuery('#sample_exp').tableExport({type:'excel',htmlContent:true,escape:'false'});	
});

jQuery(document).on('click','#sample_1_previous',function(){
	var current_page_index = jQuery('#current_page_index').html();
	if((parseInt(current_page_index)-1) >= 1)
	{
		//getListView(parseInt(current_page_index)-1);
		
		current_page_index = ''+parseInt(current_page_index)-1;
		window.location.href = 'cinema_calender_proposal_list.php?iCurrentPage='+current_page_index+'&search_text='+document.getElementById('search_text').value;
	}
});

jQuery(document).on('click','#sample_1_next',function(){
	
	var current_page_index = parseInt(jQuery('#current_page_index').html())+1;
	//getListView(current_page_index);
	window.location.href = 'cinema_calender_proposal_list.php?iCurrentPage='+current_page_index+'&search_text='+document.getElementById('search_text').value;
		
});

function search_text(strSearch)
{
	strSearch = strSearch.toLowerCase();
	var arr_data = new Array();
	var strSearhText = '';
	
	
	for(iRowCount=0;iRowCount<=arr_all_data.length-1;iRowCount++)
	{
		strSearhText = arr_all_data[iRowCount]['cin_city_name']+' '+arr_all_data[iRowCount]['target_group_name']+' '+arr_all_data[iRowCount]['cin_cinema_chain_name']+' '+arr_all_data[iRowCount]['cin_screen_type_name']+' '+arr_all_data[iRowCount]['cin_cinema_hall_name'];
		strSearhText = strSearhText.toLowerCase();
		
		if(strSearhText.indexOf(strSearch)>=0)
		{
			arr_data = arr_data.concat(arr_all_data[iRowCount]);	
		}
	}
	
	if(strSearch=='')
	{
		arr_search_data = arr_all_data;
	}
	else
	{
		arr_search_data = arr_data;
	}
	getListView(1);
	
	// str.toLowerCase();	
}