@extends('layouts.master')

@section('headCss')
    @parent
@show

@section('header')
    @parent
@endsection

@section('content')
    <div id="topo" class="abertura container head">
        <div class="header-text text-center cor">
            <h1>GPEG</h1>
            <h2>
                @lang('content.group_name')
            </h2>
            <a href="#about" id="botaoR" class="btn btn-warning btn-lg page-scroll">
                @lang('content.button.know_more')
            </a>
        </div>
    </div>

    <div id="about" class= "container">
        <div class="row">
            <div class="col-md-6 col-sm-6 text-center">
                <h2>
                    @lang('content.title.about_project')
                </h2>
                <hr>
                <p>
                    @lang('content.description.about_project')
                </p>
            </div>
        </div>
    </div>

    <div class="container events">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>
                    @lang('content.title.events')
                </h2><hr><br>
                {{-- TODO: Adicionar partial foreach com eventos --}}
                {{-- require_once 'eventos.php' ?> --}}
            </div>
        </div>
    </div>

    <div class="grey">
        <div class="container" id="equipe">

            <div class="row">
                <div class="col-xs-12 col-md-12 text-center">
                    <h2>@lang('content.title.team')</h2>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/sonia.jpg') }}" class="img-responsive img-circle" alt="SoniaFonseca." />
                    <h4>Profa. Dra. Sônia Fonseca</h4>
                    <p class="text-muted">
                        @lang('content.description.office.coordinator')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/0463654957762860" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/dib.jpg') }}" class="img-responsive img-circle" alt="AlfredoDib." />
                    <h4>Prof. Dr. Alfredo Dib</h4>
                    <p class="text-muted">
                        @lang('content.description.office.coordinator')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/1796262889247106" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/sandra.jpg') }}" class="img-responsive img-circle" alt="SandraMagina." />
                    <h4>Profa. Dra. Sandra Magina</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/8948168068305523" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/cristiane.jpg') }}" class="img-responsive img-circle" alt="CristianeNunes." />
                    <h4>Profa. Dra. Cristiane Nunes</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/2605711426731517" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/maria.jpg') }}" class="img-responsive img-circle" alt="MariaCouto." />
                    <h4>Profa. Dra. Maria Elizabete Couto</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/1085573737741686" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/adriana.jpg') }}" class="img-responsive img-circle" alt="NubiaCoelho." />
                    <h4>Profa. Ms. Adriana Lemos</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/4859759360714176" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/nubia.jpg') }}" class="img-responsive img-circle" alt="NubiaCoelho." />
                    <h4>Profa. Ms. Núbia Coelho</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/8805505919801951" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/rejane.jpg') }}" class="img-responsive img-circle" alt="Lizandra." />
                    <h4>Profa. Ms. Rejane Cristo</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/2735031656327022" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/lizandra.jpeg') }}" class="img-responsive img-circle" alt="Lizandra." />
                    <h4>Profa. Lizandra Lima</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/1733563178673837" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/delia.jpg') }}" class="img-responsive img-circle" alt="MariaCouto." />
                    <h4>Profa. Délia Ladeia</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/3786549513375655" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="clearfix visible-xs-block"></div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/jv.jpg') }}" class="img-responsive img-circle" alt="JoãoVitor." />
                    <h4>João Vitor Mendes</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/6835039917378391AS" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
                <div class="col-xs-6 col-md-3 text-center">
                    <img src="{{ asset('img/eva.jpg') }}" class="img-responsive img-circle" alt="EvaMaia." />
                    <h4>Eva Maia Malta</h4>
                    <p class="text-muted">
                        @lang('content.description.office.researcher')
                    </p>
                    <a target="_blank" href="http://lattes.cnpq.br/3183898522744068" class="botaoTeam btn page-scroll">Lattes</a>
                </div>
            </div>

        </div>
    </div>

    <section class="margin-bottom-fair">
        <div id="contactForm" class="container">

            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>
                        @lang('content.title.contact')
                    </h2><hr>
                </div>
            </div>

            <div class="row">
                <form name="sentMessage" action="/" method="post">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="form-group">
                            <input class="form-control" id="tNome" name="tNome" minlength="3" maxlength="100" type="text" placeholder="@lang('content.word.name') *" required>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="eEmail" name="eEmail" minlength="5" maxlength="100" type="email" placeholder="@lang('content.word.email') *" required>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="tAssunto" name="tAssunto" minlength="5" maxlength="100" type="text" placeholder="@lang('content.word.subject') *" required>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="taMensagem" name="taMensagem" minlength="20" maxlength="2000" placeholder="@lang('content.word.message') *" rows="3" required></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 text-center">
                        <div id="success"></div>
                        <button id="sendMessageButton" class="btn btn-xl" type="submit">
                            @lang('content.button.submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('footerScripts')
    @parent
@endsection
