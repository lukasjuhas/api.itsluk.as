<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Filesystem\FilesystemManager as Filesystem;
use Intervention\Image\Facades\Image;
use App\Photo;
use App\Trip;
use Kraken;

class PhotosController extends ApiController
{
    protected $aws_path = 'photos/';

    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->photoTransformer = app(\Transformers\PhotoTransformer::class);
    }

    /**
     * get feed of photos
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ? : 9;
        if ($limit > 50) {
            $limit = 50;
        }

        $photos = Photo::paginate($limit);

        return $this->respondWithPagination($photos, [
            'data' => $this->photoTransformer->transformCollection($photos->all())
        ]);
    }

    /**
     * show specific photo based on given id
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $photo = Photo::find($id);

        if (!$photo) {
            return $this->respondNotFound('Photo does not exists.');
        }

        return $this->respond([
            'data' => $this->photoTransformer->transform($photo),
        ]);
    }

    /**
     * store a new photo
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, Filesystem $filesystem)
    {
        // validate fields
        if (!$request->hasFile('photo') || !$request->get('trip')) {
            return $this->respondWithValidationError('Parameters failed validation for a photo.');
        }

        $trip = Trip::where('slug', $request->get('trip'))->first();

        foreach ($request->file('photo') as $key => $photo) {
            $filename  = time() . '.' . $photo->getClientOriginalExtension();
            $path = $this->aws_path . $filename;
            $path_thumb = $this->aws_path . 'thumb_' . $filename;

            // create image size for post
            $formated_image = Image::make($photo)->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg');


            // createa thumbnail
            $canvas = Image::canvas(250, 250, '#000000');
            $formated_thumb = Image::make($photo)->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg');
            $canvas->insert($formated_thumb, 'center');

            // set exif so we can save this in to DB before we optimise images
            $exif = $formated_image->exif();

            // set size
            $size = [];
            $size['width'] = $formated_image->width();
            $size['height'] = $formated_image->height();

            // set orientation
            $orientation = 'portrait';
            if ($size['width'] > $size['height']) {
                $orientation = 'landscape';
            } elseif ($size['width'] === $size['height']) {
                $orientation = 'square';
            }

            // This is causing errors because of some sort of formating
            unset($exif['MakerNote']);

            // create stream for iamges
            $formated_image = $formated_image->stream();
            $canvas = $canvas->stream();

            // save to aws, they will get overwritten after krakening
            $file = $filesystem->disk('s3')->put($path, $formated_image->__toString());
            $thumb = $filesystem->disk('s3')->put($path_thumb, $canvas->__toString());

            // KRAKE image
            $kraken = new Kraken(env('KRAKEN_API_KEY'), env('KRAKEN_API_SECRET'));
            if ($kraken && $file) {
                $krake_file = $kraken->upload([
                    'file' => $filesystem->disk('s3')->url($path),
                    'wait' => true,
                    's3_store' => [
                        'key' => env('AWS_KEY'),
                        'secret' => env('AWS_SECRET'),
                        'region' => env('AWS_REGION'),
                        'bucket' => env('AWS_BUCKET'),
                        'path' => $path,
                    ]
                ]);
            }

            // KRAKE thumb
            if ($kraken && $thumb) {
                $krake_thumb = $kraken->upload([
                    'file' => $filesystem->disk('s3')->url($path_thumb),
                    'wait' => true,
                    's3_store' => [
                        'key' => env('AWS_KEY'),
                        'secret' => env('AWS_SECRET'),
                        'region' => env('AWS_REGION'),
                        'bucket' => env('AWS_BUCKET'),
                        'path' => $path_thumb,
                    ]
                ]);
            }

            $file_url = $filesystem->disk('s3')->url($path);
            $thumb_url = $filesystem->disk('s3')->url($path_thumb);

            if ($file_url) {
                $photo = Photo::create([
                  'user_id' => 1,
                  'trip_id' => $trip->id,
                  'title' => $filename,
                  'caption' => '',
                  'thumb' => $thumb_url,
                  'url' => $file_url,
                  'size' => serialize($size),
                  'orientation' => $orientation,
                  'data' => serialize($exif),
                  'status' => 'published'
              ]);
            }
        }

        // send propriet response
        if ($photo) {
            return $this->respondCreated('Photos successfully uploaded.');
        }

        return $this->respondInternalError('There was a problem uploading new photos.');
    }

    /**
     * update photo
     *
     * @param Request $request
     * @param Int $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $photo = Photo::where('id', $id)->first();

        if (!$photo) {
            return $this->respondNotFound('Photo does not exists.');
        }

        $update = $photo->update([
            'caption' => $request->get('content'),
        ]);

        if ($update) {
            return $this->respondUpdated('Photo caption successfully updated.', $photo->id);
        }

        return $this->respondWithError('There was problem updating caption.');
    }

    /**
     * update order
     *
     * @param Request $request
     * @return mixed
     */
    public function updateOrder(Request $request)
    {
        $photos = $request->get('photos');

        if (!$photos) {
            return $this->respondWithValidationError();
        }

        foreach ($photos as $id => $order) {
            $photo = Photo::where('id', $id)->first();

            if (!$photo) {
                continue;
            }

            $update = $photo->update([
                'order' => $order,
            ]);
        }

        if ($update) {
            return $this->respondUpdated('Photo order updated.');
        }

        return $this->respondWithError('There was problem updating order of the photos.');
    }

    /**
     * remove photo
     * 
     * @param Int $id
     * @return mixed
     */
    public function delete($id, Filesystem $filesystem)
    {
        if (!$id) {
            return $this->respondWithValidationError();
        }

        $photo = Photo::where('id', $id)->first();

        // remove from aws
        $file = $filesystem->disk('s3')->delete('photos/' . basename($photo->url));
        $thumb = $filesystem->disk('s3')->delete('photos/' . basename($photo->thumb));

        // if there is problem removing from aws
        if (!$file || !$thumb) {
            return $this->respondWithError('There was problem removing your photo in AWS.');
        }

        // remove from the database
        $deleted = $photo->delete();

        if ($deleted) {
            return $this->respondUpdated('Photo successfully removed.');
        }

        return $this->respondWithError('There was problem removing your photo.');
    }
}
