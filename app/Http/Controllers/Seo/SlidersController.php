<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seo\Slider\BulkDestroySlider;
use App\Http\Requests\Seo\Slider\DestroySlider;
use App\Http\Requests\Seo\Slider\IndexSlider;
use App\Http\Requests\Seo\Slider\StoreSlider;
use App\Http\Requests\Seo\Slider\UpdateSlider;
use App\Models\Slider;
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

class SlidersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSlider $request
     * @return array|Factory|View
     */
    public function index(IndexSlider $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Slider::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'sub_title', 'text'],

            // set columns to searchIn
            ['id', 'title', 'sub_title', 'text']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('seo.slider.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('seo.slider.create');

        return view('seo.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSlider $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSlider $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Slider
        $slider = Slider::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('seo/sliders'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('seo/sliders');
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @throws AuthorizationException
     * @return void
     */
    public function show(Slider $slider)
    {
        $this->authorize('seo.slider.show', $slider);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Slider $slider
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Slider $slider)
    {
        $this->authorize('seo.slider.edit', $slider);


        return view('seo.slider.edit', [
            'slider' => $slider,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSlider $request
     * @param Slider $slider
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSlider $request, Slider $slider)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Slider
        $slider->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('seo/sliders'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('seo/sliders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySlider $request
     * @param Slider $slider
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySlider $request, Slider $slider)
    {
        $slider->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySlider $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySlider $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Slider::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
