<?php

namespace App\Http\Controllers;

use App\Exports\AllExport;
use App\Models\LogActivity;
use App\Models\User;
use App\Services\UserHisoryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
    public function activityList(Request $request)
    {
        $search = '';
        $dateDeb = null;
        $dateFin = null;
        $user = null;

        if ($request->has('filter')) {
            $search = $request->search;
            if (isset($request->periode) && !empty($request->periode)) {
                $debut = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 60, date("Y")));
                $fin = date('Y-m-d');
                list($debut, $fin) = explode(' - ', $request->periode, 2);
                $dateDeb = Carbon::createFromFormat('d/m/Y H:i:s', $debut . ' 00:00:00');
                $dateFin = Carbon::createFromFormat('d/m/Y H:i:s', $fin . ' 23:59:59');
            }
            $user = $request->user;
        }

        $activities = LogActivity::filter($search, $dateDeb, $dateFin, $user)->paginate(20);

        if ($request->ajax()) {
            return view('activity.datapart', ['activities' => $activities,]);
        }
        $users = User::with('employe')->where('statut', 0)->where('username', '<>', 'admin')->orderBy('created_at', 'desc')->get();

        UserHisoryService::logActivity('Consulte la liste des logs');

        return view('activity.index', ['activities' => $activities, 'users' => $users,]);
    }

    public function export(Request $request)
    {

        $search = '';
        $dateDeb = null;
        $dateFin = null;
        $user = $request->user;


        $search = $request->search;

        if (isset($request->periode) && !empty($request->periode)) {
            $debut = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - 60, date("Y")));
            $fin = date('Y-m-d');
            list($debut, $fin) = explode(' - ', $request->periode, 2);
            $dateDeb = Carbon::createFromFormat('d/m/Y H:i:s', $debut . ' 00:00:00');
            $dateFin = Carbon::createFromFormat('d/m/Y H:i:s', $fin . ' 23:59:59');
        }


        $activities = LogActivity::filter($search, $dateDeb, $dateFin, $user)->get();
        return Excel::download(new AllExport('activity.export',['activities' => $activities,]), 'LogUser'.Carbon::now() .'.xlsx');
    }
}
