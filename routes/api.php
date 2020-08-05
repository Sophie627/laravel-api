<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1.1', 'middleware' => ['auth.basic', 'cors', 'throttle:120']],
    function () {
        Route::get('/game/{id}/blocks', 'GameController@blocks');
        Route::get('/game/{id}/charts', 'GameController@charts');
        Route::get('/game/{id}/conversions', 'GameController@conversions');
        Route::get('/game/{id}/fgxps', 'GameController@fgxps');
        Route::get('/game/{id}/fumbles', 'GameController@fumbles');
        Route::get('/game/{id}/injuries', 'GameController@injuries');
        Route::get('/game/{id}/interceptions', 'GameController@interceptions');
        Route::get('/game/{id}/kickoffs', 'GameController@kickoffs');
        Route::get('/game/{id}/snaps', 'GameController@snaps');
        Route::get('/game/{id}/passing', 'GameController@passing');
        Route::get('/game/{id}/penalties', 'GameController@penalties');
        Route::get('/game/{id}/punts', 'GameController@punts');
        Route::get('/game/{id}/rushing', 'GameController@rushing');
        Route::get('/game/{id}/sacks', 'GameController@sacks');
        Route::get('/game/{id}/safeties', 'GameController@safeties');
        Route::get('/game/{id}/tackles', 'GameController@tackles');
        Route::get('/game/{id}/touchdowns', 'GameController@touchdowns');

        Route::get('/games/{id}/defense', 'GamesController@defense');
        Route::get('/games/{id}/drives', 'GamesController@drives');
        Route::get('/games/{id}/kickers', 'GamesController@kickers');
        Route::get('/games/{id}/offense', 'GamesController@offense');
        Route::get('/games/{id}/plays', 'GamesController@plays');
        Route::get('/games/{id}/redzone', 'GamesController@redzone');
        Route::get('/games/{id}/teams', 'GamesController@teams');
        Route::get('/games/{id}/blocks', 'GamesController@blocks');
        Route::get('/games/{id}/charts', 'GamesController@charts');
        Route::get('/games/{id}/conversions', 'GamesController@conversions');
        Route::get('/games/{id}/fgxps', 'GamesController@fgxps');
        Route::get('/games/{id}/fumbles', 'GamesController@fumbles');
        Route::get('/games/{id}/injuries', 'GamesController@injuries');
        Route::get('/games/{id}/interceptions', 'GamesController@interceptions');
        Route::get('/games/{id}/kickoffs', 'GamesController@kickoffs');
        Route::get('/games/{id}/snaps', 'GamesController@snaps');
        Route::get('/games/{id}/passing', 'GamesController@passing');
        Route::get('/games/{id}/penalties', 'GamesController@penalties');
        Route::get('/games/{id}/punts', 'GamesController@punts');
        Route::get('/games/{id}/rushing', 'GamesController@rushing');
        Route::get('/games/{id}/sacks', 'GamesController@sacks');
        Route::get('/games/{id}/safeties', 'GamesController@safeties');
        Route::get('/games/{id}/tackles', 'GamesController@tackles');
        Route::get('/games/{id}/touchdowns', 'GamesController@touchdowns');

        Route::get('/player/{id}/defense', 'PlayerController@defense');  // ?mode=detailed
        Route::get('/player/{id}/kickers', 'PlayerController@kickers');
        Route::get('/player/{id}/offense', 'PlayerController@offense');  // ?mode=detailed
        Route::get('/player/{id}/redzone', 'PlayerController@redzone');
        Route::get('/player/{id}/blocks', 'PlayerController@blocks');
        Route::get('/player/{id}/charts', 'PlayerController@charts');
        Route::get('/player/{id}/conversions', 'PlayerController@conversions');
        Route::get('/player/{id}/fgxp', 'PlayerController@fgxp');
        Route::get('/player/{id}/fumbles', 'PlayerController@fumbles');
        Route::get('/player/{id}/interceptions', 'PlayerController@interceptions');
        Route::get('/player/{id}/kickoffs', 'PlayerController@kickoffs');
        Route::get('/player/{id}/passing', 'PlayerController@passing');
        Route::get('/player/{id}/penalties', 'PlayerController@penalties');
        Route::get('/player/{id}/punts', 'PlayerController@punts');
        Route::get('/player/{id}/rushing', 'PlayerController@rushing');
        Route::get('/player/{id}/sacks', 'PlayerController@sacks');
        Route::get('/player/{id}/safeties', 'PlayerController@safeties');
        Route::get('/player/{id}/snaps', 'PlayerController@snaps');
        Route::get('/player/{id}/tackles', 'PlayerController@tackles');
        Route::get('/player/{id}/touchdowns', 'PlayerController@touchdowns');
        Route::get('/player/{id}/injuries', 'PlayerController@injuries');

        Route::resource('/defense', 'DefenseController');                     // defense/{gid}
        Route::resource('/drives', 'DrivesController');                       // drives/{gid} or: drives/{tname} ?count=xxx ?start=xxx (when using tname)
        Route::resource('/kickers', 'KickersController');                     // kickers/{gid}
        Route::resource('/snaps', 'SnapsController');                         // snaps/{gid}
        Route::resource('/offense', 'OffenseController');                     // offense/{gid}
        Route::resource('/redzone', 'RedzoneController');                     // redzone/{gid}
        Route::resource('/teams', 'TeamsController');                         // teams/{gid} or: teams/{tname} ?count=xxx ?start=xxx (when using tname) || ?mode=detailed for teams/{tname} as well
        Route::resource('/game', 'GameController');                           // game/{id}
        Route::resource('/games', 'GamesController');                         // games/{year} or: games/{v or h}
        Route::resource('/player', 'PlayerController');                       // player/{id} or: player/{first_last}
        Route::resource('/plays', 'PlaysController');                         // plays/{gid} ?mode=expanded ?mode=flat
        Route::resource('/players', 'PlayersController');                     // returns all players or only active: ?status=active or players/{team} || ?mode=basic returns player/fname/lname only
        Route::resource('/schedule', 'ScheduleController');                   // returns schedule
        Route::resource('/league', 'LeagueController');                       // returns list of teams and their details
    });

