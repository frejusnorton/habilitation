<?php


namespace App\Http\Controllers;

use DB;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PushTransaction;
use App\Models\MoovPushTransaction;
use Illuminate\Support\Facades\Route;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {

        $transactions = PushTransaction::all();
        $data = $transactions->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'mtn_b2w_ko' => $transaction->nombre_b2w_transactions_ko,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'montant_b2w_ko' => number_format($transaction->montant_b2w_transactions_ko, 0, ' ', ' '),
                'datetime_b2w_ok' => (isset($transaction->datetime_transaction_b2w_ok) && strlen(trim($transaction->datetime_transaction_b2w_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_b2w_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'datetime_b2w_ko' => (isset($transaction->datetime_transaction_b2w_ko) && strlen(trim($transaction->datetime_transaction_b2w_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_b2w_ko))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'mtn_w2b_ko' => $transaction->nombre_w2b_transactions_ko,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
                'montant_w2b_ko' => number_format($transaction->montant_w2b_transactions_ko, 0, ' ', ' '),
                'datetime_w2b_ok' => (isset($transaction->datetime_transaction_w2b_ok) && strlen(trim($transaction->datetime_transaction_w2b_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_w2b_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'datetime_w2b_ko' => (isset($transaction->datetime_transaction_w2b_ko) && strlen(trim($transaction->datetime_transaction_w2b_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_w2b_ko))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
            ];
        });

        if (isset($data[0])) {
            $data = $data[0];
        }


        $transactions = MoovPushTransaction::all();
        $dataMoov = $transactions->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'mtn_b2w_ko' => $transaction->nombre_b2w_transactions_ko,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'montant_b2w_ko' => number_format($transaction->montant_b2w_transactions_ko, 0, ' ', ' '),
                'datetime_b2w_ok' => (isset($transaction->datetime_transaction_b2w_ok) && strlen(trim($transaction->datetime_transaction_b2w_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_b2w_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'datetime_b2w_ko' => (isset($transaction->datetime_transaction_b2w_ko) && strlen(trim($transaction->datetime_transaction_b2w_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_b2w_ko))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'mtn_w2b_ko' => $transaction->nombre_w2b_transactions_ko,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
                'montant_w2b_ko' => number_format($transaction->montant_w2b_transactions_ko, 0, ' ', ' '),
                'datetime_w2b_ok' => (isset($transaction->datetime_transaction_w2b_ok) && strlen(trim($transaction->datetime_transaction_w2b_ok)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_w2b_ok))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
                'datetime_w2b_ko' => (isset($transaction->datetime_transaction_w2b_ko) && strlen(trim($transaction->datetime_transaction_w2b_ko)) && ($date = DateTime::createFromFormat('d/m/Y H:i e', $transaction->datetime_transaction_w2b_ko))) ? $date->setTimezone(new DateTimeZone('GMT+1'))->format('d/m/Y à H:i:s') : '',
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

        return view('monitoring.index', [
            'data' => $data,
            'dataMoov' => $dataMoov,
        ]);
    }

    public function transaction()
    {
        $transactions = collect([
            (object) [
                'nombre_b2w_transactions_ok' => rand(30, 100),
                'nombre_b2w_transactions_ko' => rand(10, 50),
                'montant_b2w_transactions_ok' => rand(10000, 50000),
                'montant_b2w_transactions_ko' => rand(1000, 10000),
                'datetime_transaction_b2w_ok' => now()->subDays(rand(1, 30)),
                'datetime_transaction_b2w_ko' => now()->subDays(rand(1, 30)),
                'nombre_w2b_transactions_ok' => rand(20, 90),
                'nombre_w2b_transactions_ko' => rand(5, 30),
                'montant_w2b_transactions_ok' => rand(15000, 60000),
                'montant_w2b_transactions_ko' => rand(200, 800),
                'datetime_transaction_w2b_ok' => now()->subDays(rand(1, 30)),
                'datetime_transaction_w2b_ko' => now()->subDays(rand(1, 30)),
            ],

        ]);

        $data = $transactions->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'mtn_b2w_ko' => $transaction->nombre_b2w_transactions_ko,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'montant_b2w_ko' => number_format($transaction->montant_b2w_transactions_ko, 0, ' ', ' '),
                'datetime_b2w_ok' => $transaction->datetime_transaction_b2w_ok,
                'datetime_b2w_ko' => $transaction->datetime_transaction_b2w_ko,
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'mtn_w2b_ko' => $transaction->nombre_w2b_transactions_ko,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, '', ''),
                'montant_w2b_ko' => number_format($transaction->montant_w2b_transactions_ko, 0, '', ''),
                'datetime_w2b_ok' => $transaction->datetime_transaction_w2b_ok,
                'datetime_w2b_ko' => $transaction->datetime_transaction_w2b_ko,
            ];
        });

        if (isset($data[0])) {
            $data = $data[0];
        }

        return response()->json($data);
    }

    public function donneeReel()
    {

        $transactions = PushTransaction::all();
        $data = $transactions->map(function ($transaction) {
            return [
                'mtn_b2w_ok' => $transaction->nombre_b2w_transactions_ok,
                'mtn_b2w_ko' => $transaction->nombre_b2w_transactions_ko,
                'montant_b2w_ok' => number_format($transaction->montant_b2w_transactions_ok, 0, ' ', ' '),
                'montant_b2w_ko' => number_format($transaction->montant_b2w_transactions_ko, 0, ' ', ' '),
                'datetime_b2w_ok' => $transaction->datetime_transaction_b2w_ok,
                'datetime_b2w_ko' => $transaction->datetime_transaction_b2w_ko,
                'mtn_w2b_ok' => $transaction->nombre_w2b_transactions_ok,
                'mtn_w2b_ko' => $transaction->nombre_w2b_transactions_ko,
                'montant_w2b_ok' => number_format($transaction->montant_w2b_transactions_ok, 0, ' ', ' '),
                'montant_w2b_ko' => number_format($transaction->montant_w2b_transactions_ko, 0, ' ', ' '),
                'datetime_w2b_ok' => $transaction->datetime_transaction_w2b_ok,
                'datetime_w2b_ko' => $transaction->datetime_transaction_w2b_ko,
            ];
        });

        if (isset($data[0])) {
            $data = $data[0];
        }

        return response()->json($data);
    }
}
