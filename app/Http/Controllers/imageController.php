<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use Storage;

class imageController extends Controller
{
    //
    public function filter(Request $request)
    {
        Log::debug('enter filter');

        $img = str_replace('data:image/png;base64,', '', $request->imageData);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $timestamp = time();
        $file = $timestamp . ".png";
        Storage::disk('local')->put('public/'.$file, $data);
        $storagePath = asset('storage/');
        Log::debug($storagePath);
        // $success = file_put_contents($file, $data);
        // Log::debug($success ? $file : 'Unable to save the file.');

        $src = imagecreatefrompng('storage/'.$file);

        $imageWidth = imagesx($src);
        $imageHeight = imagesy($src);

        $dst = imagecreatetruecolor($imageWidth, $imageHeight);

        for($i = 0; $i < $imageWidth; $i++){
            for($j = 0; $j < $imageHeight; $j++){
                //get pixel
                $rgb = imagecolorat ($src, $i, $j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $gray = ($r*0.3)+($g*0.59)+($b*0.11);
                $dstColor = imagecolorallocate($dst, $gray, $gray, $gray);
                imagesetpixel($dst, $i,$j, $dstColor);
            }
        }

        $fileOut = $timestamp . "_out.png";
        imagepng($dst, 'storage/'.$fileOut);

        imagedestroy($dst);
        imagedestroy($src);
        unlink('storage/'.$file);

        $dataOut = file_get_contents('storage/'.$fileOut);
        $imageData64 = base64_encode($dataOut);

        unlink('storage/'.$fileOut);

        return view('result')->with(['imageData' => 'data:image/png;base64,'.$imageData64, 'width' => $imageWidth, 'height' => $imageHeight]);
    }
}
