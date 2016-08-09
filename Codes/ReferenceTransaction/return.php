<?php
//URL: http://127.0.0.1/paypal/retorno.php

if ( isset( $_GET[ 'token' ] ) ) {
	$token = $_GET[ 'token' ];

	$nvp = array(
		'TOKEN'								=> $token,
		'METHOD'							=> 'CreateBillingAgreement',
		'VERSION'							=> '73.0', 
		'PWD'								=> '',
		'USER'								=> '',
		'SIGNATURE'							=> '', 
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
