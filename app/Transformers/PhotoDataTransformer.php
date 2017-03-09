<?php

namespace Transformers;

class PhotoDataTransformer extends Transformer
{
    public function transform($data)
    {
        $data = unserialize($data);

        return [
            'MimeType' => $data['MimeType'],
            'Make' => $data['Make'],
            'Model' => $data['Model'],
            'Copyright' => $data['Copyright'],
            'ExposureTime' => $data['ExposureTime'],
            'FNumber' => $data['FNumber'],
            'DateTimeOriginal' => $data['DateTimeOriginal'],
            'FocalLength' => $data['FocalLength'],
            'ISOSpeedRatings' => $data['ISOSpeedRatings'],
        ];
    }
}
