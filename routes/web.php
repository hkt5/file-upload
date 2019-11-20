<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/versions-all/{fileID}', 'GetAllVersionsController@getAllVersions');
$router->get('/version/{fileID}/{versionID}', 'GetVersionController@getVersion');
$router->get('/version-latest/{fileID}', 'GetLatestVersionController@getLatestVersion');
$router->get('/test', function(){ return view('file_uploader');});

$router->post('/upload-file', 'SaveFileInDataBaseController@saveFile');

$router->patch('/restore/file', 'RestoreFileController@restoreFile');

$router->delete('/delete-hard/file', 'HardDeleteFileController@hardDeleteFile');
$router->delete('/delete-soft/file', 'SoftDeleteFileController@softDeleteFile');
$router->delete('/delete/version', 'DeleteVersionController@deleteFileVersion');
