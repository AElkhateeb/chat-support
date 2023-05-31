<?php

namespace App\Http\Controllers\Seo;

use App\Exports\ApplicationsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seo\Application\BulkDestroyApplication;
use App\Http\Requests\Seo\Application\DestroyApplication;
use App\Http\Requests\Seo\Application\IndexApplication;
use App\Http\Requests\Seo\Application\StoreApplication;
use App\Http\Requests\Seo\Application\UpdateApplication;
use App\Models\Application;
use App\Models\Job;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class ApplicationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexApplication $request
     * @return array|Factory|View
     */
    public function index(IndexApplication $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Application::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'fullname', 'job_id', 'bday', 'male', 'military', 'email', 'phone', 'phone_2', 'city', 'area', 'education', 'experience'],

            // set columns to searchIn
            ['id', 'fullname', 'military', 'email', 'phone', 'phone_2', 'city', 'area', 'education', 'experience'],
            function ($query) use ($request) {
                $query->with(['job']);
                if($request->has('jobs')){
                    $query->whereIn('job_id', $request->get('jobs'));
                }
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return [
                'data' => $data,

            ];
        }

        return view('seo.application.index', [
            'data' => $data,
            'jobs' => Job::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('seo.application.create');

        return view('seo.application.create', [
            'jobs' => job::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreApplication $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreApplication $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['job_id'] = $request->getJobId();
        // Store the Application
        $application = Application::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('seo/applications'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('seo/applications');
    }

    /**
     * Display the specified resource.
     *
     * @param Application $application
     * @throws AuthorizationException
     * @return void
     */
    public function show(Application $application)
    {
        $this->authorize('seo.application.show', $application);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Application $application
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Application $application)
    {
        $this->authorize('seo.application.edit', $application);


        return view('seo.application.edit', [
            'application' => $application,
            'jobs' => job::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateApplication $request
     * @param Application $application
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateApplication $request, Application $application)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['job_id'] = $request->getJobId();
        // Update changed values Application
        $application->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('seo/applications'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('seo/applications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyApplication $request
     * @param Application $application
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyApplication $request, Application $application)
    {
        $application->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyApplication $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyApplication $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Application::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    /**
     * Export entities
     *
     * @return BinaryFileResponse|null
     */
    public function export(): ?BinaryFileResponse
    {
        return Excel::download(app(ApplicationsExport::class), 'applications.xlsx');
    }
}