Route::group(['prefix' => 'v1.1/test', 'middleware' => ['test.database', 'throttle:120']],
    function () {
        Route::get('/game/{id}/blocks', 'GameController@blocks');
        Route::get('/game/{id}/charts', 'GameController@charts');
        Route::get('/game/{id}/conversions', 'GameController@conversions');
        Route::get('/game/{id}/fgxps', 'GameController@fgxps');
        Route::get('/game/{id}/fumbles', 'GameController@fumbles');
        Route::get('/game/{id}/injuries', 'GameController@injuries');
        Route::get('/game/{id}/interceptions', 'GameController@interceptions');
        Route::get('/game/{id}/kickoffs', 'GameController@kickoffs');
        Route::get('/game/{id}/snaps', 'GameController@snaps');
        Route::get('/game/{id}/passing', 'GameController@passing');
        Route::get('/game/{id}/penalties', 'GameController@penalties');
        Route::get('/game/{id}/punts', 'GameController@punts');
        Route::get('/game/{id}/rushing', 'GameController@rushing');
        Route::get('/game/{id}/sacks', 'GameController@sacks');
        Route::get('/game/{id}/safeties', 'GameController@safeties');
        Route::get('/game/{id}/tackles', 'GameController@tackles');
        Route::get('/game/{id}/touchdowns', 'GameController@touchdowns');

        Route::get('/games/{id}/defense', 'GamesController@defense');
        Route::get('/games/{id}/drives', 'GamesController@drives');
        Route::get('/games/{id}/kickers', 'GamesController@kickers');
        Route::get('/games/{id}/offense', 'GamesController@offense');
        Route::get('/games/{id}/plays', 'GamesController@plays');
        Route::get('/games/{id}/redzone', 'GamesController@redzone');
        Route::get('/games/{id}/teams', 'GamesController@teams');
        Route::get('/games/{id}/blocks', 'GamesController@blocks');
        Route::get('/games/{id}/charts', 'GamesController@charts');
        Route::get('/games/{id}/conversions', 'GamesController@conversions');
        Route::get('/games/{id}/fgxps', 'GamesController@fgxps');
        Route::get('/games/{id}/fumbles', 'GamesController@fumbles');
        Route::get('/games/{id}/injuries', 'GamesController@injuries');
        Route::get('/games/{id}/interceptions', 'GamesController@interceptions');
        Route::get('/games/{id}/kickoffs', 'GamesController@kickoffs');
        Route::get('/games/{id}/snaps', 'GamesController@snaps');
        Route::get('/games/{id}/passing', 'GamesController@passing');
        Route::get('/games/{id}/penalties', 'GamesController@penalties');
        Route::get('/games/{id}/punts', 'GamesController@punts');
        Route::get('/games/{id}/rushing', 'GamesController@rushing');
        Route::get('/games/{id}/sacks', 'GamesController@sacks');
        Route::get('/games/{id}/safeties', 'GamesController@safeties');
        Route::get('/games/{id}/tackles', 'GamesController@tackles');
        Route::get('/games/{id}/touchdowns', 'GamesController@touchdowns');

        Route::get('/player/{id}/defense', 'PlayerController@defense');  // ?mode=detailed
        Route::get('/player/{id}/kickers', 'PlayerController@kickers');
        Route::get('/player/{id}/offense', 'PlayerController@offense');  // ?mode=detailed
        Route::get('/player/{id}/redzone', 'PlayerController@redzone');
        Route::get('/player/{id}/blocks', 'PlayerController@blocks');
        Route::get('/player/{id}/charts', 'PlayerController@charts');
        Route::get('/player/{id}/conversions', 'PlayerController@conversions');
        Route::get('/player/{id}/fgxp', 'PlayerController@fgxp');
        Route::get('/player/{id}/fumbles', 'PlayerController@fumbles');
        Route::get('/player/{id}/interceptions', 'PlayerController@interceptions');
        Route::get('/player/{id}/kickoffs', 'PlayerController@kickoffs');
        Route::get('/player/{id}/passing', 'PlayerController@passing');
        Route::get('/player/{id}/penalties', 'PlayerController@penalties');
        Route::get('/player/{id}/punts', 'PlayerController@punts');
        Route::get('/player/{id}/rushing', 'PlayerController@rushing');
        Route::get('/player/{id}/sacks', 'PlayerController@sacks');
        Route::get('/player/{id}/safeties', 'PlayerController@safeties');
        Route::get('/player/{id}/snaps', 'PlayerController@snaps');
        Route::get('/player/{id}/tackles', 'PlayerController@tackles');
        Route::get('/player/{id}/touchdowns', 'PlayerController@touchdowns');
        Route::get('/player/{id}/injuries', 'PlayerController@injuries');

        Route::resource('/defense', 'DefenseController');                     // defense/{gid}
        Route::resource('/drives', 'DrivesController');                       // drives/{gid} or: drives/{tname} ?count=xxx ?start=xxx (when using tname)
        Route::resource('/kickers', 'KickersController');                     // kickers/{gid}
        Route::resource('/snaps', 'SnapsController');                         // snaps/{gid}
        Route::resource('/offense', 'OffenseController');                     // offense/{gid}
        Route::resource('/redzone', 'RedzoneController');                     // redzone/{gid}
        Route::resource('/teams', 'TeamsController');                         // teams/{gid} or: teams/{tname} ?count=xxx ?start=xxx (when using tname) || ?mode=detailed for teams/{tname} as well
        Route::resource('/game', 'GameController');                           // game/{id}
        Route::resource('/games', 'GamesController');                         // games/{year} or: games/{v or h}
        Route::resource('/player', 'PlayerController');                       // player/{id} or: player/{first_last}
        Route::resource('/plays', 'PlaysController');                         // plays/{gid} ?mode=expanded ?mode=flat
        Route::resource('/players', 'PlayersController');                     // returns all players or only active: ?status=active or players/{team} || ?mode=basic returns player/fname/lname only
        Route::resource('/schedule', 'ScheduleController');                   // returns schedule
        Route::resource('/league', 'LeagueController');                       // returns list of teams and their details
    });
