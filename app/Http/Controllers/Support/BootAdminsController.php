<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BootAdmin\BulkDestroyBootAdmin;
use App\Http\Requests\Admin\BootAdmin\DestroyBootAdmin;
use App\Http\Requests\Admin\BootAdmin\IndexBootAdmin;
use App\Http\Requests\Admin\BootAdmin\StoreBootAdmin;
use App\Http\Requests\Admin\BootAdmin\UpdateBootAdmin;
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

class BootAdminsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBootAdmin $request
     * @return array|Factory|View
     */
    public function index(IndexBootAdmin $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(BootAdmin::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'pattern', 'stuff', 'previous', 'checked'],

            // set columns to searchIn
            ['id', 'pattern', 'stuff']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('support.boot-admin.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('support.boot-admin.create');

        return view('support.boot-admin.create', [
            'patterns' => BootAdmin::where('stuff', '!=' ,'Identify')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBootAdmin $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBootAdmin $request)
    {
        // Sanitize input
        $sanitized = $request->validated();
        //Add your code for manipulation with request data here
        $sanitized['previous'] = $request->get('pattern')['id'];
        // Store the BootAdmin
        $bootAdmin = BootAdmin::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/boot-admins'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/boot-admins');
    }

    /**
     * Display the specified resource.
     *
     * @param BootAdmin $bootAdmin
     * @throws AuthorizationException
     * @return void
     */
    public function show(BootAdmin $bootAdmin)
    {
        $this->authorize('support.boot-admin.show', $bootAdmin);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BootAdmin $bootAdmin
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BootAdmin $bootAdmin)
    {
        $this->authorize('support.boot-admin.edit', $bootAdmin);

        $bootAdmin->load('previous');
        return view('support.boot-admin.edit', [
            'bootAdmin' => $bootAdmin,
            'patterns' => BootAdmin::where('stuff', '!=' ,'Identify')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBootAdmin $request
     * @param BootAdmin $bootAdmin
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBootAdmin $request, BootAdmin $bootAdmin)
    {
        // Sanitize input
        $sanitized = $request->validated();
        //Add your code for manipulation with request data here
        $sanitized['previous'] = $request->get('previous')['id'];
        // Update changed values BootAdmin
        $bootAdmin->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('support/boot-admins'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('support/boot-admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBootAdmin $request
     * @param BootAdmin $bootAdmin
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBootAdmin $request, BootAdmin $bootAdmin)
    {
        $bootAdmin->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBootAdmin $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBootAdmin $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    BootAdmin::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
