<?php include('header.php');

	$bSearchEntry = 0;
	
	$campaign_id = 0;
	$campaign_filter_id = 0;
	$campaign_name = '';
	if(isset($_REQUEST['campaign_id']))
	{
		$campaign_id = $_REQUEST['campaign_id'];
		
		$strSql = "
		select  campaign_name
		  from  cin_campaign 
		 where  campaign_id = ".$campaign_id."
		";
		$dtCampaign = getDatatable($strSql);
		$campaign_name = $dtCampaign[0]['campaign_name'];
	}
	
	//echo "campaign_id=".$campaign_id;

	$strSql = "
		  select  date_format(addtime(utc_timestamp(),'05:30'),'%d/%m/%Y') current_date_value
			";
	$dtCurrentDate = getDatatable($strSql);
	
	$strSql = "
		  select  cin_state_id, cin_state_name 
			from  cin_state
		order by  cin_state_name
			";
	$dtState = getDatatable($strSql);	
	
	$strSql = "
		  select  cin_city_id, cin_state_id, cin_city_name
			from  cin_city
	    order by  cin_city_name
			";
	$dtCity = getDatatable($strSql);
		
	$strSql = "
		  select  cin_cinema_chain_id, cin_cinema_chain_name
			from  cin_cinema_chain
		order by  cin_cinema_chain_name
			";
	$dtCinemaChain = getDatatable($strSql);
	
	$strSql = "
		  select  cin_cinema_hall_id, cin_city_id, cin_cinema_chain_id, cin_cinema_hall_name
			from  cin_cinema_hall
		order by  cin_cinema_hall_name
			";
	$dtCinemaHall = getDatatable($strSql);
	
	$st_date = '';
	$end_date = '';
	$hdn_cin_cinema_hall_id = '0';
	$hdn_cin_cinema_chain_id = '0';
	$hdn_cin_city_id = '0';
	$hdn_cin_state_id = '0';
	$cboLength = '1';
	$cin_screen_type_id = 0;
	$cboWeek = 0;
	
	if(isset($_REQUEST['btn_search']))
	{
		$bSearchEntry = 1;
		
		$hdnSelectedWeeks = $_REQUEST['hdnSelectedWeeks'];
		$st_date = $_REQUEST['st_date'];
		$end_date = $_REQUEST['end_date'];
		
		$cboWeek = $_REQUEST['cboWeek'];
		
		$arr_selected_weeks = explode(',',$hdnSelectedWeeks);
		$duration_week=count($arr_selected_weeks);
		
		if($_REQUEST['hdn_cin_cinema_hall_id']!='')
		{
			$hdn_cin_cinema_hall_id = $_REQUEST['hdn_cin_cinema_hall_id'];
		}
		if($_REQUEST['hdn_cin_cinema_chain_id']!='')
		{
			$hdn_cin_cinema_chain_id = $_REQUEST['hdn_cin_cinema_chain_id'];
		}
		if($_REQUEST['hdn_cin_city_id']!='')
		{
			$hdn_cin_city_id = $_REQUEST['hdn_cin_city_id'];
		}
		if($_REQUEST['hdn_cin_state_id']!='')
		{
			$hdn_cin_state_id = $_REQUEST['hdn_cin_state_id'];
		}
		
		if($_REQUEST['cboLength']!='')
		{
			$cboLength = $_REQUEST['cboLength'];
		}
		if($_REQUEST['cin_screen_type_id']!='')
		{
			$cin_screen_type_id = $_REQUEST['cin_screen_type_id'];
		}
		
		$strSecondsSql = ' select 1 cin_branding_type_id, '.$cboLength.' cin_seconds_id  ';
		
		$strSql="
				select  distinct ch.cin_cinema_chain_id, hsb.hall_screen_branding_id,
						sta.cin_state_name, ct.cin_city_name,  
						st.cin_screen_type_name, chs.cinema_hall_screen_name, chs.cinema_hall_screen_total_seat, 
						bt.cin_branding_type_name, (hsb.hall_screen_branding_price * (sc.cin_seconds_value/10)) 'amount'
						, (hsb.hall_screen_branding_price * (sc.cin_seconds_value/10)) 'calculation_rate', 0 'bb_week_count', 0 'mbb_week_count', 0 'festive_week_count'
						,cy.calender_year_nomal, cy.calender_year_block_buster, cy.calender_year_mega_block_buster
						,sc.cin_seconds_id, sc.cin_seconds_value,
						REPLACE(REPLACE(REPLACE(cc.cin_cinema_chain_name, ' - UFO', ''),' - Qube',''),' - QUBE','') cin_cinema_chain_name,
						REPLACE(REPLACE(ch.cin_cinema_hall_name, ' - UFO', ''),' - Qube','') cin_cinema_hall_name,
						chcat.hall_screen_category_name, cc.cin_cinema_chain_name cin_cinema_chain_name_extra, 
						ch.cin_cinema_hall_name cin_cinema_hall_name_extra
				  from  cin_hall_screen_branding hsb
				  
			inner join  (
						 ".$strSecondsSql."	
						) as tmp on hsb.cin_branding_type_id = tmp.cin_branding_type_id
			inner join  cin_seconds sc on sc.cin_seconds_id = tmp.cin_seconds_id
				  
			inner join  cin_branding_type bt on hsb.cin_branding_type_id = bt.cin_branding_type_id

			inner join  cin_cinema_hall_screen chs on hsb.cinema_hall_screen_id = chs.cinema_hall_screen_id
						and chs.cinema_hall_screen_status = 'A' 
						and hsb.hall_screen_branding_status = 'A'
			inner join  cin_cinema_hall ch on chs.cin_cinema_hall_id = ch.cin_cinema_hall_id
						and ch.cin_cinema_hall_status = 'A' ";
		if(intval($cin_screen_type_id)!=0)				
		{
			$strSql.="	and ch.cin_screen_type_id = ".$cin_screen_type_id." ";
		}					
		if((isset($_REQUEST['hdn_cin_cinema_hall_id']))&&($_REQUEST['hdn_cin_cinema_hall_id']!=''))				
		{
			$strSql.="	and ch.cin_cinema_hall_id in (".$_REQUEST['hdn_cin_cinema_hall_id'].") ";
		}				
						
		$strSql.="				
			inner join  cin_hall_screen_category chcat on ch.hall_screen_category_id = chcat.hall_screen_category_id		
			inner join  cin_calender_year cy on ch.cin_cinema_hall_id = cy.cin_cinema_hall_id
						and cy.calender_year_status = 'A'
			inner join  cin_calender_working_year cwy on cy.calender_working_year_id = cwy.calender_working_year_id
						and cwy.calender_working_year_status = 'A'
			inner join  cin_screen_type st on ch.cin_screen_type_id = st.cin_screen_type_id
						and st.cin_screen_type_status = 'A'
			inner join  cin_city ct on ch.cin_city_id = ct.cin_city_id
						and ct.cin_city_status = 'A' 
			inner join  cin_state sta on ct.cin_state_id = sta.cin_state_id
						";
		
		if((isset($_REQUEST['hdn_cin_state_id']))&&($_REQUEST['hdn_cin_state_id']!=''))				
		{
			$strSql.="	and ct.cin_state_id in (".$_REQUEST['hdn_cin_state_id'].") ";
		}
		
		if((isset($_REQUEST['hdn_cin_city_id']))&&($_REQUEST['hdn_cin_city_id']!=''))				
		{
			$strSql.="	and ct.cin_city_id in (".$_REQUEST['hdn_cin_city_id'].") ";
		}
						
		$strSql.="				
			inner join  cin_cinema_chain cc on ch.cin_cinema_chain_id = cc.cin_cinema_chain_id
						and cc.cin_cinema_chain_status = 'A' ";
		if((isset($_REQUEST['hdn_cin_cinema_chain_id']))&&($_REQUEST['hdn_cin_cinema_chain_id']!=''))				
		{
			$strSql.="	and cc.cin_cinema_chain_id in (".$_REQUEST['hdn_cin_cinema_chain_id'].") ";
		}				
				// echo '<br><br><br><br>'.$strSql;	
		$strSql.=" order by sta.cin_state_name,ct.cin_city_name, st.cin_screen_type_name, cin_cinema_chain_name, cin_cinema_hall_name, chs.cinema_hall_screen_name	";	
		//echo $strSql;
		$dtCart=getDatatable($strSql);	
		
		
		if(intval($campaign_id)!=0)
		{
			
			$strSql = "
			INSERT INTO  cin_campaign_filter
						 (   campaign_id,   campaign_filter_st_date, 
						 		campaign_filter_end_date, 
									campaign_filter_week, campaign_filter_seconds, campaign_filter_state,    campaign_filter_city,
										 campaign_filter_chain, 			campaign_filter_hall, 		  campaign_filter_type) 
				 VALUES  (".$campaign_id.", '".$st_date."',
				 				'".$end_date."',
									".$cboWeek.", 	   ".$cboLength.", 			'".$hdn_cin_state_id."', '".$hdn_cin_city_id."',
										'".$hdn_cin_cinema_chain_id."', '".$hdn_cin_cinema_hall_id."', ".$cin_screen_type_id.");
			";	
			execute_query($strSql);
			
			$strSql = "
				select  campaign_filter_id 
				  from  cin_campaign_filter
				 where  campaign_id = ".$campaign_id."
			  order by  campaign_filter_id desc
				 limit  0,1
			";
			$dtFilter=getDatatable($strSql);
			
			$campaign_filter_id = $dtFilter[0]['campaign_filter_id'];
			
				
			
		}
		
			
		//echo "Total Row Count = ".count($dtCart);
		/*
		echo '<pre>';
		print_r($dtCart);
		echo '</pre>';
		distinct ch.cin_cinema_chain_id, hsb.hall_screen_branding_id,
						ct.cin_city_name,  
						st.cin_screen_type_name, chs.cinema_hall_screen_name, chs.cinema_hall_screen_total_seat, 
						bt.cin_branding_type_name, (hsb.hall_screen_branding_price * (sc.cin_seconds_value/10)) 'amount'
						, (hsb.hall_screen_branding_price * (sc.cin_seconds_value/10)) 'calculation_rate', 0 'bb_week_count', 0 'mbb_week_count', 0 'festive_week_count'
						,cy.calender_year_nomal, cy.calender_year_block_buster, cy.calender_year_mega_block_buster
						,sc.cin_seconds_id, sc.cin_seconds_value,
						REPLACE(REPLACE(cc.cin_cinema_chain_name, ' - UFO', ''),' - Qube','') cin_cinema_chain_name,
						REPLACE(REPLACE(ch.cin_cinema_hall_name, ' - UFO', ''),' - Qube','') cin_cinema_hall_name,
						chcat.hall_screen_category_name
		*/
		
		$strComma = '';
		$strCinemaChainID = '';
		for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)	   
		{
			$strCinemaChainID .= $strComma.$dtCart[$iRowCount]['cin_cinema_chain_id'];	
			$strComma = ',';
		}	   
			   
		$strSql = "
					select  distinct cwcc.calender_week_no, cwcc.calender_week_movie_type, cwcc.calender_week_movie_type_value, 
							cwcc.calender_week_festive, cwcc.calender_week_festive_value,
							cycc.cin_cinema_chain_id
					  from  cin_calender_year_cinema_chain cycc
				inner join  cin_calender_working_year cwy on cycc.calender_working_year_id = cwy.calender_working_year_id
							and cwy.calender_working_year_status = 'A'
				inner join  cin_calender_week_cinema_chain cwcc 
							on cycc.calender_year_cinema_chain_id = cwcc.calender_year_cinema_chain_id
					   and  cycc.cin_cinema_chain_id in (".$strCinemaChainID.")
					   and  cwcc.calender_week_no in (".$hdnSelectedWeeks.")
				";
				
		$dtFestiveCalculation=getDatatable($strSql);
		
		for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)
		{
			$intBbCount = 0;
			$intMbbCount = 0;
			$intFestiveCount = 0;
			
			for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)
			{
				if(intval($dtCart[$iRowCount]['cin_cinema_chain_id'])==intval($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']))
				{
					foreach($arr_selected_weeks as $selected_week)
					{
						if(intval($dtFestiveCalculation[$iRow]['calender_week_no']) == intval($selected_week))
						{
							$calender_week_festive = $dtFestiveCalculation[$iRow]['calender_week_festive'];
							$calender_week_movie_type = $dtFestiveCalculation[$iRow]['calender_week_movie_type'];
							
							if($calender_week_festive=='Y')
							{
								$intFestiveCount++;
							}
							
							if($calender_week_movie_type=='BB')
							{
								$intBbCount++;	
							}	
							else if($calender_week_movie_type=='MBB')
							{
								$intMbbCount++;	
							}
						}
					}	
				}
			}
			
			$dtCart[$iRowCount]['bb_week_count'] = $intBbCount;
			$dtCart[$iRowCount]['mbb_week_count'] = $intMbbCount;
			$dtCart[$iRowCount]['festive_week_count'] = $intFestiveCount;
		}
		
		if(count($arr_selected_weeks) <=4)
		{
			$iTotalPrice = 0;
			for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)	
			{
				$dFestiveValue = floatval('0');
				$iTotalPrice = 0;
				
				for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)	
				{
					if(intval($dtCart[$iRowCount]['cin_cinema_chain_id'])==intval($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']))
					{
						$calender_week_festive = 'N';
						$calender_week_festive_value = 0;
						$calender_week_movie_type = 'NM';
						foreach($arr_selected_weeks as $selected_week)
						{
							if(intval($dtFestiveCalculation[$iRow]['calender_week_no']) == intval($selected_week))
							{
								$movie_type_price = floatval('0');
								$festive_value_price = floatval('0');
								$festive_value_calculation = floatval('0');
								
								$calender_week_festive = $dtFestiveCalculation[$iRow]['calender_week_festive'];
								$calender_week_festive_value = $dtFestiveCalculation[$iRow]['calender_week_festive_value'];
								$calender_week_movie_type = $dtFestiveCalculation[$iRow]['calender_week_movie_type'];
								
								if($calender_week_movie_type=='BB')
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])* floatval($dtCart[$iRowCount]['calender_year_block_buster']))/100);
								}
								else if($calender_week_movie_type=='MBB')
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])*floatval($dtCart[$iRowCount]['calender_year_mega_block_buster']))/100);
								}
								else if($calender_week_movie_type=='NM')
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])*floatval($dtCart[$iRowCount]['calender_year_nomal']))/100);
								}
								
								//$dtCart[$iRowCount]['calculation_rate'] = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
								$festive_value_calculation = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
						
								if($calender_week_festive=='Y')
								{
									$festive_value_price = 	(($festive_value_calculation * floatval($dtFestiveCalculation[$iRow]['calender_week_festive_value']))/100);
								}
								
								//$dtCart[$iRowCount]['calculation_rate'] = floatval($dtCart[$iRowCount]['calculation_rate']) + $movie_type_price + $festive_value_price;
								//$iTotalPrice = floatval($iTotalPrice) + floatval($dtCart[$iRowCount]['calculation_rate']) ;

								$iTotalPrice = floatval($iTotalPrice) + $festive_value_calculation + $festive_value_price ;
								
							} // if($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']==$selected_week)
						} // foreach($arr_selected_weeks as $selected_week)
						
						
						
					} // if($dtCart[$iRowCount]['cin_cinema_chain_id']==$dtFestiveCalculation[$iRow]['cin_cinema_chain_id'])
				} // for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)	
				$dtCart[$iRowCount]['calculation_rate'] = ceil($iTotalPrice);
			} // for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)	
		}
		else if((count($arr_selected_weeks) > 4)&&(count($arr_selected_weeks) < 13))
		{
			$iTotalPrice = 0;
			for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)	
			{
				$dFestiveValue = floatval('0');
				$iTotalPrice = 0;
				
				for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)	
				{
					if(intval($dtCart[$iRowCount]['cin_cinema_chain_id'])==intval($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']))
					{
						$calender_week_festive = 'N';
						$calender_week_festive_value = 0;
						$calender_week_movie_type = 'NM';
						foreach($arr_selected_weeks as $selected_week)
						{
							if(intval($dtFestiveCalculation[$iRow]['calender_week_no']) == intval($selected_week))
							{
								$movie_type_price = floatval('0');
								$festive_value_price = floatval('0');
								$festive_value_calculation = floatval('0');
								
								$calender_week_festive = $dtFestiveCalculation[$iRow]['calender_week_festive'];
								$calender_week_festive_value = $dtFestiveCalculation[$iRow]['calender_week_festive_value'];
								$calender_week_movie_type = $dtFestiveCalculation[$iRow]['calender_week_movie_type'];
								
								if(($calender_week_movie_type=='BB')&&(intval($dtCart[$iRowCount]['bb_week_count'])>1))
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])* floatval($dtCart[$iRowCount]['calender_year_block_buster']))/100);
								}
								else if($calender_week_movie_type=='MBB')
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])*floatval($dtCart[$iRowCount]['calender_year_mega_block_buster']))/100);
								}
								else if($calender_week_movie_type=='NM')
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])*floatval($dtCart[$iRowCount]['calender_year_nomal']))/100);
								}
								
								////$dtCart[$iRowCount]['calculation_rate'] = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
								//$movie_type_price = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
								$festive_value_calculation = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
						
								if($calender_week_festive=='Y')
								{
									$festive_value_price = 	(($festive_value_calculation * floatval($dtFestiveCalculation[$iRow]['calender_week_festive_value']))/100);
								}
								
								//$dtCart[$iRowCount]['calculation_rate'] = floatval($dtCart[$iRowCount]['calculation_rate']) + $movie_type_price + $festive_value_price;
								//$iTotalPrice = floatval($iTotalPrice) + floatval($dtCart[$iRowCount]['calculation_rate']) ;
								$iTotalPrice = floatval($iTotalPrice) + $festive_value_calculation + $festive_value_price ;
								
							} // if($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']==$selected_week)
						} // foreach($arr_selected_weeks as $selected_week)
						
						
						
					} // if($dtCart[$iRowCount]['cin_cinema_chain_id']==$dtFestiveCalculation[$iRow]['cin_cinema_chain_id'])
				} // for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)	
				
				$dtCart[$iRowCount]['calculation_rate'] = ceil($iTotalPrice);
			} // for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)
			
		} // else if((count($arr_selected_weeks) > 4)&&(count($arr_selected_weeks) < 13))
		else if(count($arr_selected_weeks) >= 13)
		{
			$iTotalPrice = 0;
			for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)	
			{
				$dFestiveValue = floatval('0');
				$iTotalPrice = 0;
				
				for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)	
				{
					if(intval($dtCart[$iRowCount]['cin_cinema_chain_id'])==intval($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']))
					{
						$calender_week_festive = 'N';
						$calender_week_festive_value = 0;
						$calender_week_movie_type = 'NM';
						foreach($arr_selected_weeks as $selected_week)
						{
							if(intval($dtFestiveCalculation[$iRow]['calender_week_no']) == intval($selected_week))
							{
								$movie_type_price = floatval('0');
								$festive_value_price = floatval('0');
								$festive_value_calculation = floatval('0');
								
								
								$calender_week_festive = $dtFestiveCalculation[$iRow]['calender_week_festive'];
								$calender_week_festive_value = $dtFestiveCalculation[$iRow]['calender_week_festive_value'];
								$calender_week_movie_type = $dtFestiveCalculation[$iRow]['calender_week_movie_type'];
								
								if($calender_week_movie_type=='BB')
								{
									$movie_type_price = 0; //((floatval($dtCart[$iRowCount]['amount'])* floatval($dtCart[$iRowCount]['calender_year_block_buster']))/100);
								}
								else if($calender_week_movie_type=='MBB')
								{
									$movie_type_price = 0; //((floatval($dtCart[$iRowCount]['amount'])*floatval($dtCart[$iRowCount]['calender_year_mega_block_buster']))/100);
								}
								else if($calender_week_movie_type=='NM')
								{
									$movie_type_price = ((floatval($dtCart[$iRowCount]['amount'])*floatval($dtCart[$iRowCount]['calender_year_nomal']))/100);
								}
								
								////$dtCart[$iRowCount]['calculation_rate'] = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
								//$movie_type_price = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
								$festive_value_calculation = floatval($dtCart[$iRowCount]['amount']) + $movie_type_price;
						
								if($calender_week_festive=='Y')
								{
									$festive_value_price = 	(($festive_value_calculation * floatval($dtFestiveCalculation[$iRow]['calender_week_festive_value']))/100);
								}
								
								//$dtCart[$iRowCount]['calculation_rate'] = floatval($dtCart[$iRowCount]['calculation_rate']) + $movie_type_price + $festive_value_price;
								//$iTotalPrice = floatval($iTotalPrice) + floatval($dtCart[$iRowCount]['calculation_rate']) ;
								
								$iTotalPrice = floatval($iTotalPrice) + $festive_value_calculation + $festive_value_price ;
								
							} // if($dtFestiveCalculation[$iRow]['cin_cinema_chain_id']==$selected_week)
						} // foreach($arr_selected_weeks as $selected_week)
						
						
						
					} // if($dtCart[$iRowCount]['cin_cinema_chain_id']==$dtFestiveCalculation[$iRow]['cin_cinema_chain_id'])
				} // for($iRow=0;$iRow<=count($dtFestiveCalculation)-1;$iRow++)	
				
				$dtCart[$iRowCount]['calculation_rate'] = ceil($iTotalPrice);
			} // for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)
			
		} // else if(count($arr_selected_weeks) >= 13)
			
	} // if(isset($_REQUEST['btn_search']))
	else
	{
		
		if(intval($campaign_id) > 0)
		{
			
			$strSql = "
				select  campaign_filter_id, campaign_id, campaign_filter_st_date, campaign_filter_end_date, campaign_filter_week,
						campaign_filter_seconds, campaign_filter_state, campaign_filter_city, campaign_filter_chain, campaign_filter_hall,
						campaign_filter_type 
				  from  cin_campaign_filter
				 where  campaign_id = ".$campaign_id."
			  order by  campaign_filter_id desc
				 limit  0,1
			";	
			$dtCartFilter = getDatatable($strSql);
			
			
			$st_date = $dtCartFilter[0]['campaign_filter_st_date'];
			$end_date = $dtCartFilter[0]['campaign_filter_end_date'];
			$cboWeek = $dtCartFilter[0]['campaign_filter_week'];
			$campaign_filter_id = $dtCartFilter[0]['campaign_filter_id'];
			$duration_week = $dtCartFilter[0]['campaign_filter_week'];
			$hdn_cin_state_id = $dtCartFilter[0]['campaign_filter_state'];
			$hdn_cin_city_id = $dtCartFilter[0]['campaign_filter_city'];
			$hdn_cin_cinema_chain_id = $dtCartFilter[0]['campaign_filter_chain'];
			$hdn_cin_cinema_hall_id = $dtCartFilter[0]['campaign_filter_hall'];
			$cboLength = $dtCartFilter[0]['campaign_filter_seconds'];
			$cin_screen_type_id = $dtCartFilter[0]['campaign_filter_type'];
			
			
			$strSql = "
				select  * 
				  from  cin_campaign_filter_data
				 where  campaign_filter_id = ".$dtCartFilter[0]['campaign_filter_id']."
			";
			$dtCart = getDatatable($strSql);
			
			
		}
		
	}
	
	
