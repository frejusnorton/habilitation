@extends('layouts.main')
@section('page-title')
    <div class="page-title d-flex flex-column me-3">

        <h1 class="d-flex text-white fw-bolder my-1 fs-3">Gestion des demandes en attente</h1>

        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">

            <li class="breadcrumb-item text-white opacity-75">
                <a href="{{ route('app_habilitation_index') }}" class="text-white text-hover-primary">Accueil</a>
            </li>

            <li class="breadcrumb-item">
                <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
            </li>

            <li class="breadcrumb-item text-white opacity-75"> Listes des demandes en attente</li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
            </div>
        </div>
        <div class="card-body py-4" id="datapart">
            @include('validateur.details')
        </div>
    </div>
@endsection

@section('js')
    @include('validateur.js')
@endsection