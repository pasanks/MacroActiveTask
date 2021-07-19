<?php

//job number generation for conversion jobs
function generateRandomJobID($length = 10)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString . "-" . date('Ymdhis');
}

//mail sending helper
function sendEmail($toAddress, $mailDetails)
{
    try {
        \Mail::to($toAddress)->send($mailDetails);
    } catch (\Exception $ex) {
        \Log::alert('Mail send error: ' . $ex->getMessage());
    }
}
