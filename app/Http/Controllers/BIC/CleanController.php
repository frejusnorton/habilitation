<?php

namespace App\Http\Controllers\BIC;

use App\Exports\allExport;
use App\Http\Controllers\Controller;
use App\Imports\DataImport;
use App\Service\SimpleXLS;
use App\Service\SimpleXLSX;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CleanController extends Controller
{

    public  function index()
    {


        ini_set("memory_limit", -1);
        set_time_limit(-1);

        $dateDec = Carbon::now()->subMonth()->endOfMonth();

        // $dateDec = Carbon::createFromFormat('d/m/Y',  '30/08/2024');

        // Caractères spéciaux à remplacer
        $specialChars = ['é', 'è', 'ê', 'ù', 'ô', 'ç', 'ï', 'î', '&', '°', 'É', 'È', 'Ê', 'Ù', 'Ô', 'Ç', 'Ï', 'Î'];
        $replaceChars = ['e', 'e', 'e', 'u', 'o', 'c', 'i', 'i', 'et', ' ', 'E', 'E', 'E', 'U', 'O', 'C', 'I', 'I'];

        $xls = new SimpleXLSX(public_path("/bic/compilation.xlsx"));
        $content = $xls->rows();

        if ($content) {

            $final = [];


            // Parcourir chaque ligne du fichier Excel
            foreach ($content as $key => $value) {
                if ($key == 0) {
                    $final[] = $value;
                    continue;
                }

                // Remplacer les caractères spéciaux dans chaque cellule de la ligne
                foreach ($value as $index => $cell) {
                    if (is_string($cell)) {
                        $value[$index] = str_replace($specialChars, $replaceChars, $cell);
                    }
                }
                // $value[27] = 'Yes';
                // DA
                if (isset($value[104])) {
                    if ($value[84] == "") {
                        if ($value[88] == "") {
                            if ($value[92] == "") {
                                if ($value[96] == "") {
                                    if ($value[100] == "") {
                                    } else {
                                        $value[104] = $value[100];
                                    }
                                } else {
                                    $value[104] = $value[96];
                                }
                            } else {
                                $value[104] = $value[92];
                            }
                        } else {
                            $value[104] = $value[88];
                        }
                    } else {
                        $value[104] = $value[84];
                    }
                }

                // DB
                if (isset($value[105])) {
                    if ($value[85] == "") {
                        if ($value[89] == "") {
                            if ($value[93] == "") {
                                if ($value[97] == "") {
                                    if ($value[101] == "") {
                                    } else {
                                        $value[105] = $value[101];
                                    }
                                } else {
                                    $value[105] = $value[97];
                                }
                            } else {
                                $value[105] = $value[93];
                            }
                        } else {
                            $value[105] = $value[89];
                        }
                    } else {
                        $value[105] = $value[85];
                    }
                }

                // DC
                if (isset($value[106])) {
                    if ($value[86] == "") {
                        if ($value[90] == "") {
                            if ($value[94] == "") {
                                if ($value[98] == "") {
                                    if ($value[102] == "") {
                                    } else {
                                        $value[106] = $value[102];
                                    }
                                } else {
                                    $value[106] = $value[98];
                                }
                            } else {
                                $value[106] = $value[94];
                            }
                        } else {
                            $value[106] = $value[90];
                        }
                    } else {
                        $value[106] = $value[86];
                    }
                }

                // DD
                if (isset($value[107])) {
                    if ($value[87] == "") {
                        if ($value[91] == "") {
                            if ($value[95] == "") {
                                if ($value[99] == "") {
                                    if ($value[103] == "") {
                                    } else {
                                        $value[107] = $value[103];
                                    }
                                } else {
                                    $value[107] = $value[99];
                                }
                            } else {
                                $value[107] = $value[95];
                            }
                        } else {
                            $value[107] = $value[91];
                        }
                    } else {
                        $value[107] = $value[87];
                    }
                }

                for ($i = 104; $i <= 107; $i++) {
                    if (isset($value[$i]) && $value[$i] == '0') {
                        $value[$i] = str_replace('0', ' ', $value[$i]);
                    }
                }

                // Remplacer la virgule dans la colonne "InterestRate" par un point (colonne 8)
                if (isset($value[8])) {
                    $value[8] = str_replace(',', '.', $value[8]);
                }

                // Remplacer le contenu de la colonne "LegalForm" (colonne 68) par "Other"
                if (isset($value[68])) {
                    $value[68] = 'Other';
                }



                // Vider les colonnes CG à CZ (colonne 84 à 103)
                for ($i = 84; $i <= 103; $i++) {
                    $value[$i] = ' ';
                }

                // Formater les numéros de téléphone si la nationalité est "SN" (colonne 65)
                if (isset($value[59]) && $value[59] == 'SN') {
                    if (isset($value[121]) && !empty($value[121])) {
                        // MobilePhone: +221 7 suivi de 8 chiffres
                        $value[121] = '+221 7' . substr($value[121], -8);
                    }
                    if (isset($value[122]) && !empty($value[122])) {
                        // FixedLine: +221 3 suivi de 8 chiffres
                        $value[122] = '+221 3' . substr($value[122], -8);
                    }
                }

                // Remplacer les années supérieures à 2100 dans "IDDocumentExpirationDate" (colonne 106)
                if (isset($value[106])) {
                    $value[106] = self::reformatDate($value[106]);
                }


                // Remplacer les valeurs vides de "Nationality" (colonne 59) par celles de "Residency" (colonne 58)
                if (isset($value[59]) && empty($value[59])) {
                    $value[59] = $value[58];
                }

                // Remplir "PlaceOfBirth" (colonne 55) avec "BJ" si "DateOfBirth" (colonne 53) est renseignée et "PlaceOfBirth" est vide
                if ($value[55] ==  '' && $value[53] != '') {

                    $value[55] = 'BJ';
                }

                $value[87] = 'BJ';
                $value[64] = 0;

                //CompanyName differnt de vide alors buisnessStatut = active
                if ($value[28] <> 'PhysicalPerson') {
                    $value[69] = 'Active';
                }



                //PresentSurname ne doit pas etre vide
                if ($value[46] == '') {
                    if ($value[47] != '') {
                        $value[46] = $value[47];
                    } elseif ($value[46] == '' && $value[48] != '') {
                        $value[46] = $value[48];
                    }
                }

                //Mise à jour du closed
                if ($value[25] != '') {

                    $dtf = Carbon::parse($value[25]);

                    if ($dateDec->gt($dtf)  || $dateDec == $dtf) {

                        $value[3] = 'Closed';
                    } else {
                        $value[3] = 'Open';
                    }
                } elseif ($value[24] != '') {
                    $dtf = Carbon::parse($value[24]);

                    if ($dateDec->gt($dtf) || $dateDec == $dtf) {

                        $value[3] = 'Closed';
                    } else {
                        $value[3] = 'Open';
                        $value[25] = '';
                    }
                }


                if ($value[3] == 'Closed' && $value[25] == '' && $value[24] != '') {
                    $dtf = Carbon::parse($value[24]);

                    if ($dateDec->gt($dtf) || $dateDec == $dtf) {

                        $value[25] =  $value[24];
                    }
                }


                if ($value[3] == 'Closed') {
                    $value[4] = 'SettledOnTime';
                }

                if ($value[3] == 'Open') {
                    $value[4] = 'GrantedAndActivated';
                }

                if ($value[53] != '' && $value[55] == '') {
                    $value[55] = 'BJ';
                }

                if ($value[73] == '') {
                    $value[73] = 'BJ';
                }
                //companyName manquant
                if ($value[66] == '' && $value[67] != '') {
                    $value[66] = strtoupper($value[67]);
                }

                //Sigle manquant
                if ($value[66] != '' && $value[74] == '') {

                    $value[74] = strtoupper($value[66]);
                }

                //Sigle en majuscule

                if ($value[74] != '') {
                    $value[74] = strtoupper($value[74]);
                }
                if ($value[17] == '') {
                    $value[17] = 0;
                }

                if ($value[114] == '') {
                    $value[114] = 'BJ';
                }

                if ($value[3] == 'Closed') {
                    $value[15] = 0;
                    $value[16] = 0;
                    $value[17] = 0;
                    $value[18] = 0;
                }

                if ($value[51] == '') {
                    $value[51] = 'BJ';
                }

                //c_customer pour personnes moral
                if ($value[65] != $value[1] && $value[28] <> 'PhysicalPerson' ) {
                    $value[65] = $value[1];
                }

                if ($value[78] == ''  && $value[28] <> 'PhysicalPerson') {
                    $value[78] = 'Other';
                }

                if ($value[80] == ''  && $value[28] <> 'PhysicalPerson') {
                    $value[80] = 'Other';
                }

                //BusinessStatus
                if (isset($value[68]) && $value[68] == 'Other') {
                    $value[69] = 'Active';
                    $value[71] = 'OtherNCAServicesActivities';
                }

                //Subject must be reported in Individual or Company structures if its customer code is stated in section SubjectRole
                //Le consentCode doit etre egal au CustomerCodeRole
                if ($value[126] != $value[1] ) {
                    $value[126] = $value[1];
                }

                $final[] = $value;
            }

            $fileName = 'BIC_' . Carbon::now()->format('d_m_Y_H_i_s');

            return Excel::download(new allExport('bic.index', ['datas' => $final]), $fileName . '.xlsx');
        } else {
            echo SimpleXLSX::parseError();
        }
    }

    public function reformatDate($date)
    {
        // Vérifier si la date est au format YYYY-MM-DD ou DD-MM-YYYY
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $dateParts = explode('-', $date);
        } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
            $dateParts = array_reverse(explode('-', $date));
        } else {
            return $date; // Retourner la date telle quelle si elle ne correspond à aucun format
        }

        // Vérifier si l'année est supérieure à 2100
        if ((int)$dateParts[0] >= 2100) {
            $dateParts[0] = '2099';
        }

        return implode('-', $dateParts);
    }
}
