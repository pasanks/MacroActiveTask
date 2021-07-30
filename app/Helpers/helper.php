<?php

//mail sending helper
function sendEmail($toAddress, $mailDetails)
{
    try {
        \Mail::to($toAddress)->send($mailDetails);
    } catch (\Exception $ex) {
        \Log::alert('Mail send error: ' . $ex->getMessage());
    }
}
