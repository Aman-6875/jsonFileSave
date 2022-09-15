<?php

namespace App\Http\Controllers;

use App\Models\JsonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class JsonFileController extends Controller
{
    public function index()
    {
        return view('view');
    }
    public function getFile(Request $request)
    {

        $uploadedFile = $request->file('file');
        $filename = time() . $uploadedFile->getClientOriginalName();

        $path =  Storage::disk('local')->putFileAs(
            'files/' . $filename,
            $uploadedFile,
            $filename
        );

        $string = file_get_contents(Storage::path($path));
        $json = json_decode($string, true);

        foreach ($json['comments'] as $item) {

            $data = [
                'jsonId' => $item['id'],
                'user_id' => $item['user']['id'],
                'user_name' => $item['user']['username'],
                'post_id' => $item['postId'],
                'body' => $item['body'],
            ];

            JsonData::updateOrCreate(['jsonId' => $item['id']], $data);
        }

        // $jsonData = JsonData::insert($data);

        return response()->json(['success' => 'Data Added successfully.']);
    }
}
