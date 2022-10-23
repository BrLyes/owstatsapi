# OWSTATSAPI

A simple API to store players stats in overwatch 2 (the game) powered by [laravel](https://laravel.com)

Stage version hosted on : https://api.stage.owstats.app/

##How it works

The user(player) first needs to create an account and then sends data to the game.store route with the game stats (kill, death, assist, etc...). The user can then query the API to get the stored stats.

###Supported stats
* kill
* death
* assist
* damage
* accuracy

###Stat aggregation it can return
* Stat overtime: selected stat between two dates (route("api-stat-ovt"));
* Stat sum: sum of one or multiple stats (route("api-stat-sum"))
* Stat average: average of one or multiple stats (route("api-stat-sum"))
* Stat for character: ALl stats for a specific character (route("api-stat-name"))


##Roadmap
This is still very early dev and here is list of upcoming changes: 
* Win/Lose/draw stat
* Healing/mitigation stat
* Critical accuracy stat
* Stat for new character (Sojourn)
* Specific stats support for character (example: Ashe => scored accuracy))
* Better readme
* and much more...
