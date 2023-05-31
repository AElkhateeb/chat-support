<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reply\BulkDestroyReply;
use App\Http\Requests\Admin\Reply\DestroyReply;
use App\Http\Requests\Admin\Reply\IndexReply;
use App\Http\Requests\Admin\Reply\StoreReply;
use App\Http\Requests\Admin\Reply\UpdateReply;
use App\Models\Reply;
use App\Models\Users\BootAdmin;
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

class RepliesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexReply $request
     * @return array|Factory|View
     */
    public function index(IndexReply $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Reply::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'replay', 'pattern_id'],

            // set columns to searchIn
            ['id', 'replay'],
            function ($query) use ($request) {
                $query->with(['pattern']);
                if($request->has('patterns')){
                    $query->whereIn('pattern_id', $request->get('patterns'));
                }
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

        return view('ceo.reply.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('ceo.reply.create');

        return view('ceo.reply.create', [
            'patterns' => BootAdmin::where('stuff' ,'!=','Identify',)->where('stuff' ,'!=','welcome',)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReply $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReply $request)
    {
        
        // Sanitize input
        $sanitized = $request->validated();
        //Add your code for manipulation with request data here
        $sanitized['pattern_id'] = $request->get('pattern')['id'];
        //$sanitized['pattern'] = $request->getPatternId();
        //$sanitized = $request->getSanitized();

        // Store the Reply
        $reply = Reply::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('ceo/replies'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('ceo/replies');
    }

    /**
     * Display the specified resource.
     *
     * @param Reply $reply
     * @throws AuthorizationException
     * @return void
     */
    public function show(Reply $reply)
    {
        $this->authorize('ceo.reply.show', $reply);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reply $reply
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Reply $reply)
    {
        $this->authorize('ceo.reply.edit', $reply);

        $reply->load('pattern');
       
        return view('ceo.reply.edit', [
            'reply' => $reply,
            'patterns' => ($reply['pattern']['stuff']=='Identify'||$reply['pattern']['stuff']=='welcome' )?BootAdmin::all() :BootAdmin::where('stuff' ,'!=','Identify',)->where('stuff' ,'!=','welcome',)->get() ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReply $request
     * @param Reply $reply
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReply $request, Reply $reply)
    {
         // Sanitize input
         $sanitized = $request->validated();
        //Add your code for manipulation with request data here
        $sanitized['pattern_id'] = $request->get('pattern')['id'];
       // $sanitized = $request->getSanitized();
        // Update changed values Reply
        $reply->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ceo/replies'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('ceo/replies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReply $request
     * @param Reply $reply
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReply $request, Reply $reply)
    {
        $reply->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyReply $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReply $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Reply::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
