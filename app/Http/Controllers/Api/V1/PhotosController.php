<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Filesystem\FilesystemManager as Filesystem;
use App\Photo;

class PhotosController extends ApiController
{

    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->photoTransformer = app(\Transformers\PhotoTransformer::class);
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
        // validate user request
        $user = $this->getRequestingUser($request);
        if(!$user) {
            return $this->respondWithValidationError('Authentication failed validation for a photo.');
        }

        // validate fields
        if (!$request->hasFile('photo')) {
            return $this->respondWithValidationError('Parameters failed validation for a photo.');
        }

        $titles = $request->get('title');
        foreach($request->file('photo') as $key => $photo) {
            $file = $filesystem->disk('s3')->putFile('photos', $photo);
            if($file) {
              $photo = Photo::create([
                  'user_id' => $user->id,
                  'title' => $titles[$key],
                  'path' => $file,
                  'url' => $filesystem->disk('s3')->url($file),
                  'data' => serialize(exif_read_data($photo)),
                  'status' => 'published'
              ]);
            }
        }

        if ($photo) {
            return $this->respondCreated($photo->id, 'Photo successfully created.');
        }

        return $this->respondInternalError('There was a problem creating a new photo.');
    }
}
