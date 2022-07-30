//Javascript Document
var dtHallScreenBranding = new Array();
/*document ready starts*/
jQuery(document).ready(function(e) {
	/*
	var user_permission_str=window.localStorage.getItem('user_permission');
	dtUserPermission=JSON.parse(user_permission_str);
	
	for(iRowCount=0;iRowCount<=dtUserPermission.length-1;iRowCount++)
	{
		if(parseInt(dtUserPermission[iRowCount]['form_id'])==1)
		{
			if(((dtUserPermission[iRowCount]['permission_add']=='Y')&&(current_cinema_hall_screen_id==0))||((dtUserPermission[iRowCount]['permission_edit']=='Y')&&(current_cinema_hall_screen_id!=0)))
			{

			}
			else
			{
				jQuery('#btn_form_submit').detach();	
			}
			
			if(dtUserPermission[iRowCount]['permission_view']=='N')
			{
				go_to('dashboard.php');	
			}
		}	
	}
	*/
	
	
	get_data(function(){
		jQuery('body').HideLoader();
		SetMenu();
		jQuery('#menu_hall_screen').addClass('open');
		});
		
});
/*document ready ends*/
/*function for fetching data from database starts*/
function get_data(func)
{
	var param={
					'sp_name'				:		'cin_get_cinema_hall_screen',
					'action'				:		'select',
					'param_list'			:		{
														'flag' 							: 		'cinema_hall_screen_id',
														'cinema_hall_screen_id' 		: 		''+current_cinema_hall_screen_id,
														'current_page' 					: 		''
													}
			};
	var ajax=new ajax_builder();
		ajax.call(param,function(response){
					bind_data(response,func);
			});
}
/*function for fetching data from database ends*/
/*function for binding data to page elemets starts*/
function bind_data(data,func)
{
	console.log(data);
	current_cin_cinema_hall_id=0;
	current_hall_screen_category_id=0;
	var dtScreenBranding;
	if(data.datatable_3!==undefined)
	{
		
		set_value('cinema_hall_screen_name',data.datatable_3[0]['cinema_hall_screen_name']);
		set_value('cinema_hall_screen_total_seat',data.datatable_3[0]['cinema_hall_screen_total_seat']);
		
		if(data.datatable_3[0]['cinema_hall_screen_status']=='A')
		{
			jQuery('#cinema_hall_screen_status').prop('checked',true);
		}
		
		current_cin_cinema_hall_id=data.datatable_3[0]['cin_cinema_hall_id'];
		current_hall_screen_category_id=data.datatable_3[0]['hall_screen_category_id'];
	}
	
	
	if(data.datatable_1!==undefined)
	{
		fill_combo('cin_cinema_hall_id',data.datatable_1,current_cin_cinema_hall_id);
	}
	jQuery('#cin_cinema_hall_id').select2();
	
	if((data.datatable_4!==undefined)&&(data.datatable_5!==undefined))
	{
		if(parseInt(data.datatable_4[0]['cin_hall_screen_branding_count']) > 0 )
		{
			dtHallScreenBranding = data.datatable_5;
			set_value('hall_screen_branding_price',data.datatable_5[0]['hall_screen_branding_price']);
		} // if(parseInt(data.datatable_4[0]['cin_hall_screen_branding_count']) > 0 )
		
	} // if((data.datatable_4!==undefined)&&(data.datatable_5!==undefined))
	
	/*
	if((data.datatable_4!==undefined)&&(data.datatable_5!==undefined)&&(data.datatable_6!==undefined)&&(data.datatable_7!==undefined))
	{
		
		dtScreenBranding = data.datatable_5;
		dtScreenPricing = data.datatable_7;
		//if(parseInt(data.datatable_3[0]['cin_cinema_hall_screen_count'])>0)
		//{
			var members=jQuery('tr.member_single');
			for(var i=0;i<members.length;i++)
			{
				
				for(var iRow=0;iRow<=dtScreenBranding.length-1;iRow++)
				{
					
					if(parseInt(dtScreenBranding[iRow]['cin_branding_type_id'])==parseInt(jQuery.trim(jQuery(members[i]).find('.cin_branding_type_id').val())))
					{
						
						jQuery(members[i]).find('.hall_screen_branding_id').val(dtScreenBranding[iRow]['hall_screen_branding_id']);
						
						if(dtScreenBranding[iRow]['hall_screen_branding_status']=='A')
						{
							jQuery(members[i]).find('.hall_screen_branding_status').prop('checked',true);
						}
		
		
						for(var iRowPrice=0;iRowPrice<=dtScreenPricing.length-1;iRowPrice++)
						{
							if(parseInt(dtScreenPricing[iRowPrice]['hall_screen_branding_id'])==parseInt(dtScreenBranding[iRow]['hall_screen_branding_id']))
							{
								
								if((parseInt(dtScreenPricing[iRowPrice]['cin_seconds_id'])==1)
										&&(dtScreenPricing[iRowPrice]['hall_screen_pricing_type']=='W'))
								{
									
									jQuery(members[i]).find('.sec10Wk').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_rate']);
									jQuery(members[i]).find('.hall_screen_pricing_id_sec10Wk').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_id']);
								}	
								
								if((parseInt(dtScreenPricing[iRowPrice]['cin_seconds_id'])==1)
										&&(dtScreenPricing[iRowPrice]['hall_screen_pricing_type']=='M'))
								{
									
									jQuery(members[i]).find('.sec10Mn').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_rate']);	
									jQuery(members[i]).find('.hall_screen_pricing_id_sec10Mn').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_id']);
								}	
								
								if((parseInt(dtScreenPricing[iRowPrice]['cin_seconds_id'])==2)
										&&(dtScreenPricing[iRowPrice]['hall_screen_pricing_type']=='W'))
								{
									jQuery(members[i]).find('.sec20Wk').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_rate']);	
									jQuery(members[i]).find('.hall_screen_pricing_id_sec20Wk').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_id']);
								}	
								
								if((parseInt(dtScreenPricing[iRowPrice]['cin_seconds_id'])==2)
										&&(dtScreenPricing[iRowPrice]['hall_screen_pricing_type']=='M'))
								{
									jQuery(members[i]).find('.sec20Mn').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_rate']);	
									jQuery(members[i]).find('.hall_screen_pricing_id_sec20Mn').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_id']);
								}	
								
								if((parseInt(dtScreenPricing[iRowPrice]['cin_seconds_id'])==3)
										&&(dtScreenPricing[iRowPrice]['hall_screen_pricing_type']=='W'))
								{
									jQuery(members[i]).find('.sec30Wk').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_rate']);
									jQuery(members[i]).find('.hall_screen_pricing_id_sec30Wk').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_id']);	
								}	
								
								if((parseInt(dtScreenPricing[iRowPrice]['cin_seconds_id'])==3)
										&&(dtScreenPricing[iRowPrice]['hall_screen_pricing_type']=='M'))
								{
									jQuery(members[i]).find('.sec30Mn').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_rate']);	
									jQuery(members[i]).find('.hall_screen_pricing_id_sec30Mn').val(dtScreenPricing[iRowPrice]['hall_screen_pricing_id']);
								}	
							} // if(dtScreenPricing[iRowPrice]['hall_screen_branding_id']==dtScreenBranding[iRow]['hall_screen_branding_id'])
						}	
						
					} // if(parseInt(dtScreenBranding[iRow]['cin_branding_type_id'])==parseInt(jQuery.trim(jQuery(members[i]).find('.cin_branding_type_id').val())))
				} // for(var iRow=0;iRow<=dtScreenBranding.length;iRow++)
			} // for(var i=0;i<members.length;i++)
		//}
	}
	*/
	
	if(data.datatable_6!==undefined)
	{
		fill_combo('hall_screen_category_id',data.datatable_6,current_hall_screen_category_id);
	}
	jQuery('#hall_screen_category_id').select2();
	
	
	if(typeof(func)==='function')
		{
			func();
		}
}
/*function for binding data to page elemets ends*/
/*live event binding for submit button click starts*/
jQuery(document).on('click','#btn_form_submit',function(){
jQuery('#ksp_form').Validate();
if(jQuery('#ksp_form').attr('validated')==1)
	{
		var hall_screen_branding_status = 'I';
		
		//code
		jQuery('body').ShowLoader();
		if(parseInt(current_cinema_hall_screen_id)==0)
		{
			var sp_name='cin_insert_cinema_hall_screen';
			var action='insert';
		}
		else
		{
			var sp_name='cin_update_cinema_hall_screen';
			var action='update';
		}
		
		var cinema_hall_screen_status='I';
		if(jQuery('#cinema_hall_screen_status').is(':checked'))
		{
			cinema_hall_screen_status='A';
		}
		
		var xml='<soap xmlns="http://tempuri.org/"><root>';
			xml+='<sp_name>'+sp_name+'</sp_name>';
			xml+='<action>'+action+'</action>';
			xml+='<param_list>';

			xml+='<cinema_hall_screen_id>'+'<![CDATA['+current_cinema_hall_screen_id+']]>'+'</cinema_hall_screen_id>';
			xml+='<cin_cinema_hall_id>'+'<![CDATA['+get_value('cin_cinema_hall_id')+']]>'+'</cin_cinema_hall_id>';
			xml+='<hall_screen_category_id>'+'<![CDATA['+get_value('hall_screen_category_id')+']]>'+'</hall_screen_category_id>';
			xml+='<cinema_hall_screen_name>'+'<![CDATA['+get_value('cinema_hall_screen_name')+']]>'+'</cinema_hall_screen_name>';
			xml+='<cinema_hall_screen_total_seat>'+'<![CDATA['+get_value('cinema_hall_screen_total_seat')+']]>'+'</cinema_hall_screen_total_seat>';
			xml+='<cinema_hall_screen_status>'+'<![CDATA['+cinema_hall_screen_status+']]>'+'</cinema_hall_screen_status>';
			
			console.log(dtHallScreenBranding);
			if(dtHallScreenBranding.length > 0)
			{
				for(iRowCount=0;iRowCount<=dtHallScreenBranding.length-1;iRowCount++)
				{
					xml+='<screen_branding>';
					xml+='<cin_branding_type_id>'+'<![CDATA['+dtHallScreenBranding[iRowCount]['cin_branding_type_id']+']]>'+'</cin_branding_type_id>';
					xml+='<hall_screen_branding_id>'+'<![CDATA['+dtHallScreenBranding[iRowCount]['hall_screen_branding_id']+']]>'+'</hall_screen_branding_id>';
					xml+='<hall_screen_branding_price>'+'<![CDATA['+get_value('hall_screen_branding_price')+']]>'+'</hall_screen_branding_price>';
					xml+='</screen_branding>';
				}
			}
			else
			{
				
				// Mute Slide Screening
				xml+='<screen_branding>';
				xml+='<cin_branding_type_id>'+'<![CDATA[1]]>'+'</cin_branding_type_id>';
				xml+='<hall_screen_branding_id>'+'<![CDATA[0]]>'+'</hall_screen_branding_id>';
				xml+='<hall_screen_branding_price>'+'<![CDATA['+get_value('hall_screen_branding_price')+']]>'+'</hall_screen_branding_price>';
				xml+='</screen_branding>';	
				
				// Video Screening
				xml+='<screen_branding>';
				xml+='<cin_branding_type_id>'+'<![CDATA[2]]>'+'</cin_branding_type_id>';
				xml+='<hall_screen_branding_id>'+'<![CDATA[0]]>'+'</hall_screen_branding_id>';
				xml+='<hall_screen_branding_price>'+'<![CDATA['+get_value('hall_screen_branding_price')+']]>'+'</hall_screen_branding_price>';
				xml+='</screen_branding>';
				
				// Audio Slide Screening
				xml+='<screen_branding>';
				xml+='<cin_branding_type_id>'+'<![CDATA[3]]>'+'</cin_branding_type_id>';
				xml+='<hall_screen_branding_id>'+'<![CDATA[0]]>'+'</hall_screen_branding_id>';
				xml+='<hall_screen_branding_price>'+'<![CDATA['+get_value('hall_screen_branding_price')+']]>'+'</hall_screen_branding_price>';
				xml+='</screen_branding>';
			}
			
			/*
			var members=jQuery('tr.member_single');
			for(var i=0;i<members.length;i++)
			{
				
				hall_screen_branding_status = 'I';
				
				if((jQuery.trim(jQuery(members[i]).find('.sec10Wk').val())!=''))
				{
					xml+='<screen_branding>';
					xml+='<cin_branding_type_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_branding_type_id').val()+']]>'+'</cin_branding_type_id>';
					xml+='<hall_screen_branding_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_branding_id').val()+']]>'+'</hall_screen_branding_id>';
					
					if(jQuery(members[i]).find('.hall_screen_branding_status').is(':checked'))
					{
						hall_screen_branding_status='A';
					}
		
					xml+='<hall_screen_branding_status>'+'<![CDATA['+hall_screen_branding_status+']]>'+'</hall_screen_branding_status>';
					
					
						xml+='<screen_pricing>';
						xml+='<cin_seconds_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_seconds_id_10').val()+']]>'+'</cin_seconds_id>';
						xml+='<hall_screen_pricing_type>'+'<![CDATA[W]]>'+'</hall_screen_pricing_type>';
						xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec10Wk').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_pricing_id_sec10Wk').val()+']]>'+'</hall_screen_pricing_id>';
						xml+='</screen_pricing>';
						xml+='<screen_pricing>';
						xml+='<cin_seconds_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_seconds_id_10').val()+']]>'+'</cin_seconds_id>';
						xml+='<hall_screen_pricing_type>'+'<![CDATA[M]]>'+'</hall_screen_pricing_type>';
						//xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec10Mn').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec10Wk').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_pricing_id_sec10Mn').val()+']]>'+'</hall_screen_pricing_id>';
						xml+='</screen_pricing>';
						
						
						
						
						xml+='<screen_pricing>';
						xml+='<cin_seconds_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_seconds_id_20').val()+']]>'+'</cin_seconds_id>';
						xml+='<hall_screen_pricing_type>'+'<![CDATA[W]]>'+'</hall_screen_pricing_type>';
						//xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec20Wk').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_rate>'+'<![CDATA[0]]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_pricing_id_sec20Wk').val()+']]>'+'</hall_screen_pricing_id>';
						xml+='</screen_pricing>';
						xml+='<screen_pricing>';
						xml+='<cin_seconds_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_seconds_id_20').val()+']]>'+'</cin_seconds_id>';
						xml+='<hall_screen_pricing_type>'+'<![CDATA[M]]>'+'</hall_screen_pricing_type>';
						//xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec20Mn').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_rate>'+'<![CDATA[0]]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_pricing_id_sec20Mn').val()+']]>'+'</hall_screen_pricing_id>';
						xml+='</screen_pricing>';
						
						
						
						
						
						xml+='<screen_pricing>';
						xml+='<cin_seconds_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_seconds_id_30').val()+']]>'+'</cin_seconds_id>';
						xml+='<hall_screen_pricing_type>'+'<![CDATA[W]]>'+'</hall_screen_pricing_type>';
						//xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec30Wk').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_rate>'+'<![CDATA[0]]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_pricing_id_sec30Wk').val()+']]>'+'</hall_screen_pricing_id>';
						xml+='</screen_pricing>';
						xml+='<screen_pricing>';
						xml+='<cin_seconds_id>'+'<![CDATA['+jQuery(members[i]).find('.cin_seconds_id_30').val()+']]>'+'</cin_seconds_id>';
						xml+='<hall_screen_pricing_type>'+'<![CDATA[M]]>'+'</hall_screen_pricing_type>';
						//xml+='<hall_screen_pricing_rate>'+'<![CDATA['+jQuery(members[i]).find('.sec30Mn').val()+']]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_rate>'+'<![CDATA[0]]>'+'</hall_screen_pricing_rate>';
						xml+='<hall_screen_pricing_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_pricing_id_sec30Mn').val()+']]>'+'</hall_screen_pricing_id>';
						xml+='</screen_pricing>';
					
					
					
					
					
					xml+='</screen_branding>';
				} // if
				else
				{
				xml+='<delete_screen_branding>';
				xml+='<hall_screen_branding_id>'+'<![CDATA['+jQuery(members[i]).find('.hall_screen_branding_id').val()+']]>'+'</hall_screen_branding_id>';
				xml+='</delete_screen_branding>';
				}
			}
			*/
			xml+='</param_list>';
			xml+='</root></soap>';
			console.log(xml);
			
			
		
		
		
	var ajax=new ajax_builder();
		ajax.call(xml,function(response){
					if(parseInt(response.status)==1)
					{
						go_to('cinema_hall_screen.php');	
					}
					else if(parseInt(response.status)==2)
					{
						alert('Duplicate Hall Screen Name');
						jQuery('body').HideLoader();
					}
					else
					{
						alert('Error in operation');
						jQuery('body').HideLoader();
					}
			});
			
			
			
	}	
});
/*live event binding for submit button click ends*/
/*live event binding for cancel button click starts*/
jQuery(document).on('click','#btn_form_cancel',function(){
	go_to('cinema_hall_screen.php');
});
/*live event binding for cancel button click starts*/