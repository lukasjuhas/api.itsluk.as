<?php

namespace Transformers;

class PhotoDataTransformer extends Transformer
{
    /**
     * transform photo data
     *
     * @param serialised array $data
     * @return array
     */
    public function transform($data)
    {
        $data = unserialize($data);

        return [
            'MimeType' => isset($data['MimeType']) ? $data['MimeType'] : '',
            'Make' => isset($data['Make']) ? $data['Make'] : '',
            'Model' => isset($data['Model']) ? $data['Model'] : '',
            'Copyright' => isset($data['Copyright']) ? $data['Copyright'] : '',
            'ExposureTime' => isset($data['ExposureTime']) ? $data['ExposureTime'] : '',
            'FNumber' => isset($data['FNumber']) ? $data['FNumber'] : '',
            'DateTimeOriginal' => isset($data['DateTimeOriginal']) ? $data['DateTimeOriginal'] : '',
            'FocalLength' => isset($data['FocalLength']) ? $data['FocalLength'] : '',
            'ISOSpeedRatings' => isset($data['ISOSpeedRatings']) ? $data['ISOSpeedRatings'] : '',
        ];
    }
}
