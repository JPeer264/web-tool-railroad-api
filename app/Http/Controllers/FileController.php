<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

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

        $file   = $request->file('fileUpload');
        $params = $request->all();
        $ext    = $file->getClientOriginalExtension();
        // replace all whitespaces with underlines
        $fileName = preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $name     = isset($params[$param_alt]) ? preg_replace('/\s+/', '_', $params[$param_alt]) : preg_replace('/.' . $ext . '$/', '', $fileName);
        $newName  = $folderName .'picture_' . $name;

        $path          = '/' . $this->dir_uploads . '/' . $folderName . '/' . $id;
        $fullpath      = base_path() . $path;
        $original_name = $newName . '.' . $ext;

        $file->move($fullpath, $original_name);

        // save small
        Image::make($fullpath . '/' . $original_name ,array(
            'width' => $this->size_small
        ))->save($fullpath . '/' . $newName . '-'. $this->text_small .'.' . $ext);

        // save medium
        Image::make($fullpath . '/' . $original_name ,array(
            'width' => $this->size_medium
        ))->save($fullpath . '/' . $newName . '-'. $this->text_medium .'.' . $ext);

        // save large
        Image::make($fullpath . '/' . $original_name ,array(
            'width' => $this->size_large
        ))->save($fullpath . '/' . $newName . '-'. $this->text_large .'.' . $ext);

        return ([
            'filename' => $original_name,
            'path' => $path,
            'fullpath' => $fullpath,
            'filepath' => $path . '/' . $original_name
        ]);
    }
}
