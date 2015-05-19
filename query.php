<?php
	use xPaw\MinecraftQuery;
	use xPaw\MinecraftQueryException;

	// Edit this ->
	define( 'MQ_SERVER_ADDR', 'localhost' );
	define( 'MQ_SERVER_PORT', 25565 );
	define( 'MQ_TIMEOUT', 1 );
	// Edit this <-

	// Display everything in browser, because some people can't look in logs for errors
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', true );

	require __DIR__ . '/src/MinecraftQuery.php';
	require __DIR__ . '/src/MinecraftQueryException.php';

	$Timer = MicroTime( true );

	$Query = new MinecraftQuery( );

	try
	{
		$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	}
	catch( MinecraftQueryException $e )
	{
		$Exception = $e;
	}

	$Timer = Number_Format( MicroTime( true ) - $Timer, 4, '.', '' );
?>

<?

header('Content-type: application/json; charset=utf-8');

$json = array();

if( ( $Players = $Query->GetPlayers( ) ) !== false ):
foreach( $Players as $Player ):
  $json[] = array(
    'player'   => htmlspecialchars( $Player ),
  );
endforeach;
else:
endif;

echo json_encode($json);

?>
