<?php
namespace App\Http\Controllers;
use FFMpeg;
use Illuminate\Http\Request;
use App\Models\Threads;
use App\Models\Replies;
use App\Models\Board;
use App\Models\Ban;

class ThreadController extends Controller
{
    public function index($board,$id) {
        $mainmsg = Replies::where('thread_id', $id)->where('reply_id', $id)->first();
        $replies = Replies::orderBy('created_at','ASC')->where('thread_id',$id)->where('reply_id','!=',$id)->get();
        $boards = Board::all();
        $thisBoard = Board::where('tag', $board)->first();
        if ($mainmsg == null || $thisBoard == null) {
        abort(404);
        }
        return view('thread', compact('mainmsg','replies','boards'))->with(['tag'=>$thisBoard->tag,'name'=>$thisBoard->name]);
    }

    public function newReply(Request $request, $id) {

        $ip = $_SERVER['REMOTE_ADDR'];
        $ban = Ban::where('ip_address',$ip)->first();

        if($ban) {
            $date = $ban->expiration_date ?? 'forever';
            return redirect()->back()->with('status',"You're banned until: ".$date);
        }

        $request->validate([
            'name' => 'max:48',
            'message' => 'required',
            'upload' => 'mimes:jpg,jpeg,png,gif,mp4,webm',
            'captcha' => 'required|captcha'
        ]);
    
        $vars = explode(',',$id);
        $id = $vars[0];
        $board = $vars[1];
        
        $finalMessage = $request->message;
        $bestid = substr(str_shuffle("0123456789"), 0, 10);

        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) { 
        $file = $request->file('upload');
        $info = pathinfo($file->getClientOriginalName());
        $extension = $info['extension'];
        $type = substr($_FILES['upload']['type'], 0, strpos($_FILES['upload']['type'], "/"));
        $filepath = "files/$bestid.$extension";
        $thumbnail = "files/thumbnails/$bestid.jpg";
        $file->storeAs('files/',$bestid.'.'.$extension);
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
        if ($query->reply_from) {
        $jj = json_decode($query->reply_from);
        array_push($jj, $bestid);
        $query->reply_from = json_encode($jj);
        $query->save();
        } else {
        $jj = [$bestid];
        $query->reply_from = json_encode($jj);
        $query->save();
        }
        }

        $filteredPieces = array_filter($pieces, function($piece) {return !substr_count($piece, '>>');});
        $finalMessage = implode("\n", $filteredPieces);
        }

        Threads::where('thread_id', $id)->increment('replies');

        if (isset($file) && str_contains($request->file('upload')->getMimeType(), 'video')) {
        FFMpeg::open($filepath)->exportFramesByAmount(1)->addFilter('-vf','scale=iw*.5:ih*.5')->save($thumbnail);
        } else if (isset($file) && str_contains($request->file('upload')->getMimeType(), 'image')) {
        FFMpeg::open($filepath)->addFilter('-vf','scale=iw*.5:ih*.5')->export()->save($thumbnail);  
        }
        
        if (isset($request->linkupload) && filter_var($request->linkupload, FILTER_VALIDATE_URL)) {
        FFMpeg::openUrl($request->linkupload)->export()->save("files/$bestid.jpg");
        FFMpeg::open("files/$bestid.jpg")->addFilter('-vf','scale=iw*.5:ih*.5')->export()->save("files/thumbnails/$bestid.jpg"); 
        $filepath = "files/$bestid.jpg";
        $thumbnail = "files/thumbnails/$bestid.jpg";
        Threads::where('thread_id', $id)->increment('files');
        }

        if ($request->spoiler) {
            $thumbnail = 'files/system/spoiler.jpg';
        }

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => $replyto ?? null,
            'thread_id' => $id,
            'name' => $request->name ?? 'Anonymous',
            'message' => $finalMessage,
            'thumbnail' => $thumbnail ?? null,
            'file' => $filepath ?? null,
            'file_type' => $type ?? null,
            'ip_address' => $ip,
            'board' => $board
        ]); 
    
        return redirect()->back()->with('status','Reply posted');
    }

    public function getCaptcha() {
        return response()->json(['captcha'=> captcha_img('flat')]);
    }

}

