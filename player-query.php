<?
//load settings from json
$settingsJson = file_get_contents('settings.json');
$settings = json_decode($settingsJson);

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

header('Content-type: application/json; charset=utf-8');

//get limit from URL
if(isset($_GET['limit'])){
  $limit = $_GET['limit'];
}

else {
  $limit = $settings->listLength;
}

//get online players for later
$onlinePlayers = array();

if( ( $Players = $Query->GetPlayers( ) ) !== false ){
  foreach( $Players as $Player ){
    array_push($onlinePlayers, $Player);
  }
}

//get offline Players from file names and sort them
$files = glob($settings->pathToMinecraftRoot . $settings->worldName . '/playerdata/' . '*.dat');
usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
});

//limiting array to most recent x users
$files = array_slice($files, 0, $limit);

//get server-provided json file for uuid -> playername
$playerCacheJson = file_get_contents($settings->pathToMinecraftRoot . 'usercache.json');
$playerCache = json_decode($playerCacheJson, true);

foreach( $files as $file ){

  //remove file extension to get clean uuid
  $uuid = basename($file, '.dat');

  foreach ($playerCache as $playerData) {
    if($uuid == $playerData['uuid']) {
      $playerName = $playerData['name'];
    }
  }
  //check if player is online using array previously created
  $lastonline = date(DATE_ISO8601, filemtime($file));

  if(count($onlinePlayers) > 0){
    foreach($onlinePlayers as $onlinePlayer) {
      if ($onlinePlayer == $playerName) {
        $lastonline = 'online'; //
      }
    }
  }

	//finally write name and online time into array
  $playerList[] = array(
    'name'   => $playerName,
		'lastonline' => $lastonline
	);
}

//output dat shit
echo json_encode($playerList);
