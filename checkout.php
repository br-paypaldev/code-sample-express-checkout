<?php
$total = '0.5'; //Total do carrinho do cliente

/* Brazilian Parameters 
$nvp = array(

	'LOCALECODE'                        => 'pt_BR',
	'PAYMENTREQUEST_0_PAYMENTACTION'	=> 'Sale',
	'PAYMENTREQUEST_0_AMT'              => '40.00',
    'PAYMENTREQUEST_0_CURRENCYCODE'     => 'BRL', 
    'PAYMENTREQUEST_0_ITEMAMT'          => '40.00',
    'L_PAYMENTREQUEST_0_NAME0'          => 'Teste Daslu',
    'L_PAYMENTREQUEST_0_DESC0'          => 'Teste Daslu',
	'L_PAYMENTREQUEST_0_AMT0'          => '50.00',
	'L_PAYMENTREQUEST_0_NAME1'          => 'Desconto',
    'L_PAYMENTREQUEST_0_DESC1'          => 'Desconto',
	'L_PAYMENTREQUEST_0_AMT1'          => '-10.00',
	'RETURNURL'							=> 'http://127.0.0.1/pay pal/retorno.php',
	'CANCELURL'							=> 'http://127.0.0.1/pay pal/cancelamento.php',
	'METHOD'							=> 'SetExpressCheckout',
	'VERSION'							=> '73.0',
	'PAYMENTREQUEST_0_SHIPTOSTATE'      => '1', 
	'PWD'								=> 'A47996PH33FC364Y',
	'USER'								=> 'paypal_api1.plusnet.com.br',
	'SIGNATURE'							=> 'AISf05C3rGkslGCrURiBwna5xCjEA3wyEm2XLxQePiJzqn9TfuVQT.vu', 

);
*/

$nvp = array(
    'LOCALECODE'                        => 'en_US',
    'SUBJECT'                           => 'paypal2@tapiocacorp.com',
    'PAYMENTREQUEST_0_PAYMENTACTION'	=> 'Sale',
    'PAYMENTREQUEST_0_AMT'              => '40.00',
    'PAYMENTREQUEST_0_CURRENCYCODE'     => 'USD', 
    'PAYMENTREQUEST_0_ITEMAMT'          => '40.00',
    'L_PAYMENTREQUEST_0_NAME0'          => 'Teste Daslu',
    'L_PAYMENTREQUEST_0_DESC0'          => 'Teste Daslu',
    'L_PAYMENTREQUEST_0_AMT0'           => '50.00',
    'L_PAYMENTREQUEST_0_NAME1'          => 'Desconto',
    'L_PAYMENTREQUEST_0_DESC1'          => 'Desconto',
    'L_PAYMENTREQUEST_0_AMT1'           => '-10.00',
    'RETURNURL'                         => 'http://127.0.0.1/code-sample-express-checkout/retorno.php',
    'CANCELURL'				=> 'http://127.0.0.1/code-sample-express-checkout/cancelamento.php',
    'METHOD'				=> 'SetExpressCheckout',
    'VERSION'				=> '124',
    'PAYMENTREQUEST_0_SHIPTOSTATE'      => '1', 
    'PWD'				=> 'RM2563V97DB853B2',
    'USER'				=> 'paypal_api1.tapiocacorp.com',
    'SIGNATURE'				=> 'AFcWxV21C7fd0v3bYYYRCpSSRl31AyIQDAysZVi3HnR9JoqEZEjhx1rf' 
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
	$paypalURL = 'https://www.sandbox.paypal.com/br/cgi-bin/webscr';
	$query = array(
		'cmd'	=> '_express-checkout',
		'useraction' => 'commit', 
		'token'	=> $responseNvp[ 'TOKEN' ]
	);
 
	header( 'Location: ' . $paypalURL . '?' . http_build_query( $query ) );
} else {
	echo $response;
}