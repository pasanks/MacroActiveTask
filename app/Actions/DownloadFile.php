<?php

namespace App\Actions;

use App\Models\ConvertJob;
use Response;

class DownloadFile
{
    /**
     * @var
     */
    protected $jobDetails;

    /**
     * DownloadFile constructor.
     * @param $jobID
     */
    public function __construct($jobID)
    {
        $this->jobDetails = ConvertJob::find($jobID);
    }

    /**
     * @return mixed
     */
    public function download()
    {
        $downloadFile = public_path() . $this->jobDetails->output_file;
        return Response::download($downloadFile, $this->jobDetails->file_download_name . '.mp3');
    }
}
