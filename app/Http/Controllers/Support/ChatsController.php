<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Chat\BulkDestroyChat;
use App\Http\Requests\Admin\Chat\DestroyChat;
use App\Http\Requests\Admin\Chat\IndexChat;
use App\Http\Requests\Admin\Chat\StoreChat;
use App\Http\Requests\Admin\Chat\UpdateChat;
use App\Models\Chat;
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

class ChatsController extends Controller
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
            ['id', 'customer_type', 'customer_id', 'sender_type', 'sender_id'],

            // set columns to searchIn
            ['id', 'customer_type', 'sender_type', 'body']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('support.chat.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('support.chat.create');

        return view('support.chat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreChat $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreChat $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Chat
        $chat = Chat::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('support/chats'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('support/chats');
    }

    /**
     * Display the specified resource.
     *
     * @param Chat $chat
     * @throws AuthorizationException
     * @return void
     */
    public function show(Chat $chat)
    {
        $this->authorize('support.chat.show', $chat);

        // TODO your code goes here
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
        $this->authorize('support.chat.edit', $chat);


        return view('support.chat.edit', [
            'chat' => $chat,
        ]);
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
                'redirect' => url('support/chats'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('support/chats');
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
}
