<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;
use App\File as Upload;


class FileController extends Controller
{
    public function __construct(Request $request) {
        $this->size_small   = env('FILE_SIZE_SMALL');
        $this->size_medium  = env('FILE_SIZE_MEDIUM');
        $this->size_large   = env('FILE_SIZE_LARGE');
        $this->text_small   = env('FILE_TEXT_SMALL');
        $this->text_medium  = env('FILE_TEXT_MEDIUM');
        $this->text_large   = env('FILE_TEXT_LARGE');
        $this->text_original = env('FILE_TEXT_ORIGINAL');
        $this->dir_uploads  = env('FILE_DIR_UPLOADS');

        $this->request = $request;
    }

    public function save($folderName, $param_alt, $id) {
        $request = $this->request;

        // return if there is no file set
        if (!$request->hasFile('fileUpload')) {
            return;
        }

        $basepath = base_path();
        $storagepath  = storage_path('files');
        $folderpath = str_replace($basepath, "", $storagepath);
        $file   = $request->file('fileUpload');
        $params = $request->all();
        $ext    = $file->getClientOriginalExtension();
        // replace all whitespaces with underlines
        $fileName = preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $name     = isset($params[$param_alt]) ? preg_replace('/\s+/', '_', $params[$param_alt]) : preg_replace('/.' . $ext . '$/', '', $fileName);
        $newName  = $folderName .'picture_' . $name;

        $path          = '/' . $folderName . '/' . $id;
        $fullpath      = storage_path('files') . $path;
        $original_name = $newName . '.' . $ext;
        //$file->move($fullpath, $original_name);
        Storage::put($path . '/' . $original_name,  File::get($file));


        // save small
        $filesmall = Image::make($fullpath . '/' . $original_name ,array(
            'width' => $this->size_small
        ));
        Storage::put($folderName . '/' . $id . '/' . $newName . '-'. $this->text_small .'.' . $ext,  $filesmall);

        // save medium
        $filemedium = Image::make($fullpath . '/' . $original_name ,array(
            'width' => $this->size_medium
        ));
        Storage::put($folderName . '/' . $id . '/' . $newName . '-'. $this->text_medium .'.' . $ext,  $filemedium);

        // save large
        $filelarge = Image::make($fullpath . '/' . $original_name ,array(
            'width' => $this->size_large
        ));
        Storage::put($folderName . '/' . $id . '/' . $newName . '-'. $this->text_large .'.' . $ext,  $filelarge);

        return ([
            'filename' => $original_name,
            'path' => $path,
            'fullpath' => $fullpath,
            'filepath' => $folderpath . $path . '/' . $original_name
        ]);
    }

     public function saveFile($params, $filetosave)
    {
        $request = $this->request;
        // return if there is no file set

        //max 8MB
        $file = $request->file('file');
        //$params = $request->all();

        $basepath = base_path();
        $storagepath  = storage_path('files');
        $folderpath = str_replace($basepath, "", $storagepath);
        $filename = preg_replace('/\s+/', '_', $filetosave->getClientOriginalName());
        $path = $params['topic_id'].'/'.$filename;

        var_dump($storagepath, $folderpath);
        if(Storage::has($path)){
            return response()->json([
                    'message' => 'filename already exist in this topic'
                ], 409);
        }

        $fullpath = $storagepath . $path ;
        $filepath = str_replace('\\', '/',$folderpath . $path );


        Storage::put($path,  File::get($filetosave));
        $contentType = mime_content_type($fullpath);

        //check if file is an image
        $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
        if(! in_array($contentType, $allowedMimeTypes) ){
          $image = 0;
        }else{
            $image = 1;
        }

        $params['filename'] = $filename;
        $params['path'] = $path;
        $params['fullpath'] = $fullpath;
        $params['filepath'] = $filepath;
        $params['isimage'] = $image;

        $file = Upload::create($params);

        return response()->json([
                'message' => 'File successfully created',
                'comment_id' => $file->id
            ], 201);

    }

    public function deleteFile()
    {
        $request = $this->request;
        $params = $request->all();

        if(!Storage::has($params['path'])){
            return response()->json([
                    'message' => 'file not found'
                ], 404);
        }

        Storage::delete($params['path']);

        return response()->json('success');
    }
}
