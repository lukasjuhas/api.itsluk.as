<?php

namespace Transformers;

class PhotoDataTransformer extends Transformer
{
    public function transform($data)
    {
        $data = unserialize($data);
        return [
            'MimeType' => $data['MimeType'],
            'computed' => $data['COMPUTED'],
            'ImageDescription' => $data['ImageDescription'],
            'Make' => $data['Make'],
            'Model' => $data['Model'],
            'Copyright' => $data['Copyright'],
            'ExposureTime' => $data['ExposureTime'],
            'FNumber' => $data['FNumber'],
            'DateTimeOriginal' => $data['DateTimeOriginal'],
            'UserComment' => $data['UserComment'],
            'GPSLatitudeRef' => $data['GPSLatitudeRef'],
            'GPSLatitude' => $data['GPSLatitude'],
            'GPSLongitudeRef' => $data['GPSLongitudeRef'],
            'GPSLongitude' => $data['GPSLongitude'],
            'Model' => $data['Model'],
            'Model' => $data['Model'],
            'Model' => $data['Model'],
        ];
    }
}
