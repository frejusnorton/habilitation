<?php


namespace App\Http\Controllers;

use DB;
use DateTime;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\PushTransaction;
use App\Models\MoovPushTransaction;
use App\Models\MtnPushErrors;
use App\Models\MoovPushErrors;
use Illuminate\Support\Facades\Route;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $transaction = PushTransaction::first();
        $data = [
            'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
            'mtn_b2w_ko' => $transaction->nombre_b2w_transactions_ko,
            'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
            'montant_b2w_ko' => number_format($transaction->montant_b2w_transactions_ko, 0, ' ', ' '),
            'datetime_b2w_ok' => (isset($transaction->datetime_transaction_b2w_ok) && strlen(trim($transaction->datetime_transaction_b2w_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_b2w_ok)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
            'datetime_b2w_ko' => (isset($transaction->datetime_transaction_b2w_ko) && strlen(trim($transaction->datetime_transaction_b2w_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_b2w_ko)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
            'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
            'mtn_w2b_ko' => $transaction->nombre_w2b_transactions_ko,
            'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
            'montant_w2b_ko' => number_format($transaction->montant_w2b_transactions_ko, 0, ' ', ' '),
            'datetime_w2b_ok' => (isset($transaction->datetime_transaction_w2b_ok) && strlen(trim($transaction->datetime_transaction_w2b_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_w2b_ok)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
            'datetime_w2b_ko' => (isset($transaction->datetime_transaction_w2b_ko) && strlen(trim($transaction->datetime_transaction_w2b_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_w2b_ko)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
        ];



        $now = Carbon::now();
        $is_b2w_ok_exceededMtn = false;
        $startDateb2wMtn = $transaction->datetime_transaction_b2w_ok != null ? DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_b2w_ok)->modify('+1 hour')->setTimezone(new DateTimeZone('GMT+1')) : '';


        if ($startDateb2wMtn) {
            $startDateb2wMtn = Carbon::parse($startDateb2wMtn);
            $minutesMtnB2W = $startDateb2wMtn->diffInMinutes($now);
        }


        $startDateW2bMtn = $transaction->datetime_transaction_w2b_ok ? DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_w2b_ok)->modify('+1 hour')->setTimezone(new DateTimeZone('GMT+1')) : '';

        $startDateW2bMtn = Carbon::parse($startDateW2bMtn);

        $minutesMtnW2b = $startDateW2bMtn->diffInMinutes($now);

        if ($minutesMtnB2W > 30 || $minutesMtnW2b > 30) {
            $is_b2w_ok_exceededMtn = true;
        }




        $transactionsMoov = MoovPushTransaction::all();
        $dataMoov = $transactionsMoov->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'mtn_b2w_ko' => $transaction->nombre_b2w_transactions_ko,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'montant_b2w_ko' => number_format($transaction->montant_b2w_transactions_ko, 0, ' ', ' '),
                'datetime_b2w_ok' => (isset($transaction->datetime_transaction_b2w_ok) && strlen(trim($transaction->datetime_transaction_b2w_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_b2w_ok)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
                'datetime_b2w_ko' => (isset($transaction->datetime_transaction_b2w_ko) && strlen(trim($transaction->datetime_transaction_b2w_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_b2w_ko)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'mtn_w2b_ko' => $transaction->nombre_w2b_transactions_ko,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
                'montant_w2b_ko' => number_format($transaction->montant_w2b_transactions_ko, 0, ' ', ' '),
                'datetime_w2b_ok' => (isset($transaction->datetime_transaction_w2b_ok) && strlen(trim($transaction->datetime_transaction_w2b_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_w2b_ok)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
                'datetime_w2b_ko' => (isset($transaction->datetime_transaction_w2b_ko) && strlen(trim($transaction->datetime_transaction_w2b_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_w2b_ko)->modify('+1 hour'))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i') : '',
            ];
        });

        //MOOV ALERTE
        $is_b2w_ok_exceededMoov = false;


        $startDateb2wMoov = $transaction->datetime_transaction_b2w_ok != null ? DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_b2w_ok)->modify('+1 hour')->setTimezone(new DateTimeZone('GMT+1')) : '';

        $startDateb2wMoov = Carbon::parse($startDateb2wMtn);


        $startDateW2bMoov =$transaction->datetime_transaction_w2b_ok != null ? DateTime::createFromFormat('d/m/Y H:i', $transaction->datetime_transaction_w2b_ok)->modify('+1 hour')->setTimezone(new DateTimeZone('GMT+1')) : '';

        $startDateW2bMoov = Carbon::parse($startDateW2bMtn);

        $minutesMoovB2W = $startDateb2wMoov->diffInMinutes($now);
        $minutesMoovW2b = $startDateW2bMoov->diffInMinutes($now);

        if ($minutesMoovB2W > 30 || $minutesMoovW2b > 30 || $transaction->datetime_transaction_b2w_ok == 'null' || $transaction->datetime_transaction_w2b_ok) {
            $is_b2w_ok_exceededMoov = true;
        }

        $dataMoov = isset($dataMoov[0]) ? $dataMoov[0] : [];


        $mtnErrorsTransactions = MtnPushErrors::all();
        $mtnErrors = $mtnErrorsTransactions->map(function ($error) {
            return [
                'etat_mtn_errors' => $error->etat,
                'motif_mtn_errors' => $error->motif_echec,
                'errors_mtn' => $error->error,
            ];
        })->sortByDesc('errors_mtn');

        $moovErrorsTransactions = MoovPushErrors::all();
        $moovErrors = $moovErrorsTransactions->map(function ($error) {
            return [
                'etat_moov_errors' => $error->etat,
                'motif_moov_errors' => $error->motif_echec,
                'errors_moov' => $error->error,
            ];
        })->sortByDesc('errors_moov');

        $responseData = [
            'data' => $data,
            'dataMoov' => $dataMoov,
            'mtnErrors' => $mtnErrors,
            'moovErrors' => $moovErrors,
            'is_b2w_ok_exceeded' => $is_b2w_ok_exceededMtn,
            'is_b2w_ok_exceededMoov' => $is_b2w_ok_exceededMoov,
        ];

        if ($request->ajax()) {
            return response()->json($responseData);
        }

        return view('monitoring.index', $responseData);
    }


    public function transactionPush(Request $request)
    {
        $transactions = PushTransaction::all();
        $data = $transactions->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'datetime_b2w_ok' => (isset($transaction->datetime_transaction_b2w_ok) && strlen(trim($transaction->datetime_transaction_b2w_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_b2w_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
                'datetime_w2b_ok' => (isset($transaction->datetime_transaction_w2b_ok) && strlen(trim($transaction->datetime_transaction_w2b_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_w2b_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
            ];
        });

        if (isset($data[0])) {
            $data = $data[0];
        }
        $transactions = MoovPushTransaction::all();
        $dataMoov = $transactions->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'datetime_b2w_ok' => (isset($transaction->datetime_transaction_b2w_ok) && strlen(trim($transaction->datetime_transaction_b2w_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_b2w_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
                'datetime_w2b_ok' => (isset($transaction->datetime_transaction_w2b_ok) && strlen(trim($transaction->datetime_transaction_w2b_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_w2b_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
            ];
        });
        if (isset($dataMoov[0])) {
            $dataMoov = $dataMoov[0];
        }
        if ($request->ajax()) {
            $data = [
                'data' => $data,
                'dataMoov' => $dataMoov,
            ];
            return response()->json($data);
        }
        return view('monitoring.transaction', [
            'data' => $data,
            'dataMoov' => $dataMoov,
        ]);
    }
    public function acceuil()
    {
        return view('acceuil.index');
    }
}
