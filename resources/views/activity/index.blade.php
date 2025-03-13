@extends('layouts.app')

@section('content')
    <div id="kt_app_content_container" class="app-container  container-fluid ">
        <form action="{{route('app_activity_export')}}" method="post" id="activityForm">
            @csrf
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text"  id="search" name="search"
                               class="form-control form-control-solid w-250px ps-13 filter"
                               placeholder="Recherche..."/>
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-filter fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Filtrer
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-500px w-md-500px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Filtrer la liste</div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Periode:</label>
                                    <input class="form-control form-control-solid dateRange filter" placeholder="Choisir une periode" id="periode" name="periode"/>
                                </div>

                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Utilisateur:</label>
                                    <select  class="form-select  rounded-start-0 border-start form-select-solid filter" data-control="select2"
                                            data-placeholder="Selectionner un utilisateur" name="user" id="user">
                                        <option></option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">
                                                {{$item->employe ? $item->employe->nom .' ' .$item->employe->prenoms : ''}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset"
                                            class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                            data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Annuler
                                    </button>

                                </div>
                                <!--end::Actions-->
                            </div>

                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->

                        <!--begin::Export-->
                        <button type="submit" class="btn btn-light-primary me-3" id="export" form="activityForm" >
                            <i class="ki-duotone ki-exit-up fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Export
                        </button>
                        <!--end::Export-->
                    </div>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body py-4" id="datatoload">
                @include('activity.datapart')
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        </form>
    </div>

@endsection

@section('js')
    @include('activity.main-js')
@endsection
