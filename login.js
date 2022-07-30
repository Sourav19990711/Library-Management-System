//Javascript document
/*document ready starts*/
jQuery(document).ready(function(e) {
    jQuery('body').HideLoader();
});
/*document ready ends*/
/*live event binding for login button click starts*/
jQuery(document).on('click','#btn_login',function(){
	jQuery('#ksp_form').Validate();
if(jQuery('#ksp_form').attr('validated')==1)
	{
		ksp_login();
	}
});
/*live event binding for login button click ends*/
/*live event binding for hitting enter key starts*/
jQuery(document).on('keypress','#ksp_form',function(e){
	var key = e.which || e.charCode || e.keyCode;
	if(key==13)
	{
		e.preventDefault();
		jQuery('#ksp_form').Validate();
		if(jQuery('#ksp_form').attr('validated')==1)
			{
				ksp_login();
			}
	}
});
/*live event binding for hitting enter key starts*/
/*function for validating login starts*/
function ksp_login()
{
	jQuery('body').ShowLoader();
		/*
		var param={
					'sp_name'				:		'get_login',
					'action'				:		'login',
					'param_list'			:		{
														'user_email' 					: 		''+get_value('username'),
														'user_password' 				: 		''+get_value('password'),
														'website_id'					:		''+get_value('website_id')
													}
			 };
			 */
		var param={
					'sp_name'				:		'get_login',
					'action'				:		'login',
					'param_list'			:		{
														'user_no' 					: 		''+get_value('username'),
														'user_password' 			: 		''+get_value('password')
													}
			 };	 
			 
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
					if(response.status==1)
					{
						if(response.datatable_1!==undefined)
						{
							/*
							//console.log(response);
							var strMenuDesign = '<li class="menu-dropdown" id="menu_dashboard"><a href="dashboard.php" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="Dashboard">Dashboard </a></li>';
							for(iRowCount=0;iRowCount<=response.datatable_2.length-1;iRowCount++)
							{
								if(response.datatable_2[iRowCount]['permission_view']=='Y')
								{
								//strMenuDesign += '<li class="menu-dropdown" id="'+response.datatable_2[iRowCount]['form_url']+'"><a href="'+response.datatable_2[iRowCount]['form_url']+'" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="'+response.datatable_2[iRowCount]['form_name']+'">'+response.datatable_2[iRowCount]['form_name']+'</a></li>';	
								}
							}
							strMenuDesign = '<li class="menu-dropdown" id="property.php"><a href="property.php" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="Inventory">Inventory</a></li>';
							strMenuDesign += '<li class="menu-dropdown" id="requirement.php"><a href="requirement.php" class="tooltips" data-container="body" data-placement="bottom" data-html="true" data-original-title="Requirement">Requirement</a></li>';							
							*/
							window.localStorage.setItem('user',JSON.stringify(response.datatable_1));
							////window.localStorage.setItem('user_permission',response.datatable_2);
							//window.localStorage.setItem('user_permission',JSON.stringify(response.datatable_2));
							//window.localStorage.setItem('strMenuDesign',strMenuDesign);
							//window.localStorage.setItem('website_id',get_value('website_id'));
							/*
							if(parseInt(response.datatable_1[0]['cin_user_id'])==2)
							{
								go_to('cinema_calender_proposal.php');
							}
							else
							{
								go_to('index.php');
							}
							*/
							go_to('index.php');
						}
						else
						{
							go_to('login.php');	
						}
					}
					else
					{
						jQuery('body').HideLoader();
					}
			});
}
/*function for validating login ends*/