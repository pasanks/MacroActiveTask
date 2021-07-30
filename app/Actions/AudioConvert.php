<?php

namespace App\Actions;

use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use Illuminate\Support\Facades\Config;

class AudioConvert
{
    /**
     *Cloud Convert client
     *
     * @var
     */
    protected $cloudconvert;

    protected $job;

    /**
     * AudioConvert constructor.
     */
    public function __construct()
    {
        $this->cloudconvert = new CloudConvert([
            'api_key' => Config::get('cloudconvert.api_key'),
            'sandbox' => Config::get('cloudconvert.sandbox'),
        ]);
    }

    /**
     * @param $jobID
     * @param $file
     */
    public function process($jobID, $file): void
    {
        $this->job = (new Job())
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

        $this->cloudconvert->jobs()->create($this->job);
        $uploadTask = $this->job->getTasks()->whereName('upload-' . $jobID)[0];
        $this->cloudconvert->tasks()->upload($uploadTask, file_get_contents($file), $jobID . '.mp3');
        $this->cloudconvert->jobs()->wait($this->job); // Wait for job completion
        $this->saveConvertedFiles($jobID);
    }

    public function saveConvertedFiles($jobID)
    {
        foreach ($this->job->getExportUrls() as $file) {
            $source = $this->cloudconvert->getHttpTransport()->download($file->url)->detach();
            $dest = fopen(public_path() . '/file_outputs/' . $jobID . '.mp3', 'w');
            stream_copy_to_stream($source, $dest);
        }
    }

}
