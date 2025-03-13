<?php

namespace App\Helpers;

use App\Mail\ExportMail;
use App\Mail\RecapMail;
use App\Models\Acl;
use App\Models\Menu;
use App\Models\Recap\RecapParams;
use App\Models\Role;
use App\Models\SBA\Bkcli;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Helper
{

    public static function sendMail($title, $message, $filename = null, $emails = [], $ccs = [], $bcc = [])
    {
        try {
            $maildata = [
                'title' => $title,
                'message' => $message,
                'filename' => $filename,
            ];
            Mail::to($emails)->cc($ccs)->bcc($bcc)->send(new ExportMail($maildata));
            Log::info("MAIL SENDIND SUCCEED " . json_encode($emails));
        } catch (\Throwable $ex) {
            Log::info($ex);
        }
    }

    public static function sendRecapMail($title, $message, $fileName, $path, $tos, $bcc, $disk, $type)
    {
        try {
            $maildata = [
                'title' => $title,
                'message' => $message,
                'filename' => $fileName,
                'path' => $path,
                'disk' => $disk,
                'type' => $type,
            ];

            Mail::to($tos)->bcc($bcc)->send(new RecapMail($maildata));
            Log::channel('recap')->info("MAIL SENDIND SUCCEED " . json_encode($tos));

            return ['status' => 'SUCCESS', 'motif' => "MAIL SENDIND SUCCEED " . json_encode($tos)];
        } catch (\Throwable $ex) {
            Log::info($ex);
        }
    }

    public static function mois($i)
    {
        $month = ['1' => 'JANVIER', '2' => 'FEVRIER', '3' => 'MARS', '4' => 'AVRIL', '5' => 'MAI', '6' => 'JUIN', '7' => 'JUILLET', '8' => 'AOUT', '9' => 'SEPTEMBRE', '10' => 'OCTOBRE', '11' => 'NOVEMBRE', '12' => 'DECEMBRE'];
        return $month[$i];
    }

    public static function previousMonth()
    {
        return Carbon::now()->subMonth()->endOfMonth()->format('d/m/Y');
    }

    public static function getMonth()
    {
        $monthNumber = Carbon::now()->format('m');
        $monthNumber = $monthNumber - 1;
        return self::mois($monthNumber);
    }

    public static function getYearDec()
    {
        return Carbon::now()->subMonth()->endOfMonth()->format('Y');
    }
    public static function getFirstAndLastDayOfPreviousMonth()
    {

        $firstDay = Carbon::now()->subMonth()->startOfMonth()->format('d/m/Y');
        $lastDay = Carbon::now()->subMonth()->endOfMonth()->format('d/m/Y');

        return [
            'first_day' => $firstDay,
            'last_day' => $lastDay,
        ];
    }

    public static function getYear()
    {
        $param = RecapParams::first();
        if ($param && isset($param->annee) && $param->annee != null) {
            return $param->annee;
        }
    }

    public static function getIntitule($search)
    {
        $maxRslt = 10;
        $query = Bkcli::where(function ($q) use ($search) {
            $q->whereRaw("lower(TRIM(cli)) like lower('%$search%')")
                ->orWhereRaw("lower(nomrest) like lower('%$search%')")
            ;
        });

        return $query->limit($maxRslt)->get(['cli as id', 'nomrest as text', 'cli', 'nomrest']);
    }

    public static function getActionsMenu($id)
    {
        $actions = Acl::where('menu_id', $id)->get();
        return $actions;
    }

    public static function getStatutHtml($statut, $delete)
    {
        $msg = '';

        switch ($statut) {
            case 0:
                $msg =
                    <<<EOT
                    <div class="badge badge-light-danger fw-bold">Attente d'activation</div>
                    EOT;
                break;

            case 1:
                $msg =  <<<EOT
                    <div class="badge badge-light-success fw-bold">Actif</div>
                    EOT;
                if ($delete == -1) $msg =  <<<EOT
                    <div class="badge badge-light-warning fw-bold">En attente de suppression</div>
                    EOT;
                break;

            default:
                $msg =  <<<EOT
                    <div class="badge badge-light-danger fw-bold">Statut inconnu</div>
                    EOT;
        }


        return $msg;
    }
}
