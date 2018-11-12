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

        $img = str_replace('data:image/jpeg;base64,', '', $request->imageData);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $timestamp = time();
        $file = $timestamp . ".png";
        Storage::disk('local')->put('public/'.$file, $data);
        $storagePath = asset('storage/');
        Log::debug($storagePath);
        // $success = file_put_contents($file, $data);
        // Log::debug($success ? $file : 'Unable to save the file.');

        $src = imagecreatefromjpeg('storage/'.$file);

        $imageWidth = imagesx($src);
        $imageHeight = imagesy($src);

        $grayImage = imagecreatetruecolor($imageWidth, $imageHeight);

        for($i = 0; $i < $imageWidth; $i++){
            for($j = 0; $j < $imageHeight; $j++){
                //get pixel
                $rgb = imagecolorat ($src, $i, $j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $gray = ($r*0.125)+($g*0.25)+($b*0.0625);
                $dstColor = imagecolorallocate($grayImage, $gray, $gray, $gray);
                imagesetpixel($grayImage, $i,$j, $dstColor);
            }
        }

        $base = imagecreatefromjpeg('img/nosFilter_base1.jpg');
        $baseImageWidth = imagesx($base);
        $baseImageHeight = imagesy($base);
        $resizedBase = imagecreatetruecolor($imageWidth, $imageHeight);
        imagecopyresampled($resizedBase, $base, 0, 0, 0, 0, $imageWidth, $imageHeight, $baseImageWidth, $baseImageHeight);

        $resultImage = imagecreatetruecolor($imageWidth, $imageHeight);

        for($i = 0; $i < $imageWidth; $i++){
            for($j = 0; $j < $imageHeight; $j++){
                //get pixel
                $rgbBase = imagecolorat ($resizedBase, $i, $j);
                $baseR = ($rgbBase >> 16) & 0xFF;
                $baseG = ($rgbBase >> 8) & 0xFF;
                $baseB = $rgbBase & 0xFF;

                $kr1 = $baseR*0.75;
                $kg1 = $baseG*0.75;
                $kb1 = $baseB*0.75;

                $rgb = imagecolorat ($grayImage, $i, $j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                //グレースケール画像と土台画像を合成
                $tmpR = $r + $kr1;
                $tmpG = $g + $kg1;
                $tmpB = $b + $kb1;

                $resultR = ($tmpR > 255 ? 255 : $tmpR);
                $resultG = ($tmpG > 255 ? 255 : $tmpG);
                $resultB = ($tmpB > 255 ? 255 : $tmpB);

                $dstColor = imagecolorallocate($resultImage, $resultR, $resultG, $resultB);
                imagesetpixel($resultImage, $i,$j, $dstColor);
            }
        }

        $fileOut = $timestamp . "_out.png";
        imagejpeg($resultImage, 'storage/'.$fileOut, 80);

        imagedestroy($resultImage);
        imagedestroy($resizedBase);
        imagedestroy($grayImage);
        imagedestroy($base);
        imagedestroy($src);
        unlink('storage/'.$file);

        $dataOut = file_get_contents('storage/'.$fileOut);
        $imageData64 = base64_encode($dataOut);

        unlink('storage/'.$fileOut);

        return view('result')->with(['imageData' => 'data:image/jpeg;base64,'.$imageData64, 'width' => $imageWidth, 'height' => $imageHeight]);
    }
/*
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
*/
}
