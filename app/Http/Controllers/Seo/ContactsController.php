<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seo\Contact\BulkDestroyContact;
use App\Http\Requests\Seo\Contact\DestroyContact;
use App\Http\Requests\Seo\Contact\IndexContact;
use App\Http\Requests\Seo\Contact\StoreContact;
use App\Http\Requests\Seo\Contact\UpdateContact;
use App\Models\Contact;
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

class ContactsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexContact $request
     * @return array|Factory|View
     */
    public function index(IndexContact $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Contact::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'icon', 'title', 'text', 'is_published', 'branch_id'],

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

        return view('seo.contact.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('seo.contact.create');

        return view('seo.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContact $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreContact $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Contact
        $contact = Contact::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('seo/contacts'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('seo/contacts');
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @throws AuthorizationException
     * @return void
     */
    public function show(Contact $contact)
    {
        $this->authorize('seo.contact.show', $contact);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contact $contact
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Contact $contact)
    {
        $this->authorize('seo.contact.edit', $contact);


        return view('seo.contact.edit', [
            'contact' => $contact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContact $request
     * @param Contact $contact
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateContact $request, Contact $contact)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Contact
        $contact->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('seo/contacts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('seo/contacts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyContact $request
     * @param Contact $contact
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyContact $request, Contact $contact)
    {
        $contact->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyContact $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyContact $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Contact::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
