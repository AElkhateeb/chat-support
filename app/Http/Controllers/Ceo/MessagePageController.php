<?php

namespace App\Http\Controllers\Ceo;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Chat\BulkDestroyChat;
use App\Http\Requests\Admin\Chat\DestroyChat;
use App\Http\Requests\Admin\Chat\IndexChat;
use App\Http\Requests\Admin\Message\IndexMessage;
use App\Http\Requests\Admin\Chat\StoreChat;
use App\Http\Requests\Admin\Chat\UpdateChat;
use App\Http\Requests\Admin\Message\StoreMessage;
use App\Models\Chat;
use App\Models\Message;
use Twilio\Rest\Client;
use App\Models\Customer;
use App\Models\Users\BootAdmin;
use App\Models\Users\SupportAdmin;
use Auth;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessagePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexChat $request
     * @return array|Factory|View
     */
    public function index(IndexChat $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Chat::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'customer_type', 'customer_id', 'sender_type', 'sender_id','body','created_at'],

            // set columns to searchIn
            ['id', 'customer_type', 'sender_type', 'body'],
            function ($query) use ($request) {
                 
                $query->with('messages', function ($q) {
                    $ids=Chat::max('id');
                    if(isset($_GET['chat'])){
                        $q->with('sender')->with('customer')->where('chat_id',$_GET['chat'])->orderBy('id');
                    }else{
                        $q->with('sender')->with('customer')->where('chat_id',$ids)->orderBy('id');
                    }

                })->with('sender')->with('customer')->orderBy('id');
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
       //return ['data' => $data];
       return view('ceo.chat', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('ceo.chat.create');

        return view('ceo.chat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreChat $request
     * @return array|RedirectResponse|Redirector

    public function store(StoreChat $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Chat
        $chat = Chat::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('ceo/chats'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('ceo/chats');
    }
     **/

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMessage $request)
    {
        //return $request;
        // Sanitize input
        $tt=$request->get('body');
         $this->sendWhatsAppMessage($tt,'whatsapp:'.$request->get('to'));
        $sanitized = $request->validated();
        $sanitized['dir']= 1;
        $sanitized['from'] =getenv('TWILIO_WHATSAPP_NUMBER');
        $sanitized['to'] =$request->get('to');
        $sanitized['segments'] =1;
        $sanitized['status'] ='sending';
        $sanitized['media'] ='NO';
        $sanitized['sender_type'] ='App\Models\Users\CeoAdmin';
        $sanitized['sender_id'] = Auth::user()->id;
        $sanitized['chat_id'] =$request->get('chat_id');
        $sanitized['customer_id'] =$request->get('customer_id');
        $sanitized['customer_type'] =$request->get('customer_type');
        $sanitized['body'] =$request->get('body');
        // Store the Message
        $message = Message::create($sanitized);
         Chat::where('id',$request->get('chat_id'))->update(['body'=>$request->get('body')]);
        $data= Message::with('sender')->with('customer')->where('chat_id',$request->get('chat_id'))->get();
        $eventNewMessage=[
            'customer_id' =>$data[0]['customer_id'],
            'customer_type' => $data[0]['customer_type'],
            'customer_name' => ($data[0]['customer_type']=='App\Models\Customer')? $data[0]['customer']['name'] : $data[0]['customer']['full_name'] ,
            'phone' => $data[0]['customer']['phone'] ,
            'body' => $request->get('body'),
            'dir' => 1,
            'sender_id' => Auth::user()->id,
            'sender_type' => 'App\Models\Users\CeoAdmin',
            'sender_name' => Auth::user()->full_name,
            'img' => ($data[0]['customer_type']=='App\Models\Customer')? 'https://ptetutorials.com/images/user-profile.png' : is_null($data[0]['customer']['avatar_thumb_url'])? 'https://ptetutorials.com/images/user-profile.png' : $data[0]['customer']['avatar_thumb_url'],
            'chat_id' =>$request->get('chat_id')
        ];
      //  return $eventNewMessage;
        event(new newMessage($eventNewMessage));
        //return $data;
        return view('messages', ['messages' => $data]);

/*
        if ($request->ajax()) {
            return ['redirect' => url('ceo/messages?chat='.$request->get('chat_id')), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('ceo/messages?chat='.$request->get('chat_id'));*/

    }

    /**
     * Display the specified resource.
     *
     * @param Chat $chat
     * @throws AuthorizationException
     * @return void


    public function show(Chat $chat)
    {
        $this->authorize('ceo.chat.show', $chat);

        // TODO your code goes here
        $data = AdminListing::create(Chat::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'customer_type', 'customer_id', 'sender_type', 'sender_id','body'],

            // set columns to searchIn
            ['id', 'customer_type', 'sender_type', 'body'],
            function ($query) use ($request) {
                $query->with('messages', function ($q) {
                    if(isset($_GET['chat'])){
                        $q->with('sender')->with('customer')->where('chat_id',$_GET['chat']);
                    }else{
                        $q->with('sender')->with('customer')->where('chat_id',1);
                    }

                })->with('sender')->with('customer')->where('chat_id',1);
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
         return ['data' => $data];
        return view('chat', ['data' => $data]);
    }*/
    /**
     * Display a listing of the resource.
     *
     * @param IndexMessage $request
     * @return array|Factory|View
     */
    public function show(IndexMessage $request)
    {
       // return $request;
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Message::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'dir', 'from', 'to', 'segments', 'status', 'media', 'sender_type', 'sender_id', 'customer_type', 'customer_id', 'chat_id','body','created_at'],

            // set columns to searchIn
            ['id', 'from', 'to', 'segments', 'status', 'body', 'media', 'sender_type', 'customer_type'],
            function ($query) use ($request) {
                $query->orderBy('id', 'DESC')->with('sender')->with('customer')->where('chat_id',$request->chat);
            }
        );


        //return ['data' => $data];
        return view('messages', ['messages' => $data->reverse()]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Chat $chat
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Chat $chat)
    {
        $this->authorize('ceo.chat.edit', $chat);
$gotId=BootAdmin::where('pattern','Welcome')->first();
        $chat->update([
            'sender_type'=> 'App\Models\Users\BootAdmin',
            'sender_id'=>$gotId['id'] 
        ]);
        $customer=Customer::where('id',$chat->customer_id)
                                ->update(['opened'=>0]);
         

           return[
            'chat' => $chat,
            'customer' => $customer,

        ]; 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateChat $request
     * @param Chat $chat
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateChat $request, Chat $chat)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Chat
        $chat->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ceo/chats'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('ceo/chats');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyChat $request
     * @param Chat $chat
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyChat $request, Chat $chat)
    {
        $chat->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyChat $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyChat $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Chat::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}
