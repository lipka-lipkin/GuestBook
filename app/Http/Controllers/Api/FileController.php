<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FileRequest;
use App\Http\Resources\Api\FileResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\File;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param FileRequest $request
     * @return FileResource
     */
    public function store(FileRequest $request)
    {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $name = Str::random();
        $name = $name.'.'.$extension;
        $file = Storage::putFileAs('files', $file, $name);
        $image = File::create([
            'type' => $request->type,
            'path' => $file
        ]);
        return FileResource::make($image);
    }
}
