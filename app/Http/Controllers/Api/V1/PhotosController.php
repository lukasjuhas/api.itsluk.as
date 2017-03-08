<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Filesystem\FilesystemManager as Filesystem;
use Intervention\Image\Facades\Image;
use App\Photo;
use App\Trip;

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

        // dd(get_class_methods($photos));

        return $this->respondWithPagination($photos, [
            'data' => $this->photoTransformer->transformCollection($photos->all())
        ]);
    }

    /**
     * show specific photo based on given id
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
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, Filesystem $filesystem)
    {
        // dd($request);
        // validate user request
        // $user = $this->getRequestingUser($request);
        // if (!$user) {
        //     return $this->respondWithValidationError('Authentication failed validation for a photo.');
        // }

        // print_r($request->file('photo')); die();
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


            $exif = $formated_image->exif();

            // This is causing errors because of some sort of formating
            unset($exif['MakerNote']);

            $formated_image = $formated_image->stream();
            $canvas = $canvas->stream();

            // upload to AWS
            $file = $filesystem->disk('s3')->put($path, $formated_image->__toString());
            $thumb = $filesystem->disk('s3')->put($path_thumb, $canvas->__toString());

            if ($file && $thumb) {
                $photo = Photo::create([
                    'user_id' => 1,
                    'trip_id' => $trip->id,
                    'title' => $filename,
                    'caption' => '',
                    'thumb' => $filesystem->disk('s3')->url($path_thumb),
                    'url' => $filesystem->disk('s3')->url($path),
                    'data' => serialize($exif),
                    'status' => 'published'
                ]);
            }
        }

        if ($photo) {
            return $this->respondCreated('Photos successfully uploaded.');
        }

        return $this->respondInternalError('There was a problem uploading new photos.');
    }

    /**
     * update order
     * @param Request $request
     * @return mixed
     */
    public function updateOrder(Request $request)
    {
        $photos = $request->get('photos');

        if (!photos) {
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
            return $this->respondUpdated('Order updated.');
        }

        return $this->respondWithError('There was problem updating trip.');
    }
}
