<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;

class ColorDetect implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id;
    private function calculate_variance($image) {
        $width = imagesx($image);
        $height = imagesy($image);
        $total_pixels = $width * $height;
        $r_sum = $g_sum = $b_sum = 0;
        $r2_sum = $g2_sum = $b2_sum = 0;

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $r_sum += $r;
                $g_sum += $g;
                $b_sum += $b;
                $r2_sum += $r * $r;
                $g2_sum += $g * $g;
                $b2_sum += $b * $b;
            }
        }

        $r_mean = $r_sum / $total_pixels;
        $g_mean = $g_sum / $total_pixels;
        $b_mean = $b_sum / $total_pixels;

        $r_variance = ($r2_sum / $total_pixels) - ($r_mean * $r_mean);
        $g_variance = ($g2_sum / $total_pixels) - ($g_mean * $g_mean);
        $b_variance = ($b2_sum / $total_pixels) - ($b_mean * $b_mean);

        return [$r_variance, $g_variance, $b_variance];
    }

    private function detect_color_image($file) {

        $image = imagecreatefromstring($file);
        $variances = $this->calculate_variance($image);
        imagedestroy($image);
        $is_monochromatic = ($variances[0] < 0.005) &&
                            ($variances[1] < 0.005) &&
                            ($variances[2] < 0.005);


        if ($is_monochromatic) {
            return 4;
        } else {
            if (count($variances) == 3) {
                $max_variance = max($variances);
                $min_variance = min($variances);
                $maxmin = abs($max_variance - $min_variance);

                if ($maxmin > 1000) {
                    return 3;
                } elseif ($maxmin > 0) {
                    return 2;
                } else {
                    return 1;
                }
            } elseif (count($variances) == 1) {
                return 1;
            } else {
                return 3;
            }
        }
    }
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function handle(): void
    {
        $id = $this->id;
        // Log::info("ColorDetect job dispatched with ID: $id Started");
        $folder = "public/uploads/$id/";
        $parser = new Parser();
        $pdf = $parser->parseFile($folder."file.pdf");
        $pageCount = $pdf->getDetails()['Pages'];
        $coloredPage = [];
        $imagick = new \Imagick();
        if(!file_exists($folder."tmp.txt")){
            file_put_contents($folder."tmp.txt", "0");
            file_put_contents($folder."data.json", "[]");
            file_put_contents($folder."finish.txt", "0");
        }
        $finish = file_get_contents($folder."finish.txt");
        if($finish) return;
        $start = file_get_contents($folder."tmp.txt");
        $coloredPage = json_decode(file_get_contents($folder."data.json"));
            for($x = $start; $x<$pageCount; $x++){
                $imagick->readImage($folder."/file.pdf" . '['.$x.']');
                $imagick->setImageFormat('jpeg');
                $palette = $this->detect_color_image($imagick);
                if($palette !== 1)
                    array_push($coloredPage, $x);
                file_put_contents($folder."tmp.txt", $x);
                file_put_contents($folder."data.json", json_encode($coloredPage));
                $imagick->clear();
                $imagick->destroy();
        }
    file_put_contents($folder."finish.txt", "1");
    }
}
