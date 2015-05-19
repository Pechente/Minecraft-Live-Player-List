<?
  //!!!! API SHIT DON’T TOUCH !!!!

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

//settings
$pathToPlayerFiles = '/home/minecraft/survival/Dauerwurst/playerdata/';

//get limit from URL
if(isset($_GET['limit'])){
  $limit = $_GET['limit'];
}

else {
  $limit = 20;
}

//get online players for later
$onlinePlayers = array();

if( ( $Players = $Query->GetPlayers( ) ) !== false ){
  foreach( $Players as $Player ){
    array_push($onlinePlayers, $Player);
  }
}

//get offline Players from file names and sort them
$files = glob($pathToPlayerFiles . '*.dat');
usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
});

//maybe limit $files to x results?
$files = array_slice($files, 0, $limit);

//get local json file for uuid -> playername
$playerCacheJson = file_get_contents("player-cache.json");
$playerCache = json_decode($playerCacheJson, true);

foreach( $files as $file ){

  //remove file extension and dashes to get clean uuid
  $uuid = basename($file, '.dat');
  $uuid = str_replace('-', '', $uuid);

  $playerIsCached = false;

  foreach ($playerCache as $playerData) {
    //if uuid is in array, assign it
    if($uuid == $playerData['uuid']) {
      $playerIsCached = true;
      $playerName = $playerData['name'];
    }
  }

  if($playerIsCached == false) {
    $json = file_get_contents('http://api.mcusername.net/pastuuid/' . $uuid);
  	$playerObj = json_decode($json);

    //assign player name
    $playerName = $playerObj[count($playerObj)-1]->name;

    //additionally, write player name to file for next time
    $playerCache[] = array(
      'name' => $playerName,
      'uuid' => $uuid
    );
    $playerCacheJson = json_encode($playerCache);
    file_put_contents('player-cache.json', $playerCacheJson);
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
  $playerList[] = array(
    'name'   => $playerName,
		'lastonline' => $lastonline
	);
}

//output dat shit
echo json_encode($playerList);

//get online Players
//substract from array, write into separate
//return json, online { player:}, offline {player: lastonline:}
