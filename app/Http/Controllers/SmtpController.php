<?php

namespace App\Http\Controllers;

use App\Models\Dbconfig;
use App\Models\Smtp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Swift_Mailer;
use Swift_SmtpTransport;
use Symfony\Component\Mailer\Transport;

class SmtpController extends Controller
{
    public function index(): View
    {


        return view('configuration.smtp');
    }

    function test(Request $request)
    {
//        $request->validate([
//            'mailer' => 'required',
//            'hostname' => 'required',
//            'port' => 'required',
//            'username' => 'required',
//            'password' => 'required',
//            'encrypt' => 'required',
//            'address' => 'required',
//            'name' => 'required',
//        ]);

        try {
            // Remplacez les informations suivantes par les informations de votre serveur SMTP
            $mailer = $request->mailer;
            $smtpHost = $request->hostname;
            $smtpPort = $request->port;
            $smtpUsername = $request->username;
            $smtpPassword = $request->password;
            $encryption = $request->encrypt;
            $address = $request->address;
            $name = $request->name;

            // Configuration des paramètres SMTP
            config([
                'mail.mailers.smtp.host' => $smtpHost,
                'mail.mailers.smtp.port' => $smtpPort,
                'mail.mailers.smtp.username' => $smtpUsername,
                'mail.mailers.smtp.password' => $smtpPassword,
            ]);

            // Test de la connexion SMTP
            Mail::raw('Test SMTP Connection', function ($message) {
                $message->to('nabilkpossa51@gmail.com')->subject('SMTP Connection Test');
            });

            return response()->json(['success' => true, 'message' => 'Connexion SMTP reussie']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'La connexion SMTP a échoué. Erreur : ' . $e->getMessage()]);
        }
    }

    public function save(Request $request): RedirectResponse
    {

        $request->validate([
            'mailer' => 'required',
            'hostname' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encrypt' => 'required',
            'address' => 'required',
            'name' => 'required',
        ]);

        $mailer = $request->mailer;
        $hostname = $request->hostname;
        $port = $request->port;
        $username = $request->username;
        $password = $request->password;
        $encrypt = $request->encrypt;
        $address = $request->address;
        $name = $request->name;

        DB::beginTransaction();
        try {
            $conn = new Smtp();
            $conn->mailer = $mailer;
            $conn->host = $hostname;
            $conn->port = $port;
            $conn->username = $username;
            $conn->password = $password;
            $conn->encryption = $encrypt;
            $conn->address = $address;
            $conn->name = $name;
            $conn->save();
            DB::commit();
            return redirect()->route('app_smtp_index')->with('success', "Enregistrement effectué !");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('app_smtp_index')->with('error', "Enregistrement non effectué !");
        }
    }
}
