#Minecraft Live Player List

![Minecraft Live Player List Web Interface Screenshot](http://i.imgur.com/S0MIvgE.png)

##About:

Minecraft Live Player List allows you host a website that displays currently active players as well as players that recently went offline. The web-interface always stays up to date and plays a sound as soon as a player joins your server. The online player count is mirrored as a badge in the favicon.

__You can check out a [live version here](http://minecraft.rene-henrich.de/).__

The goal is to encourage a small player base to play together. Unlike most Minecraft server dependend web-sites, this one works with vanilla Minecraft and doesn’t require you to install any mods on your server as all the required data is gathered from protocols and files that are provided by the game.

The current version works with Minecraft 1.8.X and is not likely to break with future updates.

##Usage:

1. The script needs to run on the same system that runs your Minecraft server.
2. Be sure to have _enable-query_ set to _true_ in your Minecraft _server.properties_.
3. The script will need to access _usercache.json_ and the _/playerdata_ folder inside your Minecraft world folder, so make sure it’s readable.
4. Upload all the files.
5. Adjust the settings in _settings.json_.
6. You’re done! You can now access index.php and check if everything’s working correctly.

##Disclaimer:

I developed this as a simple learning project and never planned to release this when I started with it. In its evolution, the code has undergone many changes and became dirty, redundant and probably has some unused variables. Don’t complain, submit a fix instead :)

##Licenses:

based on [PHP-Minecraft-Query by xPaw](https://github.com/xPaw/PHP-Minecraft-Query), licensed under [Creative Commons Attribution-NonCommercial-ShareAlike 3.0](http://creativecommons.org/licenses/by-nc-sa/3.0/).
