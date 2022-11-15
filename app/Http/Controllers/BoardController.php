<?php
namespace App\Http\Controllers;
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
        return view('index', compact('categories'));
    }

    public function board($board) {
        $threads = Threads::orderBy('created_at', 'DESC')->where('board', $board)->get();
        $thisBoard = Board::where('tag', $board)->first();
        return view('board', compact('threads'))->with(['tag'=>$thisBoard->tag,'name'=>$thisBoard->name]);
    }


    public function newThread(Request $request, $tag) {
        
        $request->validate([
            'title' => 'max:48',
            'message' => 'required',
            'upload' => 'required|mimes:jpg,jpeg,gif'
        ]);
    
        $path = NULL;

        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) {   
        $filename = $_FILES['upload']['name'];
        $target_dir = "images/";
        $path = $target_dir . str_replace(' ', '_', $filename);
        move_uploaded_file($_FILES['upload']['tmp_name'],$path);
        }

        $bestid = substr(str_shuffle("0123456789"), 0, 10);
        $image = $path;
        
        Threads::create([
            'thread_id' => $bestid,
            'name' => $request->name ?? 'Anonymous',
            'title' => $request->title,
            'message' => $request->message,
            'image' => $image,
            'board' => $tag
        ]);

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => null,
            'thread_id' => $bestid,
            'name' => $request->name ?? 'Anonymous',
            'message' => $request->message,
            'image' => $image,
        ]); 
        
        return redirect()->back();
        
    }

}