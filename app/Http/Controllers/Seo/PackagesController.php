<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Package\BulkDestroyPackage;
use App\Http\Requests\Admin\Package\DestroyPackage;
use App\Http\Requests\Admin\Package\IndexPackage;
use App\Http\Requests\Admin\Package\StorePackage;
use App\Http\Requests\Admin\Package\UpdatePackage;
use App\Models\Package;
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

class PackagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPackage $request
     * @return array|Factory|View
     */
    public function index(IndexPackage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Package::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'weight', 'number', 'is_published'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.package.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.package.create');

        return view('admin.package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePackage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePackage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Package
        $package = Package::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/packages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/packages');
    }

    /**
     * Display the specified resource.
     *
     * @param Package $package
     * @throws AuthorizationException
     * @return void
     */
    public function show(Package $package)
    {
        $this->authorize('admin.package.show', $package);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Package $package
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Package $package)
    {
        $this->authorize('admin.package.edit', $package);


        return view('admin.package.edit', [
            'package' => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePackage $request
     * @param Package $package
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePackage $request, Package $package)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Package
        $package->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/packages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/packages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPackage $request
     * @param Package $package
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPackage $request, Package $package)
    {
        $package->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPackage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPackage $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Package::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
