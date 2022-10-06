<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Threads;
use App\Replies;

class ThreadController extends Controller
{
    public function index($id) {
        $onemsg = Replies::where('thread_id', $id)->where('reply_id', $id)->get();
        $onereply = Replies::orderBy('created_at','ASC')->where('thread_id',$id)->where('reply_id','!=',$id)->get();
        return view('thread', compact('onemsg'), compact('onereply'));
    }

    public function newReply(Request $request, $id) 
    {
        $path = null;
        $replyto = null;
    
        if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) {   
        $filename = $_FILES['upload']['name'];
        $target_dir = "../images/";
        $path = $target_dir . $filename;
        move_uploaded_file($_FILES['upload']['tmp_name'],$path);
        }

        $finalMessage = $request->message;
        $bestid = substr(str_shuffle("0123456789"), 0, 10);

        if (substr_count($request->message,'>>') > 0) {
        $x = 0;

        $pieces = explode("\n", $request->message);

        foreach($pieces as $piece) {
          if(substr_count($piece,'>>')) {
          $array[] = trim(str_replace('>>', '', $piece)); 
          }
        }

        while($x<count($array)) {
        $ting = Replies::where('reply_id',$array[$x])->first('reply_from');
        if (empty($ting)) {
        $array2 = [];
        } else if ($ting == null) {
        Replies::where('reply_id',$array[$x])->update(['reply_from' => ">>".$bestid]); 
        $array2[] = $array[$x];
        } else {
        Replies::where('reply_id',$array[$x])->update(['reply_from' => $ting->reply_from.'|'.">>".$bestid]);  
        $array2[] = $array[$x];
        }
        $x++;
        }

        if (count($array2)>0) {
        $replyto = ">>".implode("|>>", $array2);
        } else {
        $replyto = null;
        }

        $filteredPieces = array_filter($pieces, function($piece) {return !substr_count($piece, '>>');});
        $finalMessage = implode("\n", $filteredPieces);
        }

        $date = date("F j, Y h:i a");
        $image = $path;

        Replies::create([
            'reply_id' => $bestid,
            'reply_to' => $replyto,
            'thread_id' => $id,
            'name' => $request->name ?? 'Anonymous',
            'message' => $finalMessage,
            'image' => $image,
            'date' => $date
        ]); 

        Threads::where('thread_id', $id)->increment('replies');
    
        return redirect()->back();
    }
}

