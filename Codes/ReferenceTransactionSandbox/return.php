<?php
//URL: http://127.0.0.1/paypal/retorno.php

if ( isset( $_GET[ 'token' ] ) ) {
	$token = $_GET[ 'token' ];

	$nvp = array(
		'TOKEN'								=> $token,
		'METHOD'							=> 'CreateBillingAgreement',
		'VERSION'							=> '73.0', 
		'PWD'								=> 'RLY6TABZ22W5D9TF',
		'USER'								=> 'rogevaldo_api1.teste.com.br',
		'SIGNATURE'							=> 'AFmo4dxYT0rBHMMEUZ8BKpKD5.KjAhDQFdsNjYka9sPcB3yegjynhPcU', 
	);

	$curl = curl_init();

	curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.sandbox.paypal.com/nvp' );
	curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
	curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
	curl_setopt( $curl , CURLOPT_POST , 1 );
	curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

	$response = urldecode( curl_exec( $curl ) ); 
	$responseNvp = array();
	
	if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
		foreach ( $matches[ 'name' ] as $offset => $name ) {
			$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
		}
	}
   echo $response;
	curl_close( $curl );
}