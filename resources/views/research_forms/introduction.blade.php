@extends('layouts.master')

@section('headCss')
    @parent
@endsection

@section('title')
    @lang('content.title.introduction')
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="container margin-bottom">

        <div class="row">
            <div class="col-md-12 text-center">
                <h1>
                    @lang('content.title.quiz')
                </h1>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4>@lang('content.title.research_project'):</h4>
                <h3 class='none-margin-top'>
                    @lang('content.title.rp_school_management')
                </h3>
                <br>
                <h4>
                    @lang('content.description.office.coordinator'):
                </h4>
                <h3 class="none-margin-top">Profa. Dra. Sônia Fonseca</h3>
                <br>
                <hr>
                <p class="text-justify">
                    @lang('content.description.message_manager')
                </p>
                <hr><br>
            </div>

            <div class="form-group col-md-12 text-right">
                {{-- TODO: Corrigir link --}}
                <button type="button" class="btn btn-lg btn-warning" onclick="">
                    @lang('content.button.start_research')
                    {{ $shoolHash }}
                </button>
            </div>

        </div>

    </div>
@endsection

@section('footerScripts')
    @parent
@endsection
