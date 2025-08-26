<nav class="navbar">
        <div class="navbar-left">
            <a href="{{ route('dashboard') }}" class="logo"><img src="{{ asset('images/logolargo.png') }}" width="130" alt="Logo"></a>
            <ul class="menu">
                <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-house"></i>&nbsp;&nbsp;Inicio</a></li>
                <li class="dropdown">
                    <a href="#"><i class="fa-solid fa-list-check"></i>&nbsp;&nbsp;Solicitudes </a>
                    <div class="dropdown-content">
                        <a href="{{ route('vista-solit-global') }}"><i class="fa-solid fa-earth-africa"></i>&nbsp;Totales</a>
                        <a href="{{ route('ver.abiertos') }}"><i class="fa-solid fa-door-open"></i>&nbsp;Abiertas</a>
                        <a href="{{ route('ver.solicitudes.totales') }}"><i class="fa-solid fa-user-xmark"></i>&nbsp;Sin Asignar</a>
                        <a href="{{ route('ver.cerrados') }}"><i class="fa-solid fa-door-closed"></i>&nbsp;Cerradas</a>
    
                    </div>
                </li>
          
                <li class="dropdown">
                    <a href="{{ route('vista-missolicitudes') }}"><i class="fa-solid fa-check-to-slot"></i>&nbsp;&nbsp;Mis Solicitudes</a>
                </li>
                @if (Auth::user()->create_ticket == 1)
                <li class="dropdown">
                    <a href="#"><i class="fa-solid fa-ticket"></i>&nbsp;&nbsp;Tickets Internos </a>
                    <div class="dropdown-content">
                         <a href="{{ route('interno.mispetis') }}"><i class="fa-solid fa-person-circle-question"></i>&nbsp;Mis Peticiones</a>
                    @if (Auth::user()->rol == "admin" && Auth::user()->username != 'angel.lopez')
                         <a href="{{ route('interno.parami') }}"><i class="fa-solid fa-user-tie"></i>&nbsp;Para mi</a>
                        <a href="{{ route('interno.globales') }}"><i class="fa-solid fa-earth-africa"></i>&nbsp;Totales</a>
                        <a href="{{ route('interno.abiertos') }}"><i class="fa-solid fa-door-open"></i>&nbsp;Abiertos</a>
                        <a href="{{ route('interno.cerrados') }}"><i class="fa-solid fa-door-closed"></i>&nbsp;Cerrados</a>
                    @endif
                    @if(Auth::user()->read_ti == 1)
                        <a href="{{ route('interno.solicitud') }}"><i class="fa-solid fa-earth-africa"></i>&nbsp;Totales</a>

                    @endif
                    </div>
                </li>
              @endif
                 @if (Auth::user()->username == "superadmin" || Auth::user()->username == "inma.salguero")
              <li><a href="{{route('tickets.export')}}"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Exportar a Excel </a></li>
             @endif
            </ul>
        </div>

        <ul class="menu">
            @php
                $excluidos = ['inma.salguero', 'tatiana.pizarro', 'ignaciof.caravia'];
            @endphp

            @if (Auth::user()->create_ticket == 1 && !in_array(Auth::user()->username, $excluidos))
                <li><a href="{{ route('ver.crearticket') }}"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Crear Ticket</a></li> 
            @endif
            <li class="dropdown">
                <a href="#"><i class="fa-solid fa-user-astronaut"></i>&nbsp;&nbsp;{{$username}}</a>
                <div class="dropdown-content">
                
                    <a href="{{ route('signout') }}"><i class="fa-solid fa-power-off"></i> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </nav>