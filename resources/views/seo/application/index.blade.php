@extends('seo.layout.default')

@section('title', trans('admin.application.actions.index'))

@section('body')
    <application-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('seo/applications') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.application.actions.index') }}
                        <a class="btn btn-primary btn-sm pull-right m-b-0 ml-2" href="{{ url('seo/applications/export') }}" role="button"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.application.actions.export') }}</a>
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('seo/applications/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.application.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.application.columns.id') }}</th>
                                        <th is='sortable' :column="'fullname'">{{ trans('admin.application.columns.fullname') }}</th>
                                        <th is='sortable' :column="'job_id'">{{ trans('admin.application.columns.job_id') }}</th>
                                        <th is='sortable' :column="'bday'">{{ trans('admin.application.columns.bday') }}</th>
                                        <th is='sortable' :column="'male'">{{ trans('admin.application.columns.male') }}</th>
                                        <th is='sortable' :column="'military'">{{ trans('admin.application.columns.military') }}</th>
                                        <th is='sortable' :column="'email'">{{ trans('admin.application.columns.email') }}</th>
                                        <th is='sortable' :column="'phone'">{{ trans('admin.application.columns.phone') }}</th>
                                        <th is='sortable' :column="'phone_2'">{{ trans('admin.application.columns.phone_2') }}</th>
                                        <th is='sortable' :column="'city'">{{ trans('admin.application.columns.city') }}</th>
                                        <th is='sortable' :column="'area'">{{ trans('admin.application.columns.area') }}</th>
                                        <th is='sortable' :column="'education'">{{ trans('admin.application.columns.education') }}</th>
                                        <th is='sortable' :column="'experience'">{{ trans('admin.application.columns.experience') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="15">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/seo/applications')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/seo/applications/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                    <td>@{{ item.id }}</td>
                                        <td>@{{ item.fullname }}</td>
                                        <td>@{{ item.job.title }}</td>
                                        <td>@{{ item.bday | date }}</td>
                                        <td>@{{ item.male }}</td>
                                        <td>@{{ item.military }}</td>
                                        <td>@{{ item.email }}</td>
                                        <td>@{{ item.phone }}</td>
                                        <td>@{{ item.phone_2 }}</td>
                                        <td>@{{ item.city }}</td>
                                        <td>@{{ item.area }}</td>
                                        <td>@{{ item.education }}</td>
                                        <td>@{{ item.experience }}</td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.seo_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.seo_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('seo/applications/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.application.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </application-listing>

@endsection