?>
<script>
var campaign_id = '<?php echo $campaign_id;?>';
var bSearchEntry = '<?php echo $bSearchEntry;?>';
var hdn_cin_state_id = '<?php echo $hdn_cin_state_id;?>';
var hdn_cin_city_id = '<?php echo $hdn_cin_city_id;?>';
var hdn_cin_cinema_chain_id = '<?php echo $hdn_cin_cinema_chain_id;?>';
var hdn_cin_cinema_hall_id = '<?php echo $hdn_cin_cinema_hall_id;?>';
var strCurrentDate = '<?php echo $dtCurrentDate[0]['current_date_value'];?>';

var dtCity = [
			<?php
	$strComma = '';		
	for($iRow=0;$iRow <= count($dtCity)-1;$iRow++)
	{
		echo $strComma.'{"0":"'.$dtCity[$iRow]['cin_city_id'].'","cin_city_id":"'.$dtCity[$iRow]['cin_city_id'].'","1":"'.$dtCity[$iRow]['cin_state_id'].'","cin_state_id":"'.$dtCity[$iRow]['cin_state_id'].'","2":"'.$dtCity[$iRow]['cin_city_name'].'","cin_city_name":"'.$dtCity[$iRow]['cin_city_name'].'"}';				
		$strComma = ',';
	}
			?>
];

