<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Threads;
use App\Replies;
use Carbon\Carbon;

class BoardController extends Controller {

public $thread;

    public function index() {
        $messages = Threads::orderBy('date', 'DESC')->take(16)->get();
        return view('index', compact('messages'));
    }


    public function newThread(Request $request) {
        
        $request->validate([
            "message" => "required"
        ]);
    
        $path = NULL;

        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) {   
        $filename = $_FILES['upload']['name'];
        $target_dir = "../images/";
        $path = $target_dir . $filename;
        move_uploaded_file($_FILES['upload']['tmp_name'],$path);
        }

        $date = date("F j, Y h:i a");
        $bestid = substr(str_shuffle("0123456789"), 0, 10);
        $image = $path;
        
        Threads::create([
            'thread_id' => $bestid,
            'name' => $request->name ?? 'Anonymous',
            'message' => $request->message,
            'image' => $image,
            'date' => $date
        ]);

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => null,
            'thread_id' => $bestid,
            'name' => $request->name ?? 'Anonymous',
            'message' => $request->message,
            'image' => $image,
            'date' => $date
        ]); 
        
        return redirect()->back();
        
    }

}