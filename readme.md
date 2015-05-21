#Minecraft Live Player List

![Minecraft Live Player List Web Interface Screenshot](http://i.imgur.com/Pfnbzq7.png)

##About:

Minecraft Live Player List allows you host a website that displays currently active players as well as an offline list of recent players. The website interface automatically stays up to date and plays a sound as soon as a new player joins your server. The online player count is also mirrored as a badge in the favicon.

The goal is to encourage a small player base to play together. Unlike most Minecraft server dependend web-sites, this one works with vanilla Minecraft and doesn’t require you to install any mods on your server as all the required data is gathered from protocols and files that are provided by the game.

__You can check out a [live version here](http://minecraft.rene-henrich.de/).__

The current version works with Minecraft 1.8.X and is not likely to break with future updates.

##Usage:

The script needs to run on the same system that runs your Minecraft server. Be sure to have 'server-query' set to 'true' in your Minecraft server settings. After uploading all the files, you need to change the permission of player-cache.json to 777 and adjust the settings in player-query.php and main.js. The script needs to access the /playerdata folder inside your Minecraft world folder.

After setup, I recommend to run /player-query.php?limit=20 in your browser before opening index.php since the script needs to cache the offline player names before it can operate properly. Caching the player names can take up to 2 seconds per player on the first launch, so adjust the request limit to fit your needs / patience.

##Licenses:

based on [PHP-Minecraft-Query by xPaw](https://github.com/xPaw/PHP-Minecraft-Query), licensed under [Creative Commons Attribution-NonCommercial-ShareAlike 3.0](http://creativecommons.org/licenses/by-nc-sa/3.0/).
