<?php
namespace App\Http\Controllers;
use FFMpeg;
use Illuminate\Http\Request;
use App\Models\Threads;
use App\Models\Replies;
use App\Models\Category;
use App\Models\Board;
use Carbon\Carbon;

class BoardController extends Controller {

public $thread;

    public function index() {
        $categories = Category::all();
        $popularThreads = Threads::orderBy('replies','DESC')->get()->take(6);
        return view('index', compact('categories','popularThreads'));
    }

    public function board($board) {
        $threads = Threads::orderBy('updated_at', 'DESC')->where('board', $board)->get();
        $thisBoard = Board::where('tag', $board)->first();
        if ($thisBoard == null) {
        abort(404);
        }
        return view('board', compact('threads','thisBoard'));
    }


    public function newThread(Request $request, $tag) {

        $request->validate([
            'title' => 'max:48',
            'name' => 'max:48',
            'message' => 'required',
            'linkupload' => 'string',
            'upload' => 'mimes:jpg,jpeg,png,gif,mp4,webm'
        ]);

        $bestid = substr(str_shuffle("0123456789"), 0, 10);
        $file = $request->file('upload');
        if ($file) {
            $info = pathinfo($file->getClientOriginalName());
        } else {
            $info = ['filename'=> $bestid,'extension'=>'jpg'];
        }
        $filename = str_replace(str_split("\\/*{}[].' "), '_', $info['filename']);
        $extension = $info['extension'];
        $filepath = "files/$filename.$extension";
        $thumbnail = "files/thumbnails/$filename.jpg";

        if (isset($request->linkupload)) {
            FFMpeg::openUrl($request->linkupload)->export()->save("files/$bestid.jpg");
            FFMpeg::open("files/$bestid.jpg")->addFilter('-vf','scale=iw*.5:ih*.5')->export()->save("files/thumbnails/$bestid.jpg");
        }

        if ($file && str_contains($request->file('upload')->getMimeType(), 'video')) {
            $file->move('files/',$filename.'.'.$extension);
            FFMpeg::open($filepath)->exportFramesByAmount(1)->addFilter('-vf','scale=iw*.5:ih*.5')->save($thumbnail);
        } else if ($file && str_contains($request->file('upload')->getMimeType(), 'image')) {
            $file->move('files/',$filename.'.'.$extension);
            FFMpeg::open($filepath)->addFilter('-vf','scale=iw*.5:ih*.5')->export()->save($thumbnail);
        }

        Threads::create([
            'thread_id' => $bestid,
            'name' => $request->name ?? 'Anonymous',
            'title' => $request->title,
            'message' => $request->message,
            'thumbnail' => $thumbnail,
            'file' => $filepath,
            'board' => $tag
        ]);

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => null,
            'thread_id' => $bestid,
            'name' => $request->name ?? 'Anonymous',
            'message' => $request->message,
            'thumbnail' => $thumbnail,
            'file' => $filepath
        ]); 

        return redirect()->back();
        
    }

}