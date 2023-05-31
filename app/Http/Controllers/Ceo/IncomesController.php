<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Income\BulkDestroyIncome;
use App\Http\Requests\Admin\Income\DestroyIncome;
use App\Http\Requests\Admin\Income\IndexIncome;
use App\Http\Requests\Admin\Income\StoreIncome;
use App\Http\Requests\Admin\Income\UpdateIncome;
use App\Models\Income;
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

class IncomesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexIncome $request
     * @return array|Factory|View
     */
    public function index(IndexIncome $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Income::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'income', 'pattern_id','replay_id'],

            // set columns to searchIn
            ['id', 'income']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
           // return ['data' => $data];
        return view('ceo.income.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('ceo.income.create');

        return view('ceo.income.create', [
            'patterns' => BootAdmin::all(),
            'replies' => Reply::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIncome $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreIncome $request)
    {
        $sanitized = $request->validated();
        //Add your code for manipulation with request data here
        $sanitized['pattern_id'] = $request->get('pattern')['id'];    
        $sanitized['replay_id'] = $request->get('replay')['id'];
       // $sanitized = $request->getSanitized();

        // Store the Income
        $income = Income::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('ceo/incomes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('ceo/incomes');
    }

    /**
     * Display the specified resource.
     *
     * @param Income $income
     * @throws AuthorizationException
     * @return void
     */
    public function show(Income $income)
    {
        $this->authorize('ceo.income.show', $income);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Income $income
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Income $income)
    {
        $this->authorize('ceo.income.edit', $income);
        
        $income->load('pattern');
        $income->load('replay');
        return view('ceo.income.edit', [
            'income' => $income,
            'patterns' => BootAdmin::all(),
            'replies' => Reply::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIncome $request
     * @param Income $income
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateIncome $request, Income $income)
    {
        // Sanitize input
       $sanitized = $request->validated();
        //Add your code for manipulation with request data here
        $sanitized['pattern_id'] = $request->get('pattern')['id'];        
        $sanitized['replay_id'] = $request->get('replay')['id'];
        // Update changed values Income
        $income->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ceo/incomes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('ceo/incomes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyIncome $request
     * @param Income $income
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyIncome $request, Income $income)
    {
        $income->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyIncome $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyIncome $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Income::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