var dtCinemaChain = [
			<?php
	$strComma = '';		
	for($iRow=0;$iRow <= count($dtCinemaChain)-1;$iRow++)
	{
		echo $strComma.'{"0":"'.$dtCinemaChain[$iRow]['cin_cinema_chain_id'].'","cin_cinema_chain_id":"'.$dtCinemaChain[$iRow]['cin_cinema_chain_id'].'","1":"'.$dtCinemaChain[$iRow]['cin_cinema_chain_name'].'","cin_cinema_chain_name":"'.$dtCinemaChain[$iRow]['cin_cinema_chain_name'].'"}';				
		$strComma = ',';
	}
			?>
];


var dtCinemaHall = [
			<?php
	$strComma = '';		
	for($iRow=0;$iRow <= count($dtCinemaHall)-1;$iRow++)
	{
		echo $strComma.'{"0":"'.$dtCinemaHall[$iRow]['cin_cinema_hall_id'].'","cin_cinema_hall_id":"'.$dtCinemaHall[$iRow]['cin_cinema_hall_id'].'","1":"'.$dtCinemaHall[$iRow]['cin_city_id'].'","cin_city_id":"'.$dtCinemaHall[$iRow]['cin_city_id'].'","2":"'.$dtCinemaHall[$iRow]['cin_cinema_chain_id'].'","cin_cinema_chain_id":"'.$dtCinemaHall[$iRow]['cin_cinema_chain_id'].'","3":"'.$dtCinemaHall[$iRow]['cin_cinema_hall_name'].'","cin_cinema_hall_name":"'.$dtCinemaHall[$iRow]['cin_cinema_hall_name'].'"}';				
		$strComma = ',';
	}
			?>
];


