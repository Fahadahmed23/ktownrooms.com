<?php

namespace App\Libraries;

class Sms {
    public static function send($contact_no, $message) {
        // get details from config
        $username = env('SMS_USERNAME', false);
        $password = env('SMS_PASSWORD', false);
        $from = env('SMS_FROM', false);

        $message = \urlencode($message);

        $curl = curl_init();

        // $url = "http://pk.eocean.us/APIManagement/API/RequestAPI?user=ktown_rooms&pwd=ANxjeLj%252fFx8uVWXJyKXkiT2M0T3ash8y5r0Q9B%252bSn8qvwYdqmCiM6xFhs2rIV9X3MQ%253d%253d&sender=KTOWN%2520ROOMS&reciever=" . $contact_no . "&msg-data=" . urlencode($message) . "D&response=json";
        $url = "http://pk.eocean.us/APIManagement/API/RequestAPI?user=ktown_rooms&pwd=ANxjeLj%2fFx8uVWXJyKXkiT2M0T3ash8y5r0Q9B%2bSn8qvwYdqmCiM6xFhs2rIV9X3MQ%3d%3d&sender=KTOWN%20ROOMS&reciever=" . $contact_no . "&msg-data=" . $message . "&response=json";

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // // send sms using curl
        // $url = "https://pk.eocean.us/APIManagement/API/RequestAPI?user=ktown_rooms&pwd=ANxjeLj%2fFx8uVWXJyKXkiT2M0T3ash8y5r0Q9B%2bSn8qvwYdqmCiM6xFhs2rIV9X3MQ%3d%3d&sender=KTOWN%20ROOMS&reciever=$contact_no&msg-data=$message&response=json";
        // $ch = curl_init();
        // $timeout = 30;
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        // $response = curl_exec($ch);
        // curl_close($ch);

        // dd($url);
    }

    protected function formatCellNumber($no) {
        return str_replace(['-', '(', ')', '+'], '', $no);
    }
}