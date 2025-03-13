<?php

namespace App\Http\Controllers;

use App\Models\Dbconfig;
use PDO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    public function index()
    {
        return view('configuration.database', [
            'database' => Dbconfig::first()
        ]);
    }

    public function testConDb(Request $request)
    {




        try {

            $host = $request->hostname;
            $port = $request->port;
            $database = $request->nom;
            $username = $request->username;
            $password = $request->password;

            //Cas d'une bd postgres
            if ($request->dbtype == 'pgsql') {
                $connectionString = "pgsql:host=$host;port=$port;dbname=$database;user=$username;password=$password";
            }

            //Cas d'une bd mysql
            if ($request->dbtype == 'mysql') {
                $connectionString = "mysql:host=$host;port=$port;dbname=$database;user=$username;password=$password";
            }

            $pdo = new PDO($connectionString);

            return response()->json(['success' => true, 'message' => 'Connexion reussie']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);

            die("Could not connect to the database. " . $e->getMessage());
        }
    }

    public function saveCon(Request $request)
    {
        if ($request->dbtype == 'pgsql') {

            $request->validate([
                'nom_postgres' => 'required',
                'hostname_postgres' => 'required',
                'port_postgres' => 'required',
                'username_postgres' => 'required',
                'password_postgres' => 'required',
            ]);
            $type = $request->dbtype;
            $host = $request->hostname_postgres;
            $port = $request->port_postgres;
            $database = $request->nom_postgres;
            $username = $request->username_postgres;
            $password = $request->password_postgres;

        }

        if ($request->dbtype == 'mysql') {

            $request->validate([
                'nom_mysql' => 'required',
                'hostname_mysql' => 'required',
                'port_mysql' => 'required',
                'username_mysql' => 'required',
                'password_mysql' => 'required',
            ]);
            $type = $request->dbtype;
            $host = $request->hostname_mysql;
            $port = $request->port_mysql;
            $database = $request->nom_mysql;
            $username = $request->username_mysql;
            $password = $request->password_mysql;
        }


        try {
            $conn = new Dbconfig();
            $conn->host = $host;
            $conn->port = $port;
            $conn->database = $database;
            $conn->username = $username;
            $conn->password = $password;
            $conn->save();
            return redirect()->route('app_config_index')->with('success', "Enregistrement effectue");
        } catch (\Throwable $th) {
            return redirect()->route('app_config_index')->with('error', "Enregistrement non effectue");
        }
    }
}