</script>
<style>
.hide_cinema_row{
	display:none;
	}
</style>
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
              <div class="caption"> <i class="fa fa-cogs font-green-sharp"></i> <span class="caption-subject font-green-sharp bold uppercase">Manage Working Year</span> </div>
             <div class="tools"><!--<a id="btnAdd" href="cinema_calender_working_year_update.php" class="btn green" style="height:35px;">Add Working Year <i class="fa fa-plus"></i></a>--> </div>
            </div>
            
            <form action="" method="get" onSubmit="return checkValue();" >
            <div class="row">
                <div class="col-md-8 col-sm-12">
                	Campaign Name :
                	<input type="text" id="campaign_name" name="campaign_name" value="<?php echo $campaign_name;?>" class="form-control" style="float:right;width:80%;" >
                    <input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $campaign_id;?>" >
                </div>
                <div class="col-md-4 col-sm-12">
                	<a href="javascript:;" id="btnCampaign" class="btn green" style="height:35px;float:left;margin-right:10px;"><?php echo $campaign_id==0?'Add':'Update';?> Campaign <i class="fa fa-file-add"></i></a>
                </div>
              </div>
              
            <div class="row margin-top-10">
            	<div class="col-md-4 col-sm-12">
                	ST Date : <input placeholder="dd-mm-yyyy" type="text" id="st_date" name="st_date" class="form-control" value="<?php echo $st_date;?>" style="width:300px;" >
                </div>	
                <div class="col-md-2 col-sm-12">
                	Week : <select id="cboWeek" name="cboWeek" onChange="setWeekDate()" class="form-control" style="width:150px;" >
                    			<option value="0" class="form-control" >Select Week</option>
								<?php
                                for($iRow=1;$iRow<=52;$iRow++)
								{
									if(intval($iRow)==$cboWeek)
									{
										echo '<option selected value="'.$iRow.'" >'.$iRow.'</option>';
									}
									else
									{
										echo '<option value="'.$iRow.'" >'.$iRow.'</option>';											
									}
								}
								?>                                
                    	   </select>
                     
                </div>
                <div class="col-md-4 col-sm-12">
                	END Date : <input placeholder="dd-mm-yyyy" type="text" id="end_date" name="end_date" class="form-control" style="width:300px;" value="<?php echo $end_date;?>" readonly >
                </div>
                
                
                <div class="col-md-2 col-sm-12">
                	
                     Seconds :  <select id="cboLength" name="cboLength" class="form-control" style="width:150px;" >
                     				<option value="1" <?php echo $cboLength==1?"selected":""; ?> >10</option>
                                    <option value="2" <?php echo $cboLength==2?"selected":""; ?> >20</option>
                                    <option value="3" <?php echo $cboLength==3?"selected":""; ?> >30</option>
                                    <option value="4" <?php echo $cboLength==4?"selected":""; ?> >40</option>
                                    <option value="5" <?php echo $cboLength==5?"selected":""; ?> >50</option>
                                    <option value="6" <?php echo $cboLength==6?"selected":""; ?> >60</option>
                     			</select>      
                </div>
                
                
            </div>
            
              
            <div class="row margin-top-10">
                <div class="col-md-4 col-sm-12">
                	State :
                	<select id="cin_state_id" name="cin_state_id" multiple style="width:300px;" onChange="load_city()" class="form-control" >
                    	<?php
						$arr_cin_state_id = explode(',',$hdn_cin_state_id);
						
                        for($iRow=0;$iRow <= count($dtState)-1;$iRow++)
						{
							$strSelectedText = '';
							
							for($iRowCount=0;$iRowCount <= count($arr_cin_state_id)-1;$iRowCount++)
							{
								if(intval($arr_cin_state_id[$iRowCount]) == intval($dtState[$iRow]['cin_state_id']))
								{
									$strSelectedText = ' selected ';
								}	
							}
							
							echo '<option '.$strSelectedText.' value="'.$dtState[$iRow]['cin_state_id'].'" >'.$dtState[$iRow]['cin_state_name'].'</option>';	
						}
						?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                	City :
                	<select id="cin_city_id" name="cin_city_id" multiple style="width:300px;" onChange="load_hall()" >
                    	<?php
						$arr_cin_city_id = explode(',',$hdn_cin_city_id);
						
                        for($iRow=0;$iRow <= count($dtCity)-1;$iRow++)
						{
							$strSelectedText = '';
							/*
							for($iRowCount=0;$iRowCount <= count($arr_cin_city_id)-1;$iRowCount++)
							{
								if(intval($arr_cin_city_id[$iRowCount]) == intval($dtCity[$iRow]['cin_city_id']))
								{
									$strSelectedText = ' selected ';
								}	
							}
							*/
							
							echo '<option '.$strSelectedText.' value="'.$dtCity[$iRow]['cin_city_id'].'" >'.$dtCity[$iRow]['cin_city_name'].'</option>';	
						}
						?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                	Chain :
                	<select id="cin_cinema_chain_id" name="cin_cinema_chain_id" multiple style="width:300px;" onChange="load_chain_hall()" >
                    	<?php
						$arr_cin_cinema_chain_id = explode(',',$hdn_cin_cinema_chain_id);
                        for($iRow=0;$iRow <= count($dtCinemaChain)-1;$iRow++)
						{
							$strSelectedText = '';
							/*
							for($iRowCount=0;$iRowCount <= count($arr_cin_cinema_chain_id)-1;$iRowCount++)
							{
								if(intval($arr_cin_cinema_chain_id[$iRowCount]) == intval($dtCinemaChain[$iRow]['cin_cinema_chain_id']))
								{
									$strSelectedText = ' selected ';
								}	
							}
							*/
							
							echo '<option '.$strSelectedText.' value="'.$dtCinemaChain[$iRow]['cin_cinema_chain_id'].'" >'.$dtCinemaChain[$iRow]['cin_cinema_chain_name'].'</option>';	
						}
						?>
                    </select>
                </div>
                <!--<div class="col-md-3 col-sm-12">
                <a href="#" id="btn_export_csv" class="btn green" style="height:35px;float:right;margin-right:10px;">Export to XLS <i class="fa fa-file-excel-o"></i></a>
                
                </div>-->
              </div>
              <div class="row margin-top-10">
              	<div class="col-md-4 col-sm-12">
                	Hall :
                	<select id="cin_cinema_hall_id" name="cin_cinema_hall_id" multiple class="form-control" >
                    	<?php
						/*
                        for($iRow=0;$iRow <= count($dtCinemaHall)-1;$iRow++)
						{
							echo '<option value="'.$dtCinemaHall[$iRow]['cin_cinema_hall_id'].'" >'.$dtCinemaHall[$iRow]['cin_cinema_hall_name'].'</option>';	
						}
						*/
						?>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                	Type :
                	<select id="cin_screen_type_id" name="cin_screen_type_id" class="form-control" >
                    	<option value="0" <?php echo $cin_screen_type_id==0?"selected":""; ?> >All</option>
                        <option value="1" <?php echo $cin_screen_type_id==1?"selected":""; ?> >Multiplex</option>
                        <option value="2" <?php echo $cin_screen_type_id==2?"selected":""; ?> >Single Screen</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                <input type="hidden" id="hdn_cin_cinema_hall_id" name="hdn_cin_cinema_hall_id" value="" >	
                <input type="hidden" id="hdn_cin_cinema_chain_id" name="hdn_cin_cinema_chain_id" value="" >
                <input type="hidden" id="hdn_cin_city_id" name="hdn_cin_city_id" value="" >
                <input type="hidden" id="hdn_cin_state_id" name="hdn_cin_state_id" value="" >
                <input id="hdnSelectedWeeks" name="hdnSelectedWeeks" value="" type="hidden" >
                
                <!--<a href="#" id="btn_search" class="btn green" style="height:35px;float:left;margin-left:10px;">Search <i class="fa fa-search"></i></a>-->
                
                <a href="javascript:;" id="btn_export_csv" class="btn green" style="height:35px;float:right;margin-right:10px;">Export to XLS <i class="fa fa-file-excel-o"></i></a>
                <input type="submit" id="btn_search" name="btn_search" class="btn green" style="height:35px;float:right;margin-right:10px;" >
                </div>
                
              </div>
              </form>
              
              
            <div class="portlet-body margin-top-20" id="table_container" style="height:500px;overflow-x:scroll;" >
              <!--<table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                  <tr>
                        <th width="40%" >Year Name</th>
                        <th width="15%" >Start Date</th>
                        <th width="15%" >End Date</th>
                        <th width="10%" >Status</th>
                        <th width="20%"></th>
                  </tr>
                </thead>
                
              </table>-->
             
              <table class="table table table-striped table-bordered table-hover"  id="sample_1"  >
                <thead id="tb_row_header" >
                    <tr>
                      <th width="4%" scope="col" class="noExl" ><input type="checkbox" name="" class="check_all" ></th>
                      <th width="2%"  ><strong>SL NO</strong></th>
                      <th width="6%" ><strong>State</strong></th>
                      <th width="6%" scope="col"><strong>City</strong></th>
                      <th width="10%" scope="col"><strong>Screen Type</strong></th>
                      <th width="5%" scope="col"><strong>Cinema Chain</strong></th>
                      <th width="5%" scope="col"><strong>CC MO</strong></th>
                      <th width="6%" scope="col"><strong>Hall</strong></th>
                      <th width="5%" scope="col"> <strong>HALL MO</strong></th>
                      <th width="5%" scope="col"><strong>Audi No</strong></th>
                      <th width="10%" scope="col"><strong>Audi Capacity</strong></th>
                      <th width="10%" scope="col"><strong>Hall Type</strong></th>
                      <th width="8%" scope="col"><strong>Length (secs)</strong></th>
                      <th width="8%" scope="col"><strong>Duration (weeks)</strong></th>
                      <th width="10%" scope="col" class="text-right"><strong>Amount</strong></th>
                      <!--<th scope="col">&nbsp;</th>-->
                    </tr>
                  </thead>
                  <tbody id="tb_row" >
                  <?php
                  $duration=1;
                   $strCartSaveValue = '';
                   $strComma = '';	
                   $total_cart_price = 0;
                   for($iRowCount=0;$iRowCount<=count($dtCart)-1;$iRowCount++)
                    {
						if((intval($campaign_filter_id) > 0)&&($bSearchEntry==1))
						{
							$strSql = "
							INSERT INTO  cin_campaign_filter_data
										(campaign_filter_id, 		cin_cinema_chain_id, 
	  hall_screen_branding_id, 								cin_state_name, 
	  	cin_city_name, 									cin_screen_type_name, 
			cinema_hall_screen_name, 								cinema_hall_screen_total_seat, 
				cin_branding_type_name, 								amount, 
					calculation_rate, 								 bb_week_count, 
						mbb_week_count, 							 festive_week_count, 
							calender_year_nomal, 								 calender_year_block_buster, 
								calender_year_mega_block_buster, 								cin_seconds_id, 
							cin_seconds_value, 								 cin_cinema_chain_name, 
						cin_cinema_hall_name, 								  hall_screen_category_name, 
					cin_cinema_chain_name_extra, 								cin_cinema_hall_name_extra) 
								VALUES  (".$campaign_filter_id.", ".$dtCart[$iRowCount]['cin_cinema_chain_id'].", 
	".$dtCart[$iRowCount]['hall_screen_branding_id'].", '".$dtCart[$iRowCount]['cin_state_name']."', 
		'".$dtCart[$iRowCount]['cin_city_name']."', '".$dtCart[$iRowCount]['cin_screen_type_name']."', 
			'".$dtCart[$iRowCount]['cinema_hall_screen_name']."', ".$dtCart[$iRowCount]['cinema_hall_screen_total_seat'].",
				'".$dtCart[$iRowCount]['cin_branding_type_name']."', '".$dtCart[$iRowCount]['amount']."',
					'".$dtCart[$iRowCount]['calculation_rate']."', ".$dtCart[$iRowCount]['bb_week_count'].", 
						".$dtCart[$iRowCount]['mbb_week_count'].", ".$dtCart[$iRowCount]['festive_week_count'].", 
							'".$dtCart[$iRowCount]['calender_year_nomal']."', '".$dtCart[$iRowCount]['calender_year_block_buster']."', 
								'".$dtCart[$iRowCount]['calender_year_mega_block_buster']."', ".$dtCart[$iRowCount]['cin_seconds_id'].", 
							".$dtCart[$iRowCount]['cin_seconds_value'].", '".$dtCart[$iRowCount]['cin_cinema_chain_name']."', 
						'".$dtCart[$iRowCount]['cin_cinema_hall_name']."', '".$dtCart[$iRowCount]['hall_screen_category_name']."', 
					'".$dtCart[$iRowCount]['cin_cinema_chain_name_extra']."', '".$dtCart[$iRowCount]['cin_cinema_hall_name_extra']."')
							";	
							
							//echo $strSql.'<br>';
							execute_query($strSql);
						}
						
                     $length=60;
                   ?>	
                  
                      <tr class="row_cinema" data-total_amount="<?php echo floatval($dtCart[$iRowCount]['calculation_rate']);?>" >
					  <td class="noExl" ><input data-hall_screen_branding_id="<?php echo $dtCart[$iRowCount]['hall_screen_branding_id'];?>" type="checkbox" value="<?php echo $dtCart[$iRowCount]['hall_screen_branding_id'];?>" class="checkbox" > </td>	
                      <td><?php echo $iRowCount+1; ?></td>                      
                      <td scope="row"><?php echo $dtCart[$iRowCount]['cin_state_name'];?></td>
                      <td scope="row"><?php echo $dtCart[$iRowCount]['cin_city_name'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cin_screen_type_name'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cin_cinema_chain_name'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cin_cinema_chain_name_extra'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cin_cinema_hall_name'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cin_cinema_hall_name_extra'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cinema_hall_screen_name'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cinema_hall_screen_total_seat'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['hall_screen_category_name'];?></td>
                      <td><?php echo $dtCart[$iRowCount]['cin_seconds_value'];?> sec <!--<a href="#" class="gb-btn-edit"></a>--></td>
                      <td><?php echo $duration_week;?> <!--<a href="#" class="gb-btn-edit"></a>--></td>
                      <td class="text-right"><i class="fas fa-rupee-sign"></i> <?php 
                      
                      //echo $row_tot=$dtCart[$iRowCount]['amount']*($length/10)*$duration;
                      echo $row_tot=floatval($dtCart[$iRowCount]['calculation_rate']);
                      $total_cart_price+=$row_tot;
                      
                      
                      ?></td>
                      <!--<td><a href="#" class="gb-btn-close">x</a></td>-->
                    </tr>
                    
                     <?php
                     $strCartSaveValue .= $strComma."{'hall_screen_branding_id':'".$dtCart[$iRowCount]['hall_screen_branding_id']."','cin_seconds_id':'".$dtCart[$iRowCount]['cin_seconds_id']."','final_price':'".$dtCart[$iRowCount]['calculation_rate']."','festive_week':'".$dtCart[$iRowCount]['festive_week_count']."','bb_week':'".$dtCart[$iRowCount]['bb_week_count']."','mbb_week':'".$dtCart[$iRowCount]['mbb_week_count']."'}";	
                     $strComma = ",";
                    }
                    $strCartSaveValue = "[".$strCartSaveValue."]";
                     ?>
                     <tr>
                     	<td class="noExl" ></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td ></td>
                        <td ></td>
                        <td >Total Amount</td>
                        <td class="text-right" id="td_total_amount" ><?php echo $total_cart_price;?></td> 
                     </tr>
                     
                    
                     
                     
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