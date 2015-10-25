<?php
$total = '0.5'; //Total do carrinho do cliente

$nvp = array(

	'LOCALECODE'                        => 'pt_BR',
    'L_BILLINGAGREEMENTDESCRIPTION0'    => 'Convenio entre taxista e ZapTaxi', 
    'L_BILLINGTYPE0'			        => 'MerchantInitiatedBillingSingleAgreement',
    'L_PAYMENTTYPE0'           			=> 'Any',
	'AMT'                               => '0',
	'RETURNURL'							=> 'http://127.0.0.1/ReferenceTransactionSandbox/return.php',
	'CANCELURL'							=> 'http://127.0.0.1/ReferenceTransactionSandbox/exemplo.php',
	//'TAXIDTYPE'                         => 'BR_CPF', 
	//'TAXIDDETAILS'                      => '12332123455',
	'METHOD'							=> 'SetExpressCheckout',
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
curl_close( $curl );

$responseNvp = array();

if ( preg_match_all( '/(?<name>[^\=]+)\=(?<value>[^&]+)&?/' , $response , $matches ) ) {
	foreach ( $matches[ 'name' ] as $offset => $name ) {
		$responseNvp[ $name ] = $matches[ 'value' ][ $offset ];
	}
}

if ( isset( $responseNvp[ 'ACK' ] ) && $responseNvp[ 'ACK' ] == 'Success' ) {
	$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	$query = array(
		'cmd'	=> '_customer-billing-agreement',
		'token'	=> $responseNvp[ 'TOKEN' ]
	);
 
	header( 'Location: ' . $paypalURL . '?' . http_build_query( $query ) );
	
} else {
	echo $response;
}