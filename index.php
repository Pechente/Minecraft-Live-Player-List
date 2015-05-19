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

	if( ( $Info = $Query->GetInfo( ) ) !== false ):
	foreach( $Info as $InfoKey => $InfoValue ):
							if($InfoKey == "HostName") {
								$HostName = $InfoValue;
							}

							else if($InfoKey == "Players") {
								$OnlinePlayers = $InfoValue;
							}

							else if($InfoKey == "MaxPlayers") {
								$MaxPlayers = $InfoValue;
							}
	endforeach;
	endif;
?>

<!DOCTYPE html>
<html lang="de">
  <head>
		<title><? echo $HostName; ?></title>
		<meta charset="utf-8" />
		<meta property="og:image" content="server-icon.png">

		<? /*
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
		*/?>

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300">
    <link rel="stylesheet" href="style.css">
    <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="favico-0.3.7.min.js"></script>
		<script src="jquery.timeago.js"></script>
    <script src="main.js"></script>
  </head>
  <body>
    <header>
      <img src="server-icon.png" alt="Dauerwurst Logo"/>
      <h1>Dauerwurst</h1>
      <h2><? echo $HostName; ?></h2>
    </header>
    <main>
			<p class="status">online</p>

			<ul class="online">
        <?php if( ( $Players = $Query->GetPlayers( ) ) !== false ): //?>
        <?php foreach( $Players as $Player ): ?>
                    <li>
										<? //The javascript-less site only has an online list using the simple API request - because lazy ?>
        							<img src="https://minotar.net/avatar/<?php echo htmlspecialchars( $Player ); ?>/16" alt="<?php echo htmlspecialchars( $Player ); ?>"/>
                      <p class="playername"><?php echo htmlspecialchars( $Player ); ?></p>
        						</li>
        <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
			</ul>
			<p class="status">offline</p>
			<ul class="offline">
			</ul>
      <p class="connected"><span class="onlinePlayers"><? echo $OnlinePlayers ?></span>/<? echo $MaxPlayers ?> Spielern verbunden.</p>
    </main>
    <footer>
      <p>Minecraft font by PurePixel</p>
    </footer>
  </body>
</html>
