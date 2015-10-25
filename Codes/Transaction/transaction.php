<?php

  global $array_value = array ('200');
  echo $array_value[0];
  function transactions {
   $array_trx = array('O-55U71971XA197681N'); 
   return $array_trx;
   
   }
   
  function getTransactions   {
   $i = 0; 
   foreach ($array_trx as &$trx) { 
	Capture($trx, $array_value[i]);
	++$i; 
  }
  }
}

   function Capture($trx,$value) {
   $returnedValues= DoAuth($trx, $value);
   $authID = getValue($returnedValues, "AUTHORIZARIONID");
   DoCapture($authID, $value);
   }
   
   function DoAuth {
   $nvp = array(
    'PWD'								=> '5YZ84DLRSRU4QJH2',
	'USER'								=> 'joaodoteste_api1.testesa.com',
	'SIGNATURE'							=> 'AsxdzKPWzf4KFodvg-JEhS3kJER7AP8ZgsumemtDEsuF8V2ckmy.77br', 
    'TRANSACTIONID'                     => $trx,
	'CURRENCYCODE'		                => 'BRL',
	'LOCALECODE'                        => 'pt_BR',
	'AMT'				                => $value, 
	'METHOD'							=> 'DoAuthorization',
	'VERSION'							=> '73.0',
	
);
	$curl = curl_init();

	curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.sandbox.paypal.com/nvp' );
	curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
	curl_setopt( $curl , CURLOPT_POST , 1 );
	curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

	$response = urldecode( curl_exec( $curl ) );

	curl_close( $curl );
    $responseNvp = array();
	
	$intial=0; 

		while(strlen($responseNvp))
		{
			//postion of Key
			$keypos= strpos($responseNvp,'=');
			//position of value
			$valuepos = strpos($responseNvp,'&') ? strpos($responseNvp,'&'): strlen($responseNvp);

			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($responseNvp,$intial,$keypos);
			$valval=substr($responseNvp,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$responseNvp[urldecode($keyval)] =urldecode( $valval);
			$responseNvp=substr($responseNvp,$valuepos+1,strlen($responseNvp));
	     }
		return $responseNvp;
		 echo $responseNvp;
	}

	
  
   function DoCapture { 
  $nvp2 = array(
    'PWD'								=> 'PASSWORD-API',
	'USER'								=> 'USER-API',
	'SIGNATURE'							=> 'SIGNATURE-API', 
    'AUTHORIZATIONID'                   => $authID,
	'CURRENCYCODE'		                => 'BRL',
	'LOCALECODE'                        => 'pt_BR',
	'AMT'				                => $value, 
	'METHOD'							=> 'DoCapture',
	'VERSION'							=> '73.0',
	'COMPLETETYPE'                      => 'COMPLETE',
	
);
	$curl2 = curl_init();

	curl_setopt( $curl2 , CURLOPT_URL , 'https://api-3t.sandbox.paypal.com/nvp' );
	curl_setopt( $curl2 , CURLOPT_SSL_VERIFYPEER , false );
	curl_setopt( $curl2 , CURLOPT_RETURNTRANSFER , 1 );
	curl_setopt( $curl2 , CURLOPT_POST , 1 );
	curl_setopt( $curl2 , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

	$response2 = urldecode( curl_exec( $curl2 ) );

	curl_close( $curl2 );
    $responseNvp2 = array();
   echo $responseNvp2;
   } 
?>