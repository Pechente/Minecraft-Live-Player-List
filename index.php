<?
//load settings from php file
include 'settings.php';

//load language support
include 'language_support/' . $settings['language'] . '.php';

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

define( 'MQ_SERVER_ADDR', 'localhost' );
define( 'MQ_SERVER_PORT', $settings['serverPort']);
define( 'MQ_TIMEOUT', 1 );

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

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300">
    <link rel="stylesheet" href="style.css">
    <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/favico.js/0.3.7/favico.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.1/jquery.timeago.min.js"></script>
		<script src="language_support/jquery.timeago.<? echo $settings['language'] ?>.js"></script>
    <script src="main.js"></script>
  </head>
  <body>
    <header>
      <img src="server-icon.png" alt="Dauerwurst Logo"/>
      <h1><? echo $settings['serverName'] ?></h1>
      <h2><? echo $HostName; ?></h2>
    </header>
    <main>
			<p class="status"><? echo $language['online'] ?></p>

			<ul class="online">
				<li><p class="playername">Please enable Javascript :(</p></li>
			</ul>
			<p class="status"><? echo $language['offline'] ?></p>

			<ul class="offline">
				<li><p class="playername">You’re stuck with this screen if you don’t. Yeah offline. That’s what you are!</p></li>
			</ul>
      <p class="connected"><span class="onlinePlayers"><? echo $OnlinePlayers ?></span>/<? echo $MaxPlayers . ' ' . $language['playersConnected'] ?></p>
    </main>
    <footer>
			<form>
				<input id="muteswitch" type="checkbox" name="sound" value="sound" checked> <? echo $language['muteSwitch'] ?></input>
			</form>
      <p>Minecraftia font by <a href="http://andrewtyler.net">Andrew Tyler</a>, free for personal use only.</p>
    </footer>
  </body>
</html>
