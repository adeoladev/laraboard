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
           return redirect()->back()->with('status','Invalid Username or Password');
        } else if ($validPassword == false) {
           return redirect()->back()->with('status','Invalid Username or Password');
        } else {
           auth()->attempt(array('username' => $request->username, 'password' => $request->password));
           return redirect()->route('moderation.threads');
        }

    }


    /*------------------UPDATE FUNCTIONS-----------------*/
    public function archive(Threads $thread) {
        $thread->archived = !$thread->archived;
        $thread->updated_at = $thread->updated_at;
        $thread->save();
        return redirect()->back()->with('status','Updated thread id:'.$thread->thread_id);
    }

    public function pin(Threads $thread) {
        $thread->pinned = !$thread->pinned;
        $thread->save();
        return redirect()->back()->with('status','Updated thread id:'.$thread->thread_id);
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

        return redirect()->back()->with('status','Board Renamed');
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

        return redirect()->back()->with('status','Category Renamed');
    }

    public function changePassword(Request $request) {
        User::where('id',auth()->user()->id)->update([
            'password'=> Hash::make($request->password)
        ]);

        return redirect()->back()->with('status','Password Changed');
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

    public function spoilerFile(Replies $reply, $thread) {
        $reply->thumbnail = 'files/system/spoiler.jpg';
        $thread = Threads::find($thread);

        if ($thread) {
        $thread->thumbnail = 'files/system/spoiler.jpg';
        $thread->save();
        }

        $reply->save();

        return redirect()->back()->with('status','File Updated');
    }

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
        return redirect()->back();
    }

    public function deleteReply(Replies $reply) {
        
        if($reply->file) {
             //unlink($reply->thumbnail);
             unlink($reply->file);
        }

        $reply->delete();
        return redirect()->back();
    }

    public function deleteThreadBan(Threads $thread) {
       
        Ban::create([
            'ip_address' => $thread->ip_address
        ]);

        $this->deleteThread($thread);

        return redirect()->back()->with('status','Thread Deleted and IP Banned');
    }

    public function deleteReplyBan(Replies $reply) {
       
        Ban::create([
            'ip_address' => $reply->ip_address
        ]);

        $reply->delete();

        return redirect()->back()->with('status','Thread Deleted and IP Banned');
    }


    public function deleteBoard(Board $board) {

        $threads = Threads::where('board',$board->tag)->get();

        foreach ($threads as $thread) {
            $thread->delete();
        }

        $board->delete();

        return redirect()->back()->with('status','Board Renamed');
    }

    public function deleteCategory(Category $category) {

        $boards = Board::where('category',$category->id)->get();

        foreach ($boards as $board) {
            $this->deleteBoard($board);
        }

        $category->delete();

        return redirect()->back()->with('status','Category Deleted');
    }

    public function deleteUser(User $user) {
        $user->delete();

        return redirect()->back()->with('status','User Deleted');
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

        return redirect()->back()->with('status','File Deleted');
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

        return redirect()->back()->with('status','Board Added');
    }

    public function newCategory(Request $request) {

        $request->validate([
            'content' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'content' => $request->content
        ]);

        return redirect()->back()->with('status','Category Added');
    }

   

}
