<?php
$total = '0.5'; //Total do carrinho do cliente

$nvp = array(

	'LOCALECODE'                        => 'pt_BR',
    	'L_BILLINGAGREEMENTDESCRIPTION0'    => 'Aqui você fará o acordo com a Safer Taxi. Nenhum valor será debitado', 
    	'L_BILLINGTYPE0'		    => 'MerchantInitiatedBillingSingleAgreement',
	'AMT'                               => '0',
    	'L_PAYMENTTYPE0'           	    => 'Any',
	'TAXIDTYPE'                         => 'BR_CPF',
	'TAXIDDETAILS'                      => '39717205876',
	'RETURNURL'			    => 'http://127.0.0.1/ReferenceTransaction/return.php',
	'CANCELURL'			    => 'http://127.0.0.1/ReferenceTransaction/checkout.php',
	'METHOD'			    => 'SetExpressCheckout',
	'VERSION'			    => '73.0',
	'PWD'				    => '',
	'USER'				    => '',
	'SIGNATURE'			    => '', 

);

$curl = curl_init();

curl_setopt( $curl , CURLOPT_URL , 'https://api-3t.paypal.com/nvp' );
curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );
curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );
curl_setopt( $curl , CURLOPT_POST , 1 );
curl_setopt( $curl , CURLOPT_POSTFIELDS , http_build_query( $nvp ) );

$response = urldecode( curl_exec( $curl ) );

curl_close( $curl );

$responseNvp = array();

if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
	foreach ( $matches[ 'name' ] as $offset => $name ) {
		$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
	}
}

if ( isset( $responseNvp[ 'ACK' ] ) && $responseNvp[ 'ACK' ] == 'Success' ) {
	$paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
	$query = array(
		'cmd'	=> '_customer-billing-agreement',
		'token'	=> $responseNvp[ 'TOKEN' ]
	);
 
	header( 'Location: ' . $paypalURL . '?' . http_build_query( $query ) );
} else {
	echo $response;
}
