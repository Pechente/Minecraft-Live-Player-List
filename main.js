var notificationSound = new Audio('notification.mp3')
var onlineList = ''
var offlineList = ''

var playerCount = 0
var oldPlayerCount = 0

var timesRun = 0

var favicon=new Favico({
    bgColor : '#3083b7',
    textColor : '#fff',
    animation:'pop'
});

var refreshInterval = 5;

//load settings from file
$.getJSON( "settings.json", function( data ) {
  refreshInterval = parseInt(data.refreshInterval)
});

$(document).ready(function(){
  loadPlayers()
});

function loadPlayers() {

  onlineList = ''
  offlineList = ''

  $.getJSON( "player-query.php", function( data ) {

    playerCount = 0

    $.each( data, function( i, response ) {
      if(response.lastonline == 'online') {
        onlineList += "<li><img src='https://minotar.net/avatar/" + response.name + "/16' alt='"+ response.name +"'/><p class='playername'>"+ response.name +"</p></li>"

        playerCount++
      }
      else {
        offlineList += "<li><img src='https://minotar.net/avatar/" + response.name + "/16' alt='"+ response.name +"'/><p class='playername'>"+ response.name +"</p><p class='lastseen'>"+ $.timeago(response.lastonline) +"</p></li>"
      }
    });

    if(oldPlayerCount != playerCount || timesRun === 0) {

      $( '.online' ).empty()
      $( '.online' ).append(onlineList)

      $( '.offline' ).empty()
      $( '.offline' ).append(offlineList)

      $( '.onlinePlayers' ).empty()
      $( '.onlinePlayers' ).append(playerCount)

      favicon.badge(playerCount)

      if (playerCount > oldPlayerCount && timesRun != 0 && $('#muteswitch').is(':checked')) {
        notificationSound.play()
      }
    }

    if(timesRun % 12) {
      $( '.offline' ).empty()
      $( '.offline' ).append(offlineList)
    }

    oldPlayerCount = playerCount
    timesRun += 1;
  });

  setTimeout("loadPlayers()", refreshInterval*1000);
}
