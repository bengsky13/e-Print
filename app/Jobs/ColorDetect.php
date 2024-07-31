<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use setasign\Fpdi\Fpdi;
use League\ColorExtractor\Palette;
use League\ColorExtractor\Color;
use Illuminate\Queue\SerializesModels;

class ColorDetect implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id;
    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $id = $this->id;
        $folder = "public/uploads/$id/";
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($folder."file.pdf");
        $coloredPage = [];
        $imagick = new \Imagick();
        if(!file_exists($folder."tmp.txt")){
            file_put_contents($folder."tmp.txt", "0");
            file_put_contents($folder."data.json", "[]");
            file_put_contents($folder."finish.txt", "0");
        }
        $start = file_get_contents($folder."tmp.txt");
        $coloredPage = json_decode(file_get_contents($folder."data.json"));
        if($start+1 !== $pageCount){
                for($x = $start; $x<$pageCount; $x++){
                    $imagick->readImage($folder."/file.pdf" . '['.$x.']'); // [0] refers to the first page
                $imagick->setImageFormat('jpeg');
                $imagick->setResolution(300, 300);
                $palette = Palette::fromContents($imagick, Color::fromHexToInt('#FFFFFF'))->getMostUsedColors(5);
                unset($palette[0]);
                unset($palette[16777215]);
                if(count($palette) > 3)
                array_push($coloredPage, $x);
            file_put_contents($folder."tmp.txt", $x);
            file_put_contents($folder."data.json", json_encode($coloredPage));
            $imagick->clear();
            $imagick->destroy();
        }
    }
    file_put_contents($folder."finish.txt", "1");

    }
}
