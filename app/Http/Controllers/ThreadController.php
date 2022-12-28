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

    public function newReply(Request $request, $id) {

        $request->validate([
            'name' => 'max:48',
            'message' => 'required',
            'upload' => 'mimes:jpg,jpeg,png,gif,mp4,webm'
        ]);
    
        $board = $request->board;
        $finalMessage = $request->message;
        $ip = $_SERVER['REMOTE_ADDR'];
        $bestid = substr(str_shuffle("0123456789"), 0, 10);

        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) { 
        $file = $request->file('upload');
        $info = pathinfo($file->getClientOriginalName());
        $extension = $info['extension'];
        $filepath = "files/$bestid.$extension";
        $thumbnail = "files/thumbnails/$bestid.jpg";
        $file->move('files/',$bestid.'.'.$extension);
        Threads::where('thread_id', $id)->increment('files'); 
        }

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

        Threads::where('thread_id', $id)->increment('replies');

        if (isset($file)) {
        FFMpeg::open($filepath)->addFilter('-vf','scale=iw*.5:ih*.5')->export()->save($thumbnail);  
        } else if (isset($request->linkupload) && filter_var($request->linkupload, FILTER_VALIDATE_URL)) {
        FFMpeg::openUrl($request->linkupload)->export()->save("files/$bestid.jpg");
        FFMpeg::open("files/$bestid.jpg")->addFilter('-vf','scale=iw*.5:ih*.5')->export()->save("files/thumbnails/$bestid.jpg"); 
        $filepath = "files/$bestid.jpg";
        $thumbnail = "files/thumbnails/$bestid.jpg";
        Threads::where('thread_id', $id)->increment('files');
        }

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => $replyto ?? null,
            'thread_id' => $id,
            'name' => $request->name ?? 'Anonymous',
            'message' => $finalMessage,
            'thumbnail' => $thumbnail ?? null,
            'file' => $filepath ?? null,
            'ip_address' => $ip,
            'board' => $board
        ]); 
    
        return redirect()->back();
    }
}

