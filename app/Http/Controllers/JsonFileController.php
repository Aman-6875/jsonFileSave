<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class JsonFileController extends Controller
{
    public function getFile(Request $request)
    {
        // $file = request()->file;      // <input type="file" name="fileinput" />
        // $content = file_get_contents($file);
        // $json = json_decode($content, true);
        // return $json;
        // $request->file('file')->move(public_path(), 'fortinet_logs.json');
        // $string = file_get_contents(public_path() . '/fortinet_logs.json');
        // $json = json_decode($string, true);
        // return $json;
        $uploadedFile = $request->file('file');
        $filename = time() . $uploadedFile->getClientOriginalName();

        $path =  Storage::disk('local')->putFileAs(
            'files/' . $filename,
            $uploadedFile,
            $filename
        );
        // dd(Storage::path($path));
        $string = file_get_contents(Storage::path($path));
        $json = json_decode($string, true);

        foreach ($json['comments'] as $item) {
            dump($item);
        }
        return 11;

        // $upload = new Upload;
        // $upload->filename = $filename;

        // $upload->user()->associate(auth()->user());

        // $upload->save();
        return $path;
    }
}
