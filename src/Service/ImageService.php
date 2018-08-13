<?php

namespace App\Service;

use Imagick;

class ImageService
{

    function createMeta($imagickBlob, $original)
    {
        return [
            'blob' => $imagickBlob,
            'Last-Modified' => $original['Last-Modified'],
            'Content-Type' => $original['Content-Type'],
            'ETag' => sha1($imagickBlob),
        ];
    }

    public function resizeImage(Imagick $imagick, $params, $quality = 84)
    {
        $width  = $params['width'];
        $height = $params['height'];
        $method = $params['method'];
        $resourceW = $imagick->getImageWidth();
        $resourceH = $imagick->getImageHeight();
        $factorW = $width / $resourceW;
        $factorH = $height / $resourceH;

        switch ($params['method']) {
            case 'inflate':
            case 'deflate':
                $imagick->resizeImage($width, $height, $imagick::FILTER_UNDEFINED, 1, false);
                break;
            case 'left':
            case 'right':
            case 'top':
            case 'bottom':
            case 'top-left':
            case 'top-right':
            case 'bottom-left':
            case 'bottom-right':
            case 'center':
                $factor = max($factorW, $factorH);
                $imagick->scaleImage((int)round($resourceW * $factor), (int)round($resourceH * $factor), false);

                if (false !== strstr($method, 'top')) {
                    $top = 0;
                } elseif (false !== strstr($method, 'bottom')) {
                    $top = $imagick->getImageHeight() - $height;
                } else {
                    $top = (int)round(($imagick->getImageHeight() - $height) / 2);
                }

                if (false !== strstr($method, 'left')) {
                    $left = 0;
                } elseif (false !== strstr($method, 'right')) {
                    $left = $imagick->getImageWidth() - $width;
                } else {
                    $left = (int)round(($imagick->getImageWidth() - $width) / 2);
                }

                $imagick->cropImage($width, $height, $left, $top);
                break;
            case 'scale':
                $factor = min($factorW, $factorH);
                $imagick->scaleImage((int)round($resourceW * $factor), (int)round($resourceH * $factor), false);
                break;
            case 'fit':
            default:
                break;
        }

        $imagick->setImageCompressionQuality($quality);

        if ('jpeg' == strtolower($imagick->getImageFormat())) {
            $imagick->setInterlaceScheme(Imagick::INTERLACE_PLANE);
        }

        $imagick->setImagePage($width, $height, 0, 0);

        return $imagick->getImageBlob();
    }

}