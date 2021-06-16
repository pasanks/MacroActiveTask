<?php

namespace App\Http\Controllers;

use App\Models\ConvertJob;
use Illuminate\Http\Request;
use CloudConvert\CloudConvert;
use \CloudConvert\Models\Job;
use \CloudConvert\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Response;
use Log;

class FileProcessController extends Controller
{

    public function fileConvertForm()
    {
        return view('home');
    }

    /**
     * main function processing file conversion.
     *
     * @param Request $request
     * @return mixed
     */
    public function processFile(Request $request)
    {
        $fileConvertName = $request->get('file_name');
        $file = $request->file('file');
        try {
            $cloudconvert = new CloudConvert([
                'api_key' => Config::get('cloudconvert.api_key'),
                'sandbox' => Config::get('cloudconvert.sandbox')
            ]);

            $saveJobDetails = new ConvertJob();
            $saveJobDetails->user_id = Auth::user()->id;
            $saveJobDetails->job_number = generateRandomJobID();
            $saveJobDetails->file_download_name = $fileConvertName;
            $saveJobDetails->save();

            $jobID = $saveJobDetails->id;

            $job = (new Job())
                ->addTask(new Task('import/upload', 'upload-' . $jobID))
                ->addTask(
                    (new Task('convert', 'convert-' . $jobID))
                        ->set('input', 'upload-' . $jobID)
                        ->set('output_format', 'mp3')
                )
                ->addTask(
                    (new Task('export/url', 'export-' . $jobID))
                        ->set('input', 'convert-' . $jobID)
                );

            $cloudconvert->jobs()->create($job);
            $uploadTask = $job->getTasks()->whereName('upload-' . $jobID)[0];
            $cloudconvert->tasks()->upload($uploadTask, file_get_contents($file), $jobID . '.mp3');
            $cloudconvert->jobs()->wait($job); // Wait for job completion

            foreach ($job->getExportUrls() as $file) {

                $source = $cloudconvert->getHttpTransport()->download($file->url)->detach();
                $dest = fopen(public_path() . '/file_outputs/' . $jobID . ".mp3", 'w');

                stream_copy_to_stream($source, $dest);
            }

            $outputFile = '/file_outputs/' . $jobID . ".mp3";
            ConvertJob::updateJobStatus($jobID, 1, $outputFile);

            $downloadFile = public_path() . "/file_outputs/" . $jobID . '.mp3';
            $details = [
                'title' => 'Your file conversion job is completed',
                'body' => 'This is for testing email using smtp'
            ];
            $mailDetails = new \App\Mail\JobCompletionEmail($details);
            sendEmail(Auth::user()->email, $mailDetails);
            return $jobID;
        } catch (\Exception $ex) {
            Log::alert('An error Occurred while processing the file : ' . $ex->getMessage());
            ConvertJob::updateJobStatus($jobID, 2);
        }
    }

    /**
     * converted output file downloading function
     *
     * @param $jobID
     * @return mixed
     */
    public function downloadFile($jobID)
    {
        $jobDetails = ConvertJob::find($jobID);
        $downloadFile = public_path() . $jobDetails->output_file;

        return Response::download($downloadFile, $jobDetails->file_download_name . '.mp3');
    }

    /**
     * Job history
     *
     */
    public function jobHistoryView()
    {
        $details = ConvertJob::select(['*'])->where('user_id',Auth::user()->id)
            ->paginate(20);
        return view('job_history')->with([
            'details' => $details
        ]);
    }


}
