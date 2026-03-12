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
                 @if (Auth::user()->username == "superadmin" || Auth::user()->username == "inma.salguero"
                 ||Auth::user()->username == "tatiana.pizarro"  || Auth::user()->username == "ignaciof.caravia"  )
              <li><a href="#" id="open-export-modal"><i class="fa-regular fa-file-excel"></i>&nbsp;&nbsp;Exportar a Excel </a></li>
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

    <div id="modal-export-excel" style="display:none;">
        <div class="modal-content">
            <h2>Exportar a Excel</h2>
            <button type="button" id="close-export-modal-top" aria-label="Cerrar">×</button>

            <div class="export-grid" style="margin-top: 10px;">
                <div class="export-col">
                    <h3 style="margin-top: 0;">Tickets</h3>
                    <form method="GET" action="{{ route('tickets.export.filter') }}">
                        <label for="ticket_para">Para</label>
                        <select id="ticket_para" name="para">
                            <option value="" label="Selecciona..."></option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->nombre }}</option>
                            @endforeach
                        </select>

                        <label for="ticket_fecha_desde">Creado desde</label>
                        <input type="date" id="ticket_fecha_desde" name="creado_desde">

                        <label for="ticket_fecha_hasta">Creado hasta</label>
                        <input type="date" id="ticket_fecha_hasta" name="creado_hasta">

                        <label for="ticket_matricula">Matricula</label>
                        <input type="text" id="ticket_matricula" name="matricula">

                        <button type="submit">Exportar Tickets</button>
                    </form>
                </div>

                <div class="export-col">
                    <h3 style="margin-top: 0;">Tickets Internos</h3>
                    <form method="GET" action="{{ route('tickets_internos.export.filter') }}">
                        <label for="ti_cliente">Cliente</label>
                        <select id="ti_cliente" name="cliente">
                            <option value="" label="Selecciona..."></option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->nombre }}">{{ $team->nombre }}</option>
                            @endforeach
                        </select>

                        <label for="ti_fecha_desde">Creado desde</label>
                        <input type="date" id="ti_fecha_desde" name="creado_desde">

                        <label for="ti_fecha_hasta">Creado hasta</label>
                        <input type="date" id="ti_fecha_hasta" name="creado_hasta">

                        <label for="ti_sede">Sede</label>
                        <input type="text" id="ti_sede" name="sede">

                        <label for="ti_matricula">Matricula</label>
                        <input type="text" id="ti_matricula" name="matricula">

                        <label for="ti_tipo_solicitud">Tipo de solicitud</label>
                        <select id="ti_tipo_solicitud" name="tipo_solicitud">
                            <option value="" label="Selecciona..."></option>
                            <option value="Incidencia">Incidencia</option>
                            <option value="Mejora">Mejora</option>
                            <option value="Consulta">Consulta</option>
                        </select>

                        <button type="submit">Exportar Tickets Internos</button>
                        <button type="button" id="close-export-modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const openBtn = document.getElementById('open-export-modal');
            const modal = document.getElementById('modal-export-excel');
            const closeBtn = document.getElementById('close-export-modal');
            const closeTopBtn = document.getElementById('close-export-modal-top');

            if (!openBtn || !modal || !closeBtn || !closeTopBtn) return;

            openBtn.addEventListener('click', function (e) {
                e.preventDefault();
                modal.style.display = 'flex';
            });

            closeBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            closeTopBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            modal.addEventListener('click', function (e) {
                if (e.target === modal) modal.style.display = 'none';
            });
        })();
    </script>

    <style>
        #modal-export-excel {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            padding: 12px;
        }

        #modal-export-excel,
        #modal-export-excel * {
            box-sizing: border-box;
        }

        #modal-export-excel .modal-content {
            background-color: #ffffff;
            padding: 16px;
            border-radius: 10px;
            width: 100%;
            max-width: 520px;
            max-height: calc(100vh - 24px);
            overflow: auto;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: relative;
        }

        #close-export-modal-top {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            background: #fff;
            color: #333;
            font-size: 22px;
            line-height: 30px;
            cursor: pointer;
        }

        #close-export-modal-top:hover {
            background: #f3f3f3;
        }

        #modal-export-excel .modal-content h2 {
            text-align: center;
            margin-top: 0;
        }

        #modal-export-excel label {
            display: block;
            margin-top: 8px;
            margin-bottom: 4px;
            font-size: 14px;
        }

        #modal-export-excel input,
        #modal-export-excel select {
            width: 100%;
            max-width: 100%;
            padding: 9px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            height: 40px;
            line-height: 20px;
        }

        #modal-export-excel input[type="date"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        #modal-export-excel select {
            background-color: #fff;
        }

        #modal-export-excel button {
            width: 100%;
            max-width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        #modal-export-excel form {
            display: grid;
            gap: 8px;
        }

        #modal-export-excel form button {
            margin-top: 4px;
        }

        #modal-export-excel button[type="submit"] {
            background-color: #8598b1;
            color: #ffffff;
        }

        #modal-export-excel .export-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        #modal-export-excel .export-col {
            padding: 12px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        @media (min-width: 900px) {
            #modal-export-excel .modal-content {
                max-width: 980px;
                padding: 22px;
            }

            #modal-export-excel .export-grid {
                grid-template-columns: 1fr 1fr;
                align-items: start;
            }
        }

        @media (max-width: 420px) {
            #modal-export-excel .modal-content {
                border-radius: 8px;
            }

            #modal-export-excel .export-col {
                padding: 10px;
            }

            #modal-export-excel button {
                font-size: 15px;
            }
        }
    </style>