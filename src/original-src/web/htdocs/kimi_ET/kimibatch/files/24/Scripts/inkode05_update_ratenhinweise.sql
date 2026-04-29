update ticket t
inner join inkode on inkode.id = t.ticketnr
set 
dummy_text6 = concat('Mind.RH.: ',
 case 
     when dummy_number4 <= 200 then round(dummy_number4 / 5,0)
     when dummy_number4 < 1000 then round(100,0)
     when dummy_number4 < 2500 then round(200,0)
     when dummy_number4 < 4000 then round(250,0) 
     when dummy_number4 < 10000 then round(450,0)
     when dummy_number4 >= 2500 then round(500,0)     
     else 0
	end,
 ' Mind.RANZ.: ',
   case 
     when dummy_number4 <= 200 then 5
     when dummy_number4 < 1000 then round(dummy_number4/100,0)
     when dummy_number4 < 2500 then round(dummy_number4/200,0)
     when dummy_number4 < 4000 then round(dummy_number4/250,0) 
     when dummy_number4 < 10000 then round(dummy_number4/450,0)
     when dummy_number4 >= 2500 then round(dummy_number4/500,0)
     else 0
	end 
    ) , 
dummy_text7 = case 
when inkode.rh > 0 then 'Ratenstundung' 
else concat('SEPA unter RH = ', round(dummy_number4/10,0),' bei Ranz = 10 einfordern, sonst anbieten') end ,
dummy_text16 = concat(LPAD(truncate(indexa,0), 5, '0'),' ',LPAD(truncate(indexb,0), 10, '0'),' ',LPAD(truncate(indexc,0), 4, '0'))

where t.mandant_id = 24 and t.status_id in (103,104) and beginn >= curdate()