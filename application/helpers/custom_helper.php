<?php

/**
 * Fungsi handle access live url
 *
 * @return boolean
 */
function is_login()
{
    $ci = &get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }
}

/**
 * remove charachter '=' in Base64_encode result
 *
 * @param string $param
 * @return string
 */
function encodeParamUrl($param)
{
    // source: https://stackoverflow.com/questions/6543390/using-a-base64-encoded-string-in-url-with-codeigniter
    $base_64 = base64_encode($param);
    $url_param = rtrim($base_64, '=');

    // and later:
    // $base_64 = $url_param . str_repeat('=', strlen($url_param) % 4);
    // $data = base64_decode($base_64);
    return $url_param;
}

/**
 * Konversi tanggal ke format indonesia
 *
 * @param string $tanggal
 * @param boolean $cetak_hari
 * @return string
 */
function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }

    return $tgl_indo;
}

function bulan_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('-', $tanggal);
    $tgl_indo = $bulan[(int)$split[1]] . '-' . $split[0];
    return $tgl_indo;
}

/**
 * format date custom
 * @param string $var sumber data date
 * @param string $date_format_awal format tanggal sesuai data (ex: "d/m/y")
 * @param string $date_format_output format tanggal yang diinginkan (ex: "Y-m-d");
 * ```
 * formatDate($varibleDate, 'y/m/d', 'Y-m-d');
 * ```
 */
function formatDate($var, $date_format_awal, $date_format_output)
{
    // $parse_awal = date_create_from_format($date_format_awal, $var);
    // $output = date_format($parse_awal, $date_format_output);

    $parse_awal = DateTime::createFromFormat($date_format_awal, $var);
    $output = $parse_awal->format($date_format_output);
    return $output;
}

/**
 * Custom notification
 * @return  integer 
 */
function countNotif($followup, $pic_id, $departement_id)
{
    // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model('m_autoload');

    // Call a function of the model
    $result = $CI->m_autoload->countNotif($followup, $pic_id, $departement_id);

    return $result;
}

function userInfos()
{
    // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model('m_autoload');

    // Call a function of the model
    $result = $CI->m_autoload->getUser();

    return $result;
}
