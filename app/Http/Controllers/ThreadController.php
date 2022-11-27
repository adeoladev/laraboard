<?php
namespace App\Http\Controllers;
use FFMpeg;
use Illuminate\Http\Request;
use App\Models\Threads;
use App\Models\Replies;
use App\Models\Board;

class ThreadController extends Controller
{
    public function index($board,$id) {
        $mainmsg = Replies::where('thread_id', $id)->where('reply_id', $id)->first();
        $replies = Replies::orderBy('created_at','ASC')->where('thread_id',$id)->where('reply_id','!=',$id)->get();
        $thisBoard = Board::where('tag', $board)->first();
        if ($mainmsg == null || $thisBoard == null) {
        abort(404);
        }
        return view('thread', compact('mainmsg'), compact('replies'))->with(['tag'=>$thisBoard->tag,'name'=>$thisBoard->name]);
    }

    public function newReply(Request $request, $id) 
    {
    
        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) { 
        $file = $request->file('upload');
        $info = pathinfo($file->getClientOriginalName());
        $filename = str_replace(str_split("\\/*{}[].' "), '_', $info['filename']);
        $extension = $info['extension'];
        $filepath = "files/$filename.$extension";
        $thumbnail = "files/thumbnails/$filename.jpg";
        $file->move('files/',$filename.'.'.$extension);
        }

        $finalMessage = $request->message;
        $bestid = substr(str_shuffle("0123456789"), 0, 10);

        if (substr_count($request->message,'>>') > 0) {

        $pieces = explode("\n", $request->message);

        foreach($pieces as $piece) {
          if(substr_count($piece,'>>')) {
          $array1[] = trim(str_replace('>>', '', $piece)); 
          }
        }

        $replyto = json_encode($array1);

        foreach($array1 as $reply) {
        $query = Replies::where('reply_id',$reply)->first();
        if ($query) {
        $array[] = $bestid;
        $query->reply_from = json_encode($array);
        $query->save();
        }
        }

        $filteredPieces = array_filter($pieces, function($piece) {return !substr_count($piece, '>>');});
        $finalMessage = implode("\n", $filteredPieces);
        }

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => $replyto ?? null,
            'thread_id' => $id,
            'name' => $request->name ?? 'Anonymous',
            'message' => $finalMessage,
            'thumbnail' => $thumbnail ?? null,
            'file' => $filepath ?? null,
        ]); 

        Threads::where('thread_id', $id)->increment('replies');
        if ($filepath) {
        Threads::where('thread_id', $id)->increment('images');   
        }
    
        return redirect()->back();
    }
}

