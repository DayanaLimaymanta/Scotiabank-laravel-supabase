@if(Session::get('usuario_rol') == 'cliente')
    @include('banca-internet')
@elseif(Session::get('usuario_rol') == 'asesor')
    @include('core-asesor')
@else
    <script>window.location.href = '/login';</script>
@endif