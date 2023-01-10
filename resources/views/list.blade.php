@extends('layout')
@section('header')    

@endsection

@section('main')
<link href="/style.css" rel="stylesheet">
<header class="header">
<nav class="navbar navbar-expand-lg header-nav fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index">ShopList</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="profile">Perfil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="report">Relatório</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mais
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="historic">Histórico</a></li>
            <li><a class="dropdown-item" href="settings">Configurações</a></li>
            <li><a class="dropdown-item" href="donation">Doação</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout">Sair</a></li>
          </ul>
        </li>
      </ul>
      @if($lista->finaizada=0)
        <ul class="navbar-nav ms-auto">
          <button type="button" class="btn" data-target="#modalExemplo" data-salvar onclick="chamaPopUp()">Adicionar Produto</button>
        </ul>
      @endif
    </div>
  </div>
</nav>       
</header>
<main class="fix-fill">
<div class="modal pagina" id="modalExemplo" tabindex="-1" role="dialog" style="margin: 0!important;" aria-labelledby="exampleModalLabel" aria-hidden="true" popUp-cadastrar-tag>
  <div class="modal-dialog input" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form class="container" action="{{route('dicionarItem')}}" method="POST">
          @csrf 
          <input type="hidden" name="idLista" value="{{$lista->id}}" >
          <input type="text" placeholder="nome do Produto" name="nome" class="input-home" >
          <input type="text" placeholder="preço do produto" name="preco" class="input-home">
          <input type="text" placeholder="quantidade do produto" name="quantidade" class="input-home">
          <input type="text" placeholder="descrição do produto" name="descricao" class="input-home">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="removerPopUp()">Cancelar</button>
            <button class="btn" type="submit">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <div class="container">
  </br>
  <div style="display: inline-flex;flex-direction: row;justify-content: space-between;align-items: baseline;width: inherit;">
    <h1>{{$lista->nome}}</h1>
    <div style="display: inline-flex;flex-direction: row;justify-content: space-around;align-items: baseline;">
    @if(!isset($lista->limiteLista))
                <p style="color:#54a666;margin-right: 1rem;">R$ {{$lista->valorTotal}}</p>
                <input style="background-color: #54a666;" type="range" id="limite" name="limite" min="0" max="{{$lista->valorTotal}}" value="{{$lista->valorTotal}}" disabled>
              @else
                @if($lista->valorTotal<=$lista->limiteLista)
                  <p title="Valor total dos produtos" style="color:#54a666;margin-right: 1rem;">R$ {{$lista->valorTotal}}</p>
                  <input style="background-color: #54a666;" type="range" id="limite" name="limite" min="0" max="{{$lista->limiteLista}}" value="{{$lista->valorTotal}}" disabled>
                  <p title="Limite previsto" style="color:#54a666;margin-left: 1rem;">R$ {{$lista->limiteLista}}</p>
                @else
                  <p title="Valor total dos produtos" style="color:#e6d53a;margin-right: 1rem;">R$ {{$lista->valorTotal}}</p>
                  <input style="background-color: #e6d53a;" type="range" id="limite" name="limite" min="0" max="{{$lista->limiteLista}}" value="{{$lista->valorTotal}}" disabled>
                  <p style="color:#e6d53a;margin-left: 1rem;" title="Limite previsto">R$ {{$lista->limiteLista}}</p>
                @endif
              @endif
    </div>
    </div>
    <hr>
    <h1>{{$lista->categoria}}</h1>
    @if(count($items)>0)
    <ul class="list-group mb-3">
      @foreach($items as $item)
      <li class="list-group-item py-3">
        <div class="row g-3">
          <div class="col-4 col-md-3 col-lg-2">
         
          </div>
          <div class="col-8 col-md-9 col-lg-7 col-xl-8 text-left align-self-center">
          <h4><b><a href="#" class="text-decoration-none text-a">{{$item->nomeProduto}}</a></b></h4>
          <h4>
            <small>{{$item->descricao}}</small>
          </h4>
        </div>
        <div class="col-6 offset-6 col-sm-6 offset-sm-6 col-md-4 offset-md-8 col-lg-3 offset-lg-0 col-xl-2 align-self-center mt-3">
          <div class="input-group">
            <button type="button" class="btn-a btn-sm">
              <span class="bi" width="16" height="16" fill="currentColor">&#x2212;</span>
            </button>
            <input type="text" class="form-control text-center border-dark" value="{{$item->quantidade}}"> 
            <button type="button" class="btn-a btn-sm">
              <span class="bi" width="16" height="16" fill="currentColor">&#x2b;</span>
            </button>
            <button type="button" class="btn-outline-danger btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
            </button>
            </div>
            <div class="text-end mt-2">
              <small class="text-secondary">Valor UN: R$ {{$item->preco}}</small><br>
              <span class="text-dark">Valor Item: R$ @php echo $item->preco*$item->quantidade @endphp</span>
            </div>
          </div>
        </div>
      </li>
      @endforeach
      <li class="list-group-item py-3">
        <div class="text-end">
          <h4 class="text-dark mb-3">
             Valor Total: R$ {{$lista->valorTotal}}
          </h4>
          @if($lista->finaizada=0)

            <a href="/index" class="btn btn-outline-success btn-lg">
              Continuar Depois                           
            </a>
            <a href="/finalizarLista?id={{$lista->id}}" class="btn btn-danger btn-lg ms-2 mt-xs-3">
              Terminar Compra
            </a>
            @else
            <h4>Essa lista já foi fianlizada</h4>
            @endif
        </div>
      </li>
    </ul>
    @endif
  </div>
</main>  
<script src="/cadastroItem.js"></script>
<script src="/jquery.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="/script.js"></script>
@endsection