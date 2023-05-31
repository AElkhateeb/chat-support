<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seo\Pro\BulkDestroyPro;
use App\Http\Requests\Seo\Pro\DestroyPro;
use App\Http\Requests\Seo\Pro\IndexPro;
use App\Http\Requests\Seo\Pro\StorePro;
use App\Http\Requests\Seo\Pro\UpdatePro;
use App\Models\Pro;
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

class ProsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPro $request
     * @return array|Factory|View
     */
    public function index(IndexPro $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Pro::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'icon', 'title', 'text'],

            // set columns to searchIn
            ['id', 'icon', 'title', 'text']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('seo.pro.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('seo.pro.create');

        return view('seo.pro.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePro $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePro $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Pro
        $pro = Pro::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('seo/pros'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('seo/pros');
    }

    /**
     * Display the specified resource.
     *
     * @param Pro $pro
     * @throws AuthorizationException
     * @return void
     */
    public function show(Pro $pro)
    {
        $this->authorize('seo.pro.show', $pro);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Pro $pro
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Pro $pro)
    {
        $this->authorize('seo.pro.edit', $pro);


        return view('seo.pro.edit', [
            'pro' => $pro,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePro $request
     * @param Pro $pro
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePro $request, Pro $pro)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Pro
        $pro->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('seo/pros'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('seo/pros');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPro $request
     * @param Pro $pro
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPro $request, Pro $pro)
    {
        $pro->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPro $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPro $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Pro::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
