<?php


$nvp = array(

	'STARTDATE'                         => '2012-01-20T00:00:00Z',
	'ENDDATE'							=> '2012-02-23T023:59:59Z',
	'RECEIVER'              			=> 'fasilva@paypal.com',
    //'AMT'    						    => '1', 
    'CURRENCYCODE'                      => 'BRL',
  	'METHOD'							=> 'TransactionSearch',
	'VERSION'							=> '73.0',
	'PWD'								=> 'N3VULNC5KXXX77ED',
	'USER'								=> 'fasilva_api1.paypal.com',
	'SIGNATURE'							=> 'AFcWxV21C7fd0v3bYYYRCpSSRl31A6dTscbyIFaXQ9Rlb5t3OkCqeBtj', 


);

$curl = curl_init();

curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.paypal.com/nvp' );
curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
curl_setopt( $curl , CURLOPT_POST , 1 );
curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

$response = urldecode( curl_exec( $curl ) );
echo $response; 
curl_close( $curl );
 





