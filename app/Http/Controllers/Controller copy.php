<?php

namespace App\Http\Controllers;

use PDO;
use App\Models\Dbconfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $connDb;

    public function __construct()
    {
        try {
             //Recuperation de la chaine de connexion
            $connexion = Dbconfig::first();
            if ($connexion) {
                $databaseConfig = config('database.connections.app2');

                $databaseConfig['driver'] = $connexion->connection;
                $databaseConfig['host'] = $connexion->host;
                $databaseConfig['port'] = $connexion->port;
                $databaseConfig['database'] = $connexion->database;
                $databaseConfig['username'] = $connexion->username;
                $databaseConfig['password'] = $connexion->password;

                //Update the database configuration
                Config::set('database.connections.app2', $databaseConfig);

                //definir la connexion pour les controlleurs filles
                return 'app2';
            }else {
                return redirect()->route('home')->with('errorMessage',"Impossible de se connecter a la base");
            }
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('errorMessage',"Impossible de se connecter a la base");

        }

    }
}
