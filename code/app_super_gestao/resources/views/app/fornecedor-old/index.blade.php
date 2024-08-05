<h3>Fornecedor</h3>

@php
    
@endphp



{{-- @if(count($fornecedores)>0 && count($fornecedores)<10)
    <h3>Existem alguns fornecedores cadastrados</h3>
@elseif(count($fornecedores)>10)
    <h3>Existem vários fornecedores cadastrados</h3>
@else
    <h3>Ainda não existem fornecedores cadastrados</h3>
@endif --}}

@isset($fornecedores)
    {{-- @php $i = 0 @endphp
    @while(isset($fornecedor)) --}}
        {{-- @for($i=0;isset($fornecedor);$i++) --}}
    {{-- @foreach($fornecedores as $indice => $fornecedor) --}}
    @forelse($fornecedores as $indice => $fornecedor)
    {{-- @dd($loop) --}}
        Iteração atual: {{$loop->iteration}}
        <br>
        Fornecedor: @{{$fornecedor['nome']}}
        <br>
        Status: {{$fornecedor['status']}}
        <br>
        {{-- @isset($fornecedor['cnpj'])
            CNPJ:  {{$fornecedor['cnpj']}}
            @empty($fornecedor['cnpj'])
                - Vazio
            @endempty
        @endisset --}}
        CNPJ:{{$fornecedor['cnpj'] ?? 'Dado não foi preenchido'}}
        {{-- ^ Variavel testada nao estiver definida
        ou se estiver null --}}
        <br>
        Telefone: {{$fornecedor['ddd'] ?? 'Dado não foi preenchido'}} {{$fornecedor['telefone'] ?? 'Dado não foi preenchido'}}
        <br>
        
        @switch($fornecedor['ddd'])
            @case('11')
                São Paulo - SP
                @break
            @case('32')
                Juiz de Fora - MG
                @break   
            @case('85')
                Fortaleza - CE
                @break   
            @default
                Estado não identificado
        @endswitch
        <br>
        @if($loop->first)
            Primeira iteração do loop
        @endif
        @if($loop->last)
            Última iteração do loop
            <br>
            Total de registros: {{$loop->count}}
        @endif
        <br>
        <hr>
        {{-- @php $i ++; @endphp --}}
    @empty
        Não existem fornecedores cadastrados
    {{-- @endwhile --}}
    {{-- @dd($fornecedores) --}}
    {{-- @endforeach --}}
    
    @endforelse
    {{-- @endfor --}}
@endisset



{{-- @if(!($fornecedores[0]['status']=='S'))
    Fornecedor Inativo
@endif
<br>
@unless($fornecedores[0]['status']=='S')
     Fornecedor Inativo
    <br>
@endunless --}}

