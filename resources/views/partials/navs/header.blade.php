<nav class="navbar navbar-default navbar-fixed-top">
    <div  class="container-fluid head">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="{{ url('/', config('app.locale')) }}">
                GPEG
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar_menu">
            <ul class="nav navbar-nav navbar-right">
                <li><a class="page-scroll" href="{{ url('/', config('app.locale')) }}#topo"><span class="fa fa-home" aria-hidden="true"></span> Home</a></li>
                <li><a class="page-scroll" href="{{ url('/', config('app.locale')) }}#about"><span class="fa fa-info-circle" aria-hidden="true"></span> Sobre</a></li>
                <li><a class="page-scroll" href="{{ url('/', config('app.locale')) }}#equipe"><span class="fa fa-users" aria-hidden="true"></span> Equipe</a></li>
                <li><a class="page-scroll" href="{{ url('/', config('app.locale')) }}#contactForm"><span class="fa fa-envelope" aria-hidden="true"></span> Contato</a></li>
                <li>
                    {{-- TODO: Adicionar o caminho Post --}}
                    <form class="navbar-form" method="POST" action="{{ route('l.search_hash') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="shoolHash" name="shoolHash" class="form-control" placeholder="Código">
                        </div>
                        <button type="submit" class="btn btn-default">OK</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
