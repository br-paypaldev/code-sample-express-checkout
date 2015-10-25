<?php
//URL: http://127.0.0.1/paypal/retorno.php

if ( isset( $_GET[ 'token' ] ) ) {
	$token = $_GET[ 'token' ];

	$nvp = array(
		'TOKEN'								=> $token,
		'METHOD'							=> 'CreateBillingAgreement',
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
	
	$responseNvp = array();
	 

	if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
		foreach ( $matches[ 'name' ] as $offset => $name ) {
			$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
		}
	}

   	curl_close( $curl );
}