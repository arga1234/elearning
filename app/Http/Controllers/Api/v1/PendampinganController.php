<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\Comment;
use App\Users;
use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


  class PendampinganController extends Controller
  {

     public function index()
    {
        // All threads, ignore deleted/archived participants
        $threads = Thread::getAllLatest()->get();
        // All threads that user is participating in
        // $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();
        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();
        return response()->json([
          'message' => 'success!',
          'data'  => $threads
        ], 200); }

      public function test(Request $request)
      {
        return response()->json([
          'message' => 'success!',
          'data'  => $post
        ], 200);
      }
      public function store()
      {
          $input = Input::all();
          $thread = Thread::create([
              'subject' => $input['subject'],
          ]);
          // Message
          $message = Message::create([
              'thread_id' => $thread->id,
              'user_id' => Auth::id(),
              'body' => $input['message'],
          ]);
          // Sender
          $participant = Participant::create([
              'thread_id' => $thread->id,
              'user_id' => Auth::id(),
              'last_read' => new Carbon,
          ]);
          // Recipients
          if (Input::has('recipients')) {
              $thread->addParticipant($input['recipients']);
          }
          return response()->json([
            'message' => 'success!',
            'thread'  => $thread,
            'messages' => $message,
            'particapants' => $participant

          ], 200);
      }
   
    
  }

   

