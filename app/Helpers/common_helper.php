<?php

use CodeIgniter\HTTP\RequestInterface;
use \Config\Database;
use  App\Modules\Breadcrumbs\Breadcrumbs;
use CodeIgniter\Exceptions\PageNotFoundException;

function setFlash($alert = array())
{
    /* if(session()->has('status')){
        session()->remove('status');
    }
    if(session()->has('message')){
        session()->remove('message');
    } */
    if (array_key_exists('status', $alert)) {
        session()->setFlashdata('status', $alert['status']);
    } else {
        session()->setFlashdata('status', "success");
    }
    if (array_key_exists('message', $alert)) {
        session()->setFlashdata('message', $alert['message']);
    } else {
        session()->setFlashdata('message', NULL);
    }
}

function getHash($data)
{
    return password_hash($data,  PASSWORD_DEFAULT);
}


// For Web View
// Function to set session data
if (!function_exists('setUserSession')) {
    function setUserSession($user)
    {
        $session = \Config\Services::session();
        $session->set('user', $user);
    }
}
// Function to get session data
if (!function_exists('getUserSession')) {
    function getUserSession()
    {
        $session = \Config\Services::session();
        $payload = $session->get('user');
        return $payload;
    }
}

function UploadFile(\CodeIgniter\HTTP\Files\UploadedFile $imageFile, $folder = NULL, $editFileName = NULL)
{
    try {
        if ($imageFile->hasMoved()) {
            return;
        }

        $upload_dir = UPLOAD_DIR;
        $upload_dir = empty($folder) ? $upload_dir : $upload_dir . $folder;
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $imageName = uniqid() . '.' . $imageFile->getExtension();
        if (!is_null($editFileName) && !empty($editFileName)) {
            $path = $upload_dir . '/' . $editFileName;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        return $imageFile->move($upload_dir, $imageName) == true ? $imageName : null;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function getDbDate()
{
    return date('Y-m-d H:i:s');
}


function is_empty($var)
{
    if (!is_null($var) || !empty($var)) {
        return true;
    }
    return false;
}

function getAutoIndex($table)
{
    if (!empty($table)) {
        $db = Database::connect();
        $sql = "show table status where name like '$table'";
        $autoIndex = $db->query($sql)->getRow();
        if (!is_null($autoIndex)) {
            return $autoIndex->Auto_increment;
        }
        return false;
    }
    return false;
}


function getQuery()
{
    try {
        $db = Database::connect();
        echo  trim(preg_replace('/\s\s+/', ' ', $db->getLastQuery()));
        exit;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function getDeviceInfo()
{
    $request = \Config\Services::request();
    $agent = $request->getUserAgent();
    if ($agent->isBrowser()) {
        $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
    } elseif ($agent->isRobot()) {
        $currentAgent = $agent->getRobot();
    } elseif ($agent->isMobile()) {
        $currentAgent = $agent->getMobile();
    } else {
        $currentAgent = 'Unidentified User Agent';
    }
    return [
        'current_agent' => $currentAgent,
        'current_platform' => $agent->getPlatform(),
        'ip_address' => $request->getIPAddress(),
    ];
}

function getPrint($data = NULL)
{
    echo "<pre>";
    print_r($data);
    exit;
}

function getFileURL()
{
    return base_url('uploads/');
}
function getTimeZone()
{
    $timezon_arr = array(
        'Pacific/Midway' => '(GMT-11:00) Pacific, Midway',
        'Pacific/Niue' => '(GMT-11:00) Pacific, Niue',
        'Pacific/Pago_Pago' => '(GMT-11:00) Pacific, Pago Pago',
        'America/Adak' => '(GMT-10:00) America, Adak',
        'Pacific/Honolulu' => '(GMT-10:00) Pacific, Honolulu',
        'Pacific/Rarotonga' => '(GMT-10:00) Pacific, Rarotonga',
        'Pacific/Tahiti' => '(GMT-10:00) Pacific, Tahiti',
        'Pacific/Marquesas' => '(GMT-09:30) Pacific, Marquesas',
        'America/Anchorage' => '(GMT-09:00) America, Anchorage',
        'America/Juneau' => '(GMT-09:00) America, Juneau',
        'America/Metlakatla' => '(GMT-09:00) America, Metlakatla',
        'America/Nome' => '(GMT-09:00) America, Nome',
        'America/Sitka' => '(GMT-09:00) America, Sitka',
        'America/Yakutat' => '(GMT-09:00) America, Yakutat',
        'Pacific/Gambier' => '(GMT-09:00) Pacific, Gambier',
        'America/Los_Angeles' => '(GMT-08:00) America, Los Angeles',
        'America/Tijuana' => '(GMT-08:00) America, Tijuana',
        'America/Vancouver' => '(GMT-08:00) America, Vancouver',
        'Pacific/Pitcairn' => '(GMT-08:00) Pacific, Pitcairn',
        'America/Boise' => '(GMT-07:00) America, Boise',
        'America/Cambridge_Bay' => '(GMT-07:00) America, Cambridge Bay',
        'America/Creston' => '(GMT-07:00) America, Creston',
        'America/Dawson' => '(GMT-07:00) America, Dawson',
        'America/Dawson_Creek' => '(GMT-07:00) America, Dawson Creek',
        'America/Denver' => '(GMT-07:00) America, Denver',
        'America/Edmonton' => '(GMT-07:00) America, Edmonton',
        'America/Fort_Nelson' => '(GMT-07:00) America, Fort Nelson',
        'America/Hermosillo' => '(GMT-07:00) America, Hermosillo',
        'America/Inuvik' => '(GMT-07:00) America, Inuvik',
        'America/Mazatlan' => '(GMT-07:00) America, Mazatlan',
        'America/Phoenix' => '(GMT-07:00) America, Phoenix',
        'America/Whitehorse' => '(GMT-07:00) America, Whitehorse',
        'America/Yellowknife' => '(GMT-07:00) America, Yellowknife',
        'America/Bahia_Banderas' => '(GMT-06:00) America, Bahia Banderas',
        'America/Belize' => '(GMT-06:00) America, Belize',
        'America/Chicago' => '(GMT-06:00) America, Chicago',
        'America/Chihuahua' => '(GMT-06:00) America, Chihuahua',
        'America/Costa_Rica' => '(GMT-06:00) America, Costa Rica',
        'America/El_Salvador' => '(GMT-06:00) America, El Salvador',
        'America/Guatemala' => '(GMT-06:00) America, Guatemala',
        'America/Indiana/Knox' => '(GMT-06:00) America, Indiana, Knox',
        'America/Indiana/Tell_City' => '(GMT-06:00) America, Indiana, Tell City',
        'America/Managua' => '(GMT-06:00) America, Managua',
        'America/Matamoros' => '(GMT-06:00) America, Matamoros',
        'America/Menominee' => '(GMT-06:00) America, Menominee',
        'America/Merida' => '(GMT-06:00) America, Merida',
        'America/Mexico_City' => '(GMT-06:00) America, Mexico City',
        'America/Monterrey' => '(GMT-06:00) America, Monterrey',
        'America/North_Dakota/Beulah' => '(GMT-06:00) America, North Dakota, Beulah',
        'America/North_Dakota/Center' => '(GMT-06:00) America, North Dakota, Center',
        'America/North_Dakota/New_Salem' => '(GMT-06:00) America, North Dakota, New Salem',
        'America/Ojinaga' => '(GMT-06:00) America, Ojinaga',
        'America/Rankin_Inlet' => '(GMT-06:00) America, Rankin Inlet',
        'America/Regina' => '(GMT-06:00) America, Regina',
        'America/Resolute' => '(GMT-06:00) America, Resolute',
        'America/Swift_Current' => '(GMT-06:00) America, Swift Current',
        'America/Tegucigalpa' => '(GMT-06:00) America, Tegucigalpa',
        'America/Winnipeg' => '(GMT-06:00) America, Winnipeg',
        'Pacific/Galapagos' => '(GMT-06:00) Pacific, Galapagos',
        'America/Atikokan' => '(GMT-05:00) America, Atikokan',
        'America/Bogota' => '(GMT-05:00) America, Bogota',
        'America/Cancun' => '(GMT-05:00) America, Cancun',
        'America/Cayman' => '(GMT-05:00) America, Cayman',
        'America/Detroit' => '(GMT-05:00) America, Detroit',
        'America/Eirunepe' => '(GMT-05:00) America, Eirunepe',
        'America/Grand_Turk' => '(GMT-05:00) America, Grand Turk',
        'America/Guayaquil' => '(GMT-05:00) America, Guayaquil',
        'America/Havana' => '(GMT-05:00) America, Havana',
        'America/Indiana/Indianapolis' => '(GMT-05:00) America, Indiana, Indianapolis',
        'America/Indiana/Marengo' => '(GMT-05:00) America, Indiana, Marengo',
        'America/Indiana/Petersburg' => '(GMT-05:00) America, Indiana, Petersburg',
        'America/Indiana/Vevay' => '(GMT-05:00) America, Indiana, Vevay',
        'America/Indiana/Vincennes' => '(GMT-05:00) America, Indiana, Vincennes',
        'America/Indiana/Winamac' => '(GMT-05:00) America, Indiana, Winamac',
        'America/Iqaluit' => '(GMT-05:00) America, Iqaluit',
        'America/Jamaica' => '(GMT-05:00) America, Jamaica',
        'America/Kentucky/Louisville' => '(GMT-05:00) America, Kentucky, Louisville',
        'America/Kentucky/Monticello' => '(GMT-05:00) America, Kentucky, Monticello',
        'America/Lima' => '(GMT-05:00) America, Lima',
        'America/Nassau' => '(GMT-05:00) America, Nassau',
        'America/New_York' => '(GMT-05:00) America, New York',
        'America/Panama' => '(GMT-05:00) America, Panama',
        'America/Pangnirtung' => '(GMT-05:00) America, Pangnirtung',
        'America/Port-au-Prince' => '(GMT-05:00) America, Port-au-Prince',
        'America/Rio_Branco' => '(GMT-05:00) America, Rio Branco',
        'America/Toronto' => '(GMT-05:00) America, Toronto',
        'Pacific/Easter' => '(GMT-05:00) Pacific, Easter',
        'America/Anguilla' => '(GMT-04:00) America, Anguilla',
        'America/Antigua' => '(GMT-04:00) America, Antigua',
        'America/Aruba' => '(GMT-04:00) America, Aruba',
        'America/Barbados' => '(GMT-04:00) America, Barbados',
        'America/Blanc-Sablon' => '(GMT-04:00) America, Blanc-Sablon',
        'America/Boa_Vista' => '(GMT-04:00) America, Boa Vista',
        'America/Campo_Grande' => '(GMT-04:00) America, Campo Grande',
        'America/Caracas' => '(GMT-04:00) America, Caracas',
        'America/Cuiaba' => '(GMT-04:00) America, Cuiaba',
        'America/Curacao' => '(GMT-04:00) America, Curacao',
        'America/Dominica' => '(GMT-04:00) America, Dominica',
        'America/Glace_Bay' => '(GMT-04:00) America, Glace Bay',
        'America/Goose_Bay' => '(GMT-04:00) America, Goose Bay',
        'America/Grenada' => '(GMT-04:00) America, Grenada',
        'America/Guadeloupe' => '(GMT-04:00) America, Guadeloupe',
        'America/Guyana' => '(GMT-04:00) America, Guyana',
        'America/Halifax' => '(GMT-04:00) America, Halifax',
        'America/Kralendijk' => '(GMT-04:00) America, Kralendijk',
        'America/La_Paz' => '(GMT-04:00) America, La Paz',
        'America/Lower_Princes' => '(GMT-04:00) America, Lower Princes',
        'America/Manaus' => '(GMT-04:00) America, Manaus',
        'America/Marigot' => '(GMT-04:00) America, Marigot',
        'America/Martinique' => '(GMT-04:00) America, Martinique',
        'America/Moncton' => '(GMT-04:00) America, Moncton',
        'America/Montserrat' => '(GMT-04:00) America, Montserrat',
        'America/Port_of_Spain' => '(GMT-04:00) America, Port of Spain',
        'America/Porto_Velho' => '(GMT-04:00) America, Porto Velho',
        'America/Puerto_Rico' => '(GMT-04:00) America, Puerto Rico',
        'America/Santo_Domingo' => '(GMT-04:00) America, Santo Domingo',
        'America/St_Barthelemy' => '(GMT-04:00) America, St. Barthelemy',
        'America/St_Kitts' => '(GMT-04:00) America, St. Kitts',
        'America/St_Lucia' => '(GMT-04:00) America, St. Lucia',
        'America/St_Thomas' => '(GMT-04:00) America, St. Thomas',
        'America/St_Vincent' => '(GMT-04:00) America, St. Vincent',
        'America/Thule' => '(GMT-04:00) America, Thule',
        'America/Tortola' => '(GMT-04:00) America, Tortola',
        'Atlantic/Bermuda' => '(GMT-04:00) Atlantic, Bermuda',
        'America/St_Johns' => '(GMT-03:30) America, St. Johns',
        'America/Araguaina' => '(GMT-03:00) America, Araguaina',
        'America/Argentina/Buenos_Aires' => '(GMT-03:00) America, Argentina, Buenos Aires',
        'America/Argentina/Catamarca' => '(GMT-03:00) America, Argentina, Catamarca',
        'America/Argentina/Cordoba' => '(GMT-03:00) America, Argentina, Cordoba',
        'America/Argentina/Jujuy' => '(GMT-03:00) America, Argentina, Jujuy',
        'America/Argentina/La_Rioja' => '(GMT-03:00) America, Argentina, La Rioja',
        'America/Argentina/Mendoza' => '(GMT-03:00) America, Argentina, Mendoza',
        'America/Argentina/Rio_Gallegos' => '(GMT-03:00) America, Argentina, Rio Gallegos',
        'America/Argentina/Salta' => '(GMT-03:00) America, Argentina, Salta',
        'America/Argentina/San_Juan' => '(GMT-03:00) America, Argentina, San Juan',
        'America/Argentina/San_Luis' => '(GMT-03:00) America, Argentina, San Luis',
        'America/Argentina/Tucuman' => '(GMT-03:00) America, Argentina, Tucuman',
        'America/Argentina/Ushuaia' => '(GMT-03:00) America, Argentina, Ushuaia',
        'America/Asuncion' => '(GMT-03:00) America, Asuncion',
        'America/Bahia' => '(GMT-03:00) America, Bahia',
        'America/Belem' => '(GMT-03:00) America, Belem',
        'America/Cayenne' => '(GMT-03:00) America, Cayenne',
        'America/Fortaleza' => '(GMT-03:00) America, Fortaleza',
        'America/Maceio' => '(GMT-03:00) America, Maceio',
        'America/Miquelon' => '(GMT-03:00) America, Miquelon',
        'America/Montevideo' => '(GMT-03:00) America, Montevideo',
        'America/Nuuk' => '(GMT-03:00) America, Nuuk',
        'America/Paramaribo' => '(GMT-03:00) America, Paramaribo',
        'America/Punta_Arenas' => '(GMT-03:00) America, Punta Arenas',
        'America/Recife' => '(GMT-03:00) America, Recife',
        'America/Santarem' => '(GMT-03:00) America, Santarem',
        'America/Santiago' => '(GMT-03:00) America, Santiago',
        'America/Sao_Paulo' => '(GMT-03:00) America, Sao Paulo',
        'Antarctica/Palmer' => '(GMT-03:00) Antarctica, Palmer',
        'Antarctica/Rothera' => '(GMT-03:00) Antarctica, Rothera',
        'Atlantic/Stanley' => '(GMT-03:00) Atlantic, Stanley',
        'America/Noronha' => '(GMT-02:00) America, Noronha',
        'Atlantic/South_Georgia' => '(GMT-02:00) Atlantic, South Georgia',
        'America/Scoresbysund' => '(GMT-01:00) America, Scoresbysund',
        'Atlantic/Azores' => '(GMT-01:00) Atlantic, Azores',
        'Atlantic/Cape_Verde' => '(GMT-01:00) Atlantic, Cape Verde',
        'Africa/Abidjan' => '(GMT) Africa, Abidjan',
        'Africa/Accra' => '(GMT) Africa, Accra',
        'Africa/Bamako' => '(GMT) Africa, Bamako',
        'Africa/Banjul' => '(GMT) Africa, Banjul',
        'Africa/Bissau' => '(GMT) Africa, Bissau',
        'Africa/Conakry' => '(GMT) Africa, Conakry',
        'Africa/Dakar' => '(GMT) Africa, Dakar',
        'Africa/Freetown' => '(GMT) Africa, Freetown',
        'Africa/Lome' => '(GMT) Africa, Lome',
        'Africa/Monrovia' => '(GMT) Africa, Monrovia',
        'Africa/Nouakchott' => '(GMT) Africa, Nouakchott',
        'Africa/Ouagadougou' => '(GMT) Africa, Ouagadougou',
        'Africa/Sao_Tome' => '(GMT) Africa, Sao Tome',
        'America/Danmarkshavn' => '(GMT) America, Danmarkshavn',
        'Antarctica/Troll' => '(GMT) Antarctica, Troll',
        'Atlantic/Canary' => '(GMT) Atlantic, Canary',
        'Atlantic/Faroe' => '(GMT) Atlantic, Faroe',
        'Atlantic/Madeira' => '(GMT) Atlantic, Madeira',
        'Atlantic/Reykjavik' => '(GMT) Atlantic, Reykjavik',
        'Atlantic/St_Helena' => '(GMT) Atlantic, St. Helena',
        'Europe/Dublin' => '(GMT) Europe, Dublin',
        'Europe/Guernsey' => '(GMT) Europe, Guernsey',
        'Europe/Isle_of_Man' => '(GMT) Europe, Isle of Man',
        'Europe/Jersey' => '(GMT) Europe, Jersey',
        'Europe/Lisbon' => '(GMT) Europe, Lisbon',
        'Europe/London' => '(GMT) Europe, London',
        'UTC' => '(GMT) UTC',
        'Africa/Algiers' => '(GMT+01:00) Africa, Algiers',
        'Africa/Bangui' => '(GMT+01:00) Africa, Bangui',
        'Africa/Brazzaville' => '(GMT+01:00) Africa, Brazzaville',
        'Africa/Casablanca' => '(GMT+01:00) Africa, Casablanca',
        'Africa/Ceuta' => '(GMT+01:00) Africa, Ceuta',
        'Africa/Douala' => '(GMT+01:00) Africa, Douala',
        'Africa/El_Aaiun' => '(GMT+01:00) Africa, El Aaiun',
        'Africa/Kinshasa' => '(GMT+01:00) Africa, Kinshasa',
        'Africa/Lagos' => '(GMT+01:00) Africa, Lagos',
        'Africa/Libreville' => '(GMT+01:00) Africa, Libreville',
        'Africa/Luanda' => '(GMT+01:00) Africa, Luanda',
        'Africa/Malabo' => '(GMT+01:00) Africa, Malabo',
        'Africa/Ndjamena' => '(GMT+01:00) Africa, Ndjamena',
        'Africa/Niamey' => '(GMT+01:00) Africa, Niamey',
        'Africa/Porto-Novo' => '(GMT+01:00) Africa, Porto-Novo',
        'Africa/Tunis' => '(GMT+01:00) Africa, Tunis',
        'Arctic/Longyearbyen' => '(GMT+01:00) Arctic, Longyearbyen',
        'Europe/Amsterdam' => '(GMT+01:00) Europe, Amsterdam',
        'Europe/Andorra' => '(GMT+01:00) Europe, Andorra',
        'Europe/Belgrade' => '(GMT+01:00) Europe, Belgrade',
        'Europe/Berlin' => '(GMT+01:00) Europe, Berlin',
        'Europe/Bratislava' => '(GMT+01:00) Europe, Bratislava',
        'Europe/Brussels' => '(GMT+01:00) Europe, Brussels',
        'Europe/Budapest' => '(GMT+01:00) Europe, Budapest',
        'Europe/Busingen' => '(GMT+01:00) Europe, Busingen',
        'Europe/Copenhagen' => '(GMT+01:00) Europe, Copenhagen',
        'Europe/Gibraltar' => '(GMT+01:00) Europe, Gibraltar',
        'Europe/Ljubljana' => '(GMT+01:00) Europe, Ljubljana',
        'Europe/Luxembourg' => '(GMT+01:00) Europe, Luxembourg',
        'Europe/Madrid' => '(GMT+01:00) Europe, Madrid',
        'Europe/Malta' => '(GMT+01:00) Europe, Malta',
        'Europe/Monaco' => '(GMT+01:00) Europe, Monaco',
        'Europe/Oslo' => '(GMT+01:00) Europe, Oslo',
        'Europe/Paris' => '(GMT+01:00) Europe, Paris',
        'Europe/Podgorica' => '(GMT+01:00) Europe, Podgorica',
        'Europe/Prague' => '(GMT+01:00) Europe, Prague',
        'Europe/Rome' => '(GMT+01:00) Europe, Rome',
        'Europe/San_Marino' => '(GMT+01:00) Europe, San Marino',
        'Europe/Sarajevo' => '(GMT+01:00) Europe, Sarajevo',
        'Europe/Skopje' => '(GMT+01:00) Europe, Skopje',
        'Europe/Stockholm' => '(GMT+01:00) Europe, Stockholm',
        'Europe/Tirane' => '(GMT+01:00) Europe, Tirane',
        'Europe/Vaduz' => '(GMT+01:00) Europe, Vaduz',
        'Europe/Vatican' => '(GMT+01:00) Europe, Vatican',
        'Europe/Vienna' => '(GMT+01:00) Europe, Vienna',
        'Europe/Warsaw' => '(GMT+01:00) Europe, Warsaw',
        'Europe/Zagreb' => '(GMT+01:00) Europe, Zagreb',
        'Europe/Zurich' => '(GMT+01:00) Europe, Zurich',
        'Africa/Blantyre' => '(GMT+02:00) Africa, Blantyre',
        'Africa/Bujumbura' => '(GMT+02:00) Africa, Bujumbura',
        'Africa/Cairo' => '(GMT+02:00) Africa, Cairo',
        'Africa/Gaborone' => '(GMT+02:00) Africa, Gaborone',
        'Africa/Harare' => '(GMT+02:00) Africa, Harare',
        'Africa/Johannesburg' => '(GMT+02:00) Africa, Johannesburg',
        'Africa/Juba' => '(GMT+02:00) Africa, Juba',
        'Africa/Khartoum' => '(GMT+02:00) Africa, Khartoum',
        'Africa/Kigali' => '(GMT+02:00) Africa, Kigali',
        'Africa/Lubumbashi' => '(GMT+02:00) Africa, Lubumbashi',
        'Africa/Lusaka' => '(GMT+02:00) Africa, Lusaka',
        'Africa/Maputo' => '(GMT+02:00) Africa, Maputo',
        'Africa/Maseru' => '(GMT+02:00) Africa, Maseru',
        'Africa/Mbabane' => '(GMT+02:00) Africa, Mbabane',
        'Africa/Tripoli' => '(GMT+02:00) Africa, Tripoli',
        'Africa/Windhoek' => '(GMT+02:00) Africa, Windhoek',
        'Asia/Beirut' => '(GMT+02:00) Asia, Beirut',
        'Asia/Famagusta' => '(GMT+02:00) Asia, Famagusta',
        'Asia/Gaza' => '(GMT+02:00) Asia, Gaza',
        'Asia/Hebron' => '(GMT+02:00) Asia, Hebron',
        'Asia/Jerusalem' => '(GMT+02:00) Asia, Jerusalem',
        'Asia/Nicosia' => '(GMT+02:00) Asia, Nicosia',
        'Europe/Athens' => '(GMT+02:00) Europe, Athens',
        'Europe/Bucharest' => '(GMT+02:00) Europe, Bucharest',
        'Europe/Chisinau' => '(GMT+02:00) Europe, Chisinau',
        'Europe/Helsinki' => '(GMT+02:00) Europe, Helsinki',
        'Europe/Kaliningrad' => '(GMT+02:00) Europe, Kaliningrad',
        'Europe/Kyiv' => '(GMT+02:00) Europe, Kyiv',
        'Europe/Mariehamn' => '(GMT+02:00) Europe, Mariehamn',
        'Europe/Riga' => '(GMT+02:00) Europe, Riga',
        'Europe/Sofia' => '(GMT+02:00) Europe, Sofia',
        'Europe/Tallinn' => '(GMT+02:00) Europe, Tallinn',
        'Europe/Vilnius' => '(GMT+02:00) Europe, Vilnius',
        'Africa/Addis_Ababa' => '(GMT+03:00) Africa, Addis Ababa',
        'Africa/Asmara' => '(GMT+03:00) Africa, Asmara',
        'Africa/Dar_es_Salaam' => '(GMT+03:00) Africa, Dar es Salaam',
        'Africa/Djibouti' => '(GMT+03:00) Africa, Djibouti',
        'Africa/Kampala' => '(GMT+03:00) Africa, Kampala',
        'Africa/Mogadishu' => '(GMT+03:00) Africa, Mogadishu',
        'Africa/Nairobi' => '(GMT+03:00) Africa, Nairobi',
        'Antarctica/Syowa' => '(GMT+03:00) Antarctica, Syowa',
        'Asia/Aden' => '(GMT+03:00) Asia, Aden',
        'Asia/Amman' => '(GMT+03:00) Asia, Amman',
        'Asia/Baghdad' => '(GMT+03:00) Asia, Baghdad',
        'Asia/Bahrain' => '(GMT+03:00) Asia, Bahrain',
        'Asia/Damascus' => '(GMT+03:00) Asia, Damascus',
        'Asia/Kuwait' => '(GMT+03:00) Asia, Kuwait',
        'Asia/Qatar' => '(GMT+03:00) Asia, Qatar',
        'Asia/Riyadh' => '(GMT+03:00) Asia, Riyadh',
        'Europe/Istanbul' => '(GMT+03:00) Europe, Istanbul',
        'Europe/Kirov' => '(GMT+03:00) Europe, Kirov',
        'Europe/Minsk' => '(GMT+03:00) Europe, Minsk',
        'Europe/Moscow' => '(GMT+03:00) Europe, Moscow',
        'Europe/Simferopol' => '(GMT+03:00) Europe, Simferopol',
        'Europe/Volgograd' => '(GMT+03:00) Europe, Volgograd',
        'Indian/Antananarivo' => '(GMT+03:00) Indian, Antananarivo',
        'Indian/Comoro' => '(GMT+03:00) Indian, Comoro',
        'Indian/Mayotte' => '(GMT+03:00) Indian, Mayotte',
        'Asia/Tehran' => '(GMT+03:30) Asia, Tehran',
        'Asia/Baku' => '(GMT+04:00) Asia, Baku',
        'Asia/Dubai' => '(GMT+04:00) Asia, Dubai',
        'Asia/Muscat' => '(GMT+04:00) Asia, Muscat',
        'Asia/Tbilisi' => '(GMT+04:00) Asia, Tbilisi',
        'Asia/Yerevan' => '(GMT+04:00) Asia, Yerevan',
        'Europe/Astrakhan' => '(GMT+04:00) Europe, Astrakhan',
        'Europe/Samara' => '(GMT+04:00) Europe, Samara',
        'Europe/Saratov' => '(GMT+04:00) Europe, Saratov',
        'Europe/Ulyanovsk' => '(GMT+04:00) Europe, Ulyanovsk',
        'Indian/Mahe' => '(GMT+04:00) Indian, Mahe',
        'Indian/Mauritius' => '(GMT+04:00) Indian, Mauritius',
        'Indian/Reunion' => '(GMT+04:00) Indian, Reunion',
        'Asia/Kabul' => '(GMT+04:30) Asia, Kabul',
        'Antarctica/Mawson' => '(GMT+05:00) Antarctica, Mawson',
        'Asia/Aqtau' => '(GMT+05:00) Asia, Aqtau',
        'Asia/Aqtobe' => '(GMT+05:00) Asia, Aqtobe',
        'Asia/Ashgabat' => '(GMT+05:00) Asia, Ashgabat',
        'Asia/Atyrau' => '(GMT+05:00) Asia, Atyrau',
        'Asia/Dushanbe' => '(GMT+05:00) Asia, Dushanbe',
        'Asia/Karachi' => '(GMT+05:00) Asia, Karachi',
        'Asia/Oral' => '(GMT+05:00) Asia, Oral',
        'Asia/Qyzylorda' => '(GMT+05:00) Asia, Qyzylorda',
        'Asia/Samarkand' => '(GMT+05:00) Asia, Samarkand',
        'Asia/Tashkent' => '(GMT+05:00) Asia, Tashkent',
        'Asia/Yekaterinburg' => '(GMT+05:00) Asia, Yekaterinburg',
        'Indian/Kerguelen' => '(GMT+05:00) Indian, Kerguelen',
        'Indian/Maldives' => '(GMT+05:00) Indian, Maldives',
        'Asia/Colombo' => '(GMT+05:30) Asia, Colombo',
        'Asia/Kolkata' => '(GMT+05:30) Asia, Kolkata',
        'Asia/Kathmandu' => '(GMT+05:45) Asia, Kathmandu',
        'Antarctica/Vostok' => '(GMT+06:00) Antarctica, Vostok',
        'Asia/Almaty' => '(GMT+06:00) Asia, Almaty',
        'Asia/Bishkek' => '(GMT+06:00) Asia, Bishkek',
        'Asia/Dhaka' => '(GMT+06:00) Asia, Dhaka',
        'Asia/Omsk' => '(GMT+06:00) Asia, Omsk',
        'Asia/Qostanay' => '(GMT+06:00) Asia, Qostanay',
        'Asia/Thimphu' => '(GMT+06:00) Asia, Thimphu',
        'Asia/Urumqi' => '(GMT+06:00) Asia, Urumqi',
        'Indian/Chagos' => '(GMT+06:00) Indian, Chagos',
        'Asia/Yangon' => '(GMT+06:30) Asia, Yangon',
        'Indian/Cocos' => '(GMT+06:30) Indian, Cocos',
        'Antarctica/Davis' => '(GMT+07:00) Antarctica, Davis',
        'Asia/Bangkok' => '(GMT+07:00) Asia, Bangkok',
        'Asia/Barnaul' => '(GMT+07:00) Asia, Barnaul',
        'Asia/Ho_Chi_Minh' => '(GMT+07:00) Asia, Ho Chi Minh',
        'Asia/Hovd' => '(GMT+07:00) Asia, Hovd',
        'Asia/Jakarta' => '(GMT+07:00) Asia, Jakarta',
        'Asia/Krasnoyarsk' => '(GMT+07:00) Asia, Krasnoyarsk',
        'Asia/Novokuznetsk' => '(GMT+07:00) Asia, Novokuznetsk',
        'Asia/Novosibirsk' => '(GMT+07:00) Asia, Novosibirsk',
        'Asia/Phnom_Penh' => '(GMT+07:00) Asia, Phnom Penh',
        'Asia/Pontianak' => '(GMT+07:00) Asia, Pontianak',
        'Asia/Tomsk' => '(GMT+07:00) Asia, Tomsk',
        'Asia/Vientiane' => '(GMT+07:00) Asia, Vientiane',
        'Indian/Christmas' => '(GMT+07:00) Indian, Christmas',
        'Asia/Brunei' => '(GMT+08:00) Asia, Brunei',
        'Asia/Choibalsan' => '(GMT+08:00) Asia, Choibalsan',
        'Asia/Hong_Kong' => '(GMT+08:00) Asia, Hong Kong',
        'Asia/Irkutsk' => '(GMT+08:00) Asia, Irkutsk',
        'Asia/Kuala_Lumpur' => '(GMT+08:00) Asia, Kuala Lumpur',
        'Asia/Kuching' => '(GMT+08:00) Asia, Kuching',
        'Asia/Macau' => '(GMT+08:00) Asia, Macau',
        'Asia/Makassar' => '(GMT+08:00) Asia, Makassar',
        'Asia/Manila' => '(GMT+08:00) Asia, Manila',
        'Asia/Shanghai' => '(GMT+08:00) Asia, Shanghai',
        'Asia/Singapore' => '(GMT+08:00) Asia, Singapore',
        'Asia/Taipei' => '(GMT+08:00) Asia, Taipei',
        'Asia/Ulaanbaatar' => '(GMT+08:00) Asia, Ulaanbaatar',
        'Australia/Perth' => '(GMT+08:00) Australia, Perth',
        'Australia/Eucla' => '(GMT+08:45) Australia, Eucla',
        'Asia/Chita' => '(GMT+09:00) Asia, Chita',
        'Asia/Dili' => '(GMT+09:00) Asia, Dili',
        'Asia/Jayapura' => '(GMT+09:00) Asia, Jayapura',
        'Asia/Khandyga' => '(GMT+09:00) Asia, Khandyga',
        'Asia/Pyongyang' => '(GMT+09:00) Asia, Pyongyang',
        'Asia/Seoul' => '(GMT+09:00) Asia, Seoul',
        'Asia/Tokyo' => '(GMT+09:00) Asia, Tokyo',
        'Asia/Yakutsk' => '(GMT+09:00) Asia, Yakutsk',
        'Pacific/Palau' => '(GMT+09:00) Pacific, Palau',
        'Australia/Darwin' => '(GMT+09:30) Australia, Darwin',
        'Antarctica/DumontDUrville' => '(GMT+10:00) Antarctica, DumontDUrville',
        'Asia/Ust-Nera' => '(GMT+10:00) Asia, Ust-Nera',
        'Asia/Vladivostok' => '(GMT+10:00) Asia, Vladivostok',
        'Australia/Brisbane' => '(GMT+10:00) Australia, Brisbane',
        'Australia/Lindeman' => '(GMT+10:00) Australia, Lindeman',
        'Pacific/Chuuk' => '(GMT+10:00) Pacific, Chuuk',
        'Pacific/Guam' => '(GMT+10:00) Pacific, Guam',
        'Pacific/Port_Moresby' => '(GMT+10:00) Pacific, Port Moresby',
        'Pacific/Saipan' => '(GMT+10:00) Pacific, Saipan',
        'Australia/Adelaide' => '(GMT+10:30) Australia, Adelaide',
        'Australia/Broken_Hill' => '(GMT+10:30) Australia, Broken Hill',
        'Antarctica/Casey' => '(GMT+11:00) Antarctica, Casey',
        'Antarctica/Macquarie' => '(GMT+11:00) Antarctica, Macquarie',
        'Asia/Magadan' => '(GMT+11:00) Asia, Magadan',
        'Asia/Sakhalin' => '(GMT+11:00) Asia, Sakhalin',
        'Asia/Srednekolymsk' => '(GMT+11:00) Asia, Srednekolymsk',
        'Australia/Hobart' => '(GMT+11:00) Australia, Hobart',
        'Australia/Lord_Howe' => '(GMT+11:00) Australia, Lord Howe',
        'Australia/Melbourne' => '(GMT+11:00) Australia, Melbourne',
        'Australia/Sydney' => '(GMT+11:00) Australia, Sydney',
        'Pacific/Bougainville' => '(GMT+11:00) Pacific, Bougainville',
        'Pacific/Efate' => '(GMT+11:00) Pacific, Efate',
        'Pacific/Guadalcanal' => '(GMT+11:00) Pacific, Guadalcanal',
        'Pacific/Kosrae' => '(GMT+11:00) Pacific, Kosrae',
        'Pacific/Noumea' => '(GMT+11:00) Pacific, Noumea',
        'Pacific/Pohnpei' => '(GMT+11:00) Pacific, Pohnpei',
        'Asia/Anadyr' => '(GMT+12:00) Asia, Anadyr',
        'Asia/Kamchatka' => '(GMT+12:00) Asia, Kamchatka',
        'Pacific/Fiji' => '(GMT+12:00) Pacific, Fiji',
        'Pacific/Funafuti' => '(GMT+12:00) Pacific, Funafuti',
        'Pacific/Kwajalein' => '(GMT+12:00) Pacific, Kwajalein',
        'Pacific/Majuro' => '(GMT+12:00) Pacific, Majuro',
        'Pacific/Nauru' => '(GMT+12:00) Pacific, Nauru',
        'Pacific/Norfolk' => '(GMT+12:00) Pacific, Norfolk',
        'Pacific/Tarawa' => '(GMT+12:00) Pacific, Tarawa',
        'Pacific/Wake' => '(GMT+12:00) Pacific, Wake',
        'Pacific/Wallis' => '(GMT+12:00) Pacific, Wallis',
        'Antarctica/McMurdo' => '(GMT+13:00) Antarctica, McMurdo',
        'Pacific/Apia' => '(GMT+13:00) Pacific, Apia',
        'Pacific/Auckland' => '(GMT+13:00) Pacific, Auckland',
        'Pacific/Fakaofo' => '(GMT+13:00) Pacific, Fakaofo',
        'Pacific/Kanton' => '(GMT+13:00) Pacific, Kanton',
        'Pacific/Tongatapu' => '(GMT+13:00) Pacific, Tongatapu',
        'Pacific/Chatham' => '(GMT+13:45) Pacific, Chatham',
        'Pacific/Kiritimati' => '(GMT+14:00) Pacific, Kiritimati',
    );


    return $timezon_arr;
}

function getDateFormat()
{
    $date_format = array('Y-m-d' => 'yyyy-mm-dd', 'Y/m/d' => 'yyyy/mm/dd', 'Y.m.d' => 'yyyy.mm.dd', 'd-M-Y' => 'dd-mmm-yyyy', 'd/M/Y' => 'dd/mmm/yyyy', 'd.M.Y' => 'dd.mmm.yyyy', 'd-m-Y' => 'dd-mm-yyyy', 'd/m/Y' => 'dd/mm/yyyy', 'd.m.Y' => 'dd.mm.yyyy', 'm-d-Y' => 'mm-dd-yyyy', 'm/d/Y' => 'mm/dd/yyyy', 'm.d.Y' => 'mm.dd.yyyy');

    return $date_format;
}


function getBackUser()
{
    $payload = null;
    if (!empty(getUserSession())) {
        $payload = getUserSession();
        $payload = $payload['user'];
        if (!is_null($payload)) {
            $path = WRITEPATH . 'uploads/';
            $publicPath = FCPATH;
            $fullpath = $path . $payload->profile_pic;
            if (is_file($fullpath)) {
                $profile_pic = base_url('file?str=' . $payload->profile_pic);
                $payload->user_profile_pic = $profile_pic;
            } else {
                $payload->user_profile_pic = uiAvatars($payload->full_name);
            }
        }
    }
    return $payload;
}

function uiAvatars($full_name)
{
    return UI_AVATARS . "?name=$full_name&background=random&color=0000";
}

function dateDiff($date)
{
    $dStart = new \DateTime($date);
    $dEnd  = new \DateTime();
    $dDiff = $dStart->diff($dEnd);
    return  $dDiff->format('%r%a')  + 1;
}

if (!function_exists('portalView')) {
    /**
     * Back Panel Access Set View
     *
     * @param string $name
     * @param array  $data
     * @param array  $options
     * @return string
     */
    function portalView(string $name, array $data = [], array $options = []): string
    {
        return view(
            'portal/' . $name,
            $data,
            $options
        );
    }
}

if (!function_exists('portalUrl')) {
    /**
     * Back Panel Access Set Base Url 
     *
     * @param string|null $route
     * @param string|null $scheme
     * @return string
     */
    function portalUrl(?string $route = null, ?string $scheme = null): string
    {
        return base_url(
            'portal/' . ($route ?? ''),
            $scheme
        );
    }
}



if (! function_exists('generateBreadcrumbs')) {
    /**
     * Common method to generate breadcrumbs
     * @param array $customCrumbs Optional custom crumbs [ ['title' => 'Name', 'url' => '/path'], ... ]
     * @param bool $autoGenerate Whether to auto-generate crumbs based on URL segments
     * @return string Rendered breadcrumb HTML
     */
    function generateBreadcrumbs(array $customCrumbs = [], bool $autoGenerate = true): string
    {
        $breadcrumbs = new Breadcrumbs();
        // Always add Home breadcrumb
        // $breadcrumbs->add('Home', '/admin');

        if ($autoGenerate) {
            // Auto-generate breadcrumbs based on URL segments
            $uri = service('uri');
            $segments = $uri->getSegments();
            // getPrint($segments);
            $path = '/';

            foreach ($segments as $index => $segment) {
                if ($segment === 'portal') {
                    continue;
                }
                $path .= '/' . $segment;
                $title = ucwords(str_replace('-', ' ', $segment));
                $breadcrumbs->add($title, $path);
            }
        }

        // Add custom breadcrumbs if provided
        foreach ($customCrumbs as $crumb) {
            if (isset($crumb['title'], $crumb['url'])) {
                $breadcrumbs->add($crumb['title'], $crumb['url']);
            }
        }

        return $breadcrumbs->render();
    }
}
if (! function_exists('generatePageTitle')) {
    /**
     * Common method to generate page title
     * @param string|null $customTitle Custom title for the page
     * @param bool $autoGenerate Whether to auto-generate title from URL segments
     * @return string Formatted page title
     */
    function generatePageTitle(?string $customTitle = null, bool $autoGenerate = true): string
    {
        $baseTitle = 'Admin Panel';
        $pageTitle = '';

        if ($customTitle) {
            // Use custom title if provided
            $pageTitle = $customTitle;
        } elseif ($autoGenerate) {
            // Auto-generate title from URL segments
            $uri = service('uri');
            $segments = array_slice($uri->getSegments(), 1); // Skip 'portal'
            if (empty($segments)) {
                $pageTitle = 'Login '; // Default for /portal (post-login)
            } else {
                // Use last segment for title
                $lastSegment = end($segments);
                $pageTitle = ucwords(str_replace('-', ' ', $lastSegment));
            }
        }

        return $pageTitle ? "::: $pageTitle || $baseTitle :::" : $baseTitle;
    }
}

if (! function_exists('show404')) {
    /**
     * Show a 404 Page Not Found error.
     *
     * This helper function is a shortcut for throwing CodeIgniter's
     * PageNotFoundException. It will automatically display the configured
     * 404 error page or a custom one if defined in Routes.php.
     *
     * Example:
     *     if (! $user) {
     *         show404();
     *     }
     *
     * @param string $message Optional custom message for the 404 error.
     *
     * @throws PageNotFoundException
     * @return void
     */
    function show404(string $message = 'Page Not Found'): void
    {
        throw PageNotFoundException::forPageNotFound($message);
    }
}


if (! function_exists('fetchRecords')) {
    /**
     * Universal SELECT query handler
     *
     * @param string $table   Main table (with alias if needed)
     * @param array  $options Query options (all keys optional)
     * 
     * Supported keys:
     *  - select      : array|string (columns to select)
     *  - distinct    : bool
     *  - joins       : array [['table'=>'roles r','condition'=>'u.role_id=r.id','type'=>'left']]
     *  - where       : array
     *  - orWhere     : array
     *  - whereIn     : array ['id' => [1,2,3]]
     *  - whereNotIn  : array
     *  - like        : array ['name'=>'John']
     *  - orLike      : array
     *  - notLike     : array
     *  - groupBy     : string|array
     *  - having      : array|string
     *  - orderBy     : array ['id'=>'DESC']
     *  - limit       : int
     *  - offset      : int
     *  - returnType  : string (array|object|row|rowArray) default: array
     *
     * @return array|object|null
     */
    function fetchRecords(string $table, array $options = [])
    {
        $db = Database::connect();
        $builder = $db->table($table);

        // DISTINCT
        if (!empty($options['distinct'])) {
            $builder->distinct();
        }

        // SELECT
        $builder->select(
            !empty($options['select'])
                ? (is_array($options['select']) ? implode(',', $options['select']) : $options['select'])
                : '*'
        );

        // JOINS
        if (!empty($options['joins'])) {
            foreach ($options['joins'] as $join) {
                $builder->join(
                    $join['table'],
                    $join['condition'],
                    $join['type'] ?? '' // left, right, inner
                );
            }
        }

        // WHERE
        if (!empty($options['where'])) {
            $builder->where($options['where']);
        }
        if (!empty($options['orWhere'])) {
            foreach ($options['orWhere'] as $field => $val) {
                $builder->orWhere($field, $val);
            }
        }

        // WHERE IN / NOT IN
        if (!empty($options['whereIn'])) {
            foreach ($options['whereIn'] as $field => $values) {
                $builder->whereIn($field, $values);
            }
        }
        if (!empty($options['whereNotIn'])) {
            foreach ($options['whereNotIn'] as $field => $values) {
                $builder->whereNotIn($field, $values);
            }
        }

        // LIKE / NOT LIKE
        if (!empty($options['like'])) {
            foreach ($options['like'] as $field => $value) {
                $builder->like($field, $value);
            }
        }
        if (!empty($options['orLike'])) {
            foreach ($options['orLike'] as $field => $value) {
                $builder->orLike($field, $value);
            }
        }
        if (!empty($options['notLike'])) {
            foreach ($options['notLike'] as $field => $value) {
                $builder->notLike($field, $value);
            }
        }

        // GROUP BY
        if (!empty($options['groupBy'])) {
            $builder->groupBy($options['groupBy']);
        }

        // HAVING
        if (!empty($options['having'])) {
            $builder->having($options['having']);
        }

        // ORDER BY
        if (!empty($options['orderBy'])) {
            foreach ($options['orderBy'] as $field => $direction) {
                $builder->orderBy($field, $direction);
            }
        }

        // LIMIT + OFFSET
        if (!empty($options['limit'])) {
            $builder->limit($options['limit'], $options['offset'] ?? 0);
        }

        // RUN QUERY
        $query = $builder->get();

        // RETURN TYPE
        $returnType = $options['returnType'] ?? 'array'; // default: array
        switch ($returnType) {
            case 'object':
                return $query->getResult();       // list of objects
            case 'row':
                return $query->getRow();          // single object
            case 'rowArray':
                return $query->getRowArray();     // single row as array
            default:
                return $query->getResultArray();  // list of arrays
        }
    }
}
