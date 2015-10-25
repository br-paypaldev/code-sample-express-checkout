<?php
//URL: http://127.0.0.1/paypal/retorno.php

if ( isset( $_GET[ 'token' ] ) ) {
	$token = $_GET[ 'token' ];

	$nvp = array(
		'TOKEN'		=> $token,
		'METHOD'	=> 'GetExpressCheckoutDetails',
		'VERSION'	=> '124.0', 
                'PWD'		=> 'RM2563V97DB853B2',
                'USER'		=> 'paypal_api1.tapiocacorp.com',
                'SIGNATURE'     => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AyIQDAysZVi3HnR9JoqEZEjhx1rf' 
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

	if ( isset( $responseNvp[ 'TOKEN' ] ) && isset( $responseNvp[ 'ACK' ] ) ) {
		if ( $responseNvp[ 'TOKEN' ] == $token && $responseNvp[ 'ACK' ] == 'Success' ) {
			$nvp[ 'PAYERID' ]			= $responseNvp[ 'PAYERID' ];
			$nvp[ 'PAYMENTREQUEST_0_AMT' ]		= $responseNvp[ 'PAYMENTREQUEST_0_AMT' ];
			$nvp[ 'PAYMENTREQUEST_0_CURRENCYCODE' ]	= $responseNvp[ 'PAYMENTREQUEST_0_CURRENCYCODE' ];
                        $nvp[ 'SUBJECT' ]                       = $responseNvp[ 'SUBJECT' ];
			$nvp[ 'METHOD' ]			= 'DoExpressCheckoutPayment';
			$nvp[ 'PAYMENTREQUEST_0_PAYMENTACTION' ]= 'SALE'; 
			curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

			$response = urldecode( curl_exec( $curl ) );
			$responseNvp = array();

			if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
				foreach ( $matches[ 'name' ] as $offset => $name ) {
					$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
				}
			}
			if ( $responseNvp[ 'PAYMENTINFO_0_PAYMENTSTATUS' ] == 'Completed' ) {
			  
				echo 'Parabéns, sua compra foi concluída com sucesso';
                                echo '<br />';
                                echo '<br />';
			} else {
				echo 'Não foi possível concluir a transação';
			}
		} else {
			echo 'Não foi possível concluir a transação';
		}
	} else {
		echo 'Não foi possível concluir a transação';
	}
   echo $response;
	curl_close( $curl );
}