<?php

 class Dbbl_transaction{
 
	public function get_info_by_trxid($transaction_id)
	{
		
		 $userid='J5yvzlJcD46bYgs58TVTKw==';
		 $pasword='kR1avXwWlMXMrJIJYKLNsA==';
		 
		 $ch = curl_init();  
	 	 curl_setopt($ch, CURLOPT_URL, 'http://mbsrv.dutchbanglabank.com/rajshahicollege/checktxn'); 
	     curl_setopt($ch, CURLOPT_POSTFIELDS,'userid='.urlencode($userid).'&Password='.urlencode($pasword).'&txn_id='.urlencode($transaction_id));  
	 	 curl_setopt($ch, CURLOPT_POST, 1);  
    	 curl_setopt($ch, CURLOPT_HEADER, 0);  
    	 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
     	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
     	 curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");  
    	 curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");  
     	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
     	 curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");  
     	$st=curl_exec($ch);  
		$str=strip_tags($st,'');
		
		$trasaction=explode(",",$str);
		
		if(count($trasaction)>1){
		$transaction_array['response']="ok";
		$transaction_array['trx_id']=$trasaction[0];
		$transaction_array['bill_id']=$trasaction[1];
		$transaction_array['amount']=$trasaction[2];
		$transaction_array['payment_date']=$trasaction[3];	
		}
		else
		{
			$transaction_array['response']="Error";
		}
		return $transaction_array;		
	}	
}


?>