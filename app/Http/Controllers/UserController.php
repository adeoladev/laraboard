<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Threads;
use App\Models\Board;
use App\Models\Category;
use App\Models\Replies;
use App\Models\Ban;
use App\Models\Archive;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index() {
        if(isset(auth()->user()->username)) {
        return redirect()->route('moderation.threads');
        }
        return view('moderation.index');
    }

    public function threads() {

        $threads = Threads::query();
        $search = request()->input('search');
        $board = request()->input('boards');
        if($search) {
        $threads = $threads->where('message','LIKE','%'.$search.'%');
        }
        if($board) {
        $threads = $threads->where('board',$board);    
        }
        $threads = $threads->orderBy('created_at','DESC')->paginate(20);

        $boards = Board::all();
        return view('moderation.threads',compact('threads','boards'));
    }

    public function boards() {
        $categories = Category::all();
        $boards = Board::query();
        $search = request()->input('search');

        if($search) {
        $boards = $boards->where('name','LIKE','%'.$search.'%');
        }

        $boards = $boards->paginate(20);
        return view('moderation.boards',compact('boards','categories'));
    }

    public function categories() {
        $categories = Category::query();
        $search = request()->input('search');

        if($search) {
        $categories = $categories->where('name','LIKE','%'.$search.'%');
        }

        $categories = $categories->paginate(20);
        return view('moderation.categories',compact('categories'));
    }

    public function users() {
        $users = User::query();
        $search = request()->input('search');

        if($search) {
        $users = $users->where('username','LIKE','%'.$search.'%');
        }

        $users = $users->paginate(20);
        return view('moderation.users',compact('users'));
    }

    public function files() {
        $boards = Board::all();
        $files = Replies::query();
        $board = request()->input('boards');

        if($board) {
        $files = $files->where('board',$board);
        }

        $files = $files->where('file','!=',null)->orderBy('created_at','DESC')->paginate(40);
        return view('moderation.files',compact('files','boards'));
    }

    public function archives() {

        $threads = Threads::query();
        $search = request()->input('search');
        $board = request()->input('boards');
        if($search) {
        $threads = $threads->where('message','LIKE','%'.$search.'%');
        }
        if($board) {
        $threads = $threads->where('board',$board);    
        }
        $threads = $threads->orderBy('created_at','DESC')->where('archived',true)->paginate(20);

        $boards = Board::all();
        return view('moderation.archives',compact('threads','boards'));
    }

    public function pins() {

        $threads = Threads::query();
        $search = request()->input('search');
        $board = request()->input('boards');
        if($search) {
        $threads = $threads->where('message','LIKE','%'.$search.'%');
        }
        if($board) {
        $threads = $threads->where('board',$board);    
        }
        $threads = $threads->orderBy('created_at','DESC')->where('pinned',true)->paginate(20);

        $boards = Board::all();
        return view('moderation.pins',compact('threads','boards'));
    }


    public function login(Request $request) {

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $existingUser = User::where('username', $request->username)->first();
        $validPassword = Hash::check($request->password, $existingUser->password ?? null);

        if(!$existingUser) {
           return redirect()->back()->with('status','Invalid username or password.');
        } else if ($validPassword == false) {
           return redirect()->back()->with('status','Invalid username or password.');
        } else {
           auth()->attempt(array('username' => $request->username, 'password' => $request->password));
           return redirect()->route('moderation.threads');
        }

    }


    /*------------------UPDATE FUNCTIONS-----------------*/
    public function archive(Threads $thread) {
        if($thread->archived == false) {
        $thread->archived = true;
        Archive::create([
            'thread' => $thread->id,
            'deletion_date' => Carbon::now()->addMonth()->toDateTimeString()
        ]);
        } else {
        $thread->archived = false;
        Archive::where('thread',$thread->id)->delete();
        }
        $thread->save();

        return redirect()->back()->with('status','Archive status changed.');
    }

    public function pin(Threads $thread) {
        $thread->pinned = !$thread->pinned;
        $thread->save();
        return redirect()->back()->with('status','Pin status changed');
    }

    public function renameBoard(Request $request) {

        $board = Board::where('id',$request->boards)->first();

        if(!$request->tag) {
        $board->name = $request->name;
        $board->save();
        } else {
        $board->name = $request->name;
        $board->tag = $request->tag;
        $board->save();
        }

        return redirect()->back()->with('status','board renamed.');
    }

    public function renameCategory(Request $request) {

        $category = Category::where('id',$request->categories)->first();

        if(!$request->content) {
        $category->name = $request->name;
        $category->save();
        } else {
        $category->name = $request->name;
        $category->content = $request->content;
        $category->save();
        }

        return redirect()->back()->with('status','Category renamed.');
    }

    public function changePassword(Request $request) {
        User::where('id',auth()->user()->id)->update([
            'password'=> Hash::make($request->password)
        ]);

        return redirect()->back()->with('status','Password changed.');
    }

    public function userInvite(Request $request) {

        $request->validate([
            'email' => 'email:rfc,dns',
            'rank' => 'required'
        ]);

        $randomnum = rand(10,100);
        User::create([
            'username' => $randomnum,
            'email' => $request->email,
            'rank' => $request->rank 
        ]);
        //mail($request->email,"Become a ".config('app.name')." Moderator!", "<a href=".route('moderation.register', $randomnum).">Link</a>");

        return redirect()->back();
    }

    /*public function spoilerFile(Replies $reply, $thread) {
        $reply->thumbnail = 'files/system/spoiler.jpg';
        $thread = Threads::find($thread);

        if ($thread) {
        $thread->thumbnail = 'files/system/spoiler.jpg';
        $thread->save();
        }

        $reply->save();

        return redirect()->back()->with('status','File updated.');
    }*/

    /*---------------DELETE FUNCTIONS-------------------*/
    public function deleteThread(Threads $thread) {
        
        $files = Replies::where('thread_id',$thread->thread_id)->where('file','!=', null)->get();
        
        if($files) {
         foreach($files as $onefile) {
             //unlink($onefile->thumbnail);
             unlink($onefile->file);
         }
        }

        Replies::where('thread_id',$thread->thread_id)->delete();
        $thread->delete();
        return redirect()->back()->with('status','Thread deleted.');
    }

    public function deleteReply(Replies $reply) {
        
        if($reply->file) {
             //unlink($reply->thumbnail);
             unlink($reply->file);
        }

        $reply->delete();
        return redirect()->back()->with('status','Reply deleted.');;
    }

    public function deleteThreadBan(Threads $thread) {
       
        Ban::create([
            'ip_address' => $thread->ip_address
        ]);

        $this->deleteThread($thread);

        return redirect()->back()->with('status','Thread deleted and IP banned.');
    }

    public function deleteReplyBan(Replies $reply) {
       
        Ban::create([
            'ip_address' => $reply->ip_address
        ]);

        $reply->delete();

        return redirect()->back()->with('status','Thread deleted and IP banned.');
    }


    public function deleteBoard(Board $board) {

        $threads = Threads::where('board',$board->tag)->get();

        foreach ($threads as $thread) {
            $thread->delete();
        }

        $board->delete();

        return redirect()->back()->with('status','Board renamed.');
    }

    public function deleteCategory(Category $category) {

        $boards = Board::where('category',$category->id)->get();

        foreach ($boards as $board) {
            $this->deleteBoard($board);
        }

        $category->delete();

        return redirect()->back()->with('status','Category deleted.');
    }

    public function deleteUser(User $user) {
        $user->delete();

        return redirect()->back()->with('status','User deleted.');
    }

    public function deleteFile(Replies $reply, Threads $thread) {
        //unlink($reply->thumbnail);
        unlink($reply->file);

        $reply->thumbnail = 'files/system/deleted.jpg';
        $reply->file = 'files/system/deleted.jpg';

        if ($thread) {
        $thread->thumbnail = 'files/system/deleted.jpg';
        $thread->file = 'files/system/deleted.jpg';
        $thread->save();
        }

        $reply->save();

        return redirect()->back()->with('status','File deleted.');
    }

    public function deleteFileBan(Replies $reply, Threads $thread) {
        $this->deleteFile($reply,$thread);

        Ban::create([
            'ip_address' => $reply->ip_address
        ]);

        return redirect()->back()->with('status','File deleted and IP banned.');
    }

    public function deleteFilePost(Replies $reply, Threads $thread) {
        $this->deleteFile($reply,$thread);

        Replies::find($reply->id)->delete();

        return redirect()->back()->with('status','File and post deleted.');
    }

    /*--------------CREATION FUNCTIONS--------------*/
    public function newBoard(Request $request) {

        $request->validate([
            'tag' => 'max:3'
        ]);

        Board::create([
            'name' => $request->name,
            'tag' => $request->tag,
            'category' => $request->category
        ]);

        return redirect()->back()->with('status','Board added.');
    }

    public function newCategory(Request $request) {

        $request->validate([
            'content' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'content' => $request->content
        ]);

        return redirect()->back()->with('status','Category added.');
    }

   

}
