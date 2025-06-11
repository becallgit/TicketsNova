<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKET Nº {{$ticket->id}}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/icononova.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">


</head>
<body>
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
                    </div>
                </li>
              @endif
            </ul>
        </div>

        <ul class="menu">
        <!-- <li><a href="{{ route('ver.crearticket') }}"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Nueva Solicitud</a></li> -->
        @if (Auth::user()->create_ticket == 1)
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

    <div class="form-container">
    <h2>Detalles del Ticket Nº {{$ticket->id}} <!-- &nbsp;<a href="{{ route('ver.Editar', $ticket->id) }}" class="icono" title="Editar Ticket"><i class="fa-solid fa-pen-to-square"></i></a> -->
    <!-- &nbsp;    <a href="{{ route('cerrar.ticket', $ticket->id) }}" class="icono"  title="Cerrar Ticket"><i class="fa-solid fa-door-closed"></i></a> -->


    </h2>
        <div class="form-columns">
            <!-- Columna de Detalles -->
            <div class="form-section">
                <h3>Detalles</h3>
                <div class="form-group">
                <div class="estado-prioridad" style="display: flex; align-items: center; gap: 20px;">
                    <div class="estado" style="display: flex; align-items: center; gap: 5px;">
                        <label>Estado:</label>
                        <span class="{{ $ticket->estado === 'Abierto' ? 'green' : ($ticket->estado === 'Cerrado' ? 'grey' : ($ticket->estado === 'Pausado' ? 'purple' : 'blue')) }}">
                        <i class="fa-solid fa-circle"></i> {{$ticket->estado}} 

                        @if($ticket->para == Auth::user()->username)
                             <a href="{{ route('interno.cerrar', $ticket->id) }}" class="icono"  title="Cerrar Ticket"><i class="fa-solid fa-door-closed"></i></a>
                        @endif
                    </span>

                    </div>
                    
                    
                </div>
            </div>
  
    
                <div class="form-group">
                    <label for="solicitante">Solicitante</label>
                    <input type="text" id="solicitante" name="solicitante" value="{{ $ticket->solicitante }}" readonly>
                </div>
                <div class="form-group">
                    <label for="para">Asignado a:</label><br>
                    @if(Auth::user()->rol == "admin")
                    @if ($ticket->usuarioAsignado)
                        <button type="button" class="btn-asignar asignado" data-ticket-id="{{ $ticket->id }}" >
                        <i class="fa-solid fa-user-gear"></i>  {{ $ticket->usuarioAsignado->username }}
                            </button>
                        @else
                            <button type="button" class="btn-asignar sinasignar" data-ticket-id="{{ $ticket->id }}">
                            Sin Asignar
                            </button>

                           
                        @endif
                    @else
                    <input type="text" value ="{{ $ticket->usuarioAsignado->username }}">
                        
                    @endif
                </div>
                <div class="form-group">
                    <label for="tipo_solicitud">Tipo de solicitud</label>
                    <input type="text" id="tipo_solicitud" name="tipo_solicitud" value="{{ $ticket->tipo_solicitud }}" readonly>
                </div>
                <div class="form-group">
                    <label for="cliente">Cliente</label>
                    <input type="text" id="cliente" name="cliente" value="{{ $ticket->cliente }}" readonly>
                </div>
         
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" id="marca" name="marca" value="{{ $ticket->marca }}" readonly>
                </div>
                <div class="form-group">
                    <label for="sede">Sede</label>
                    <input type="text" id="sede" name="sede" value="{{ $ticket->sede }}" readonly>
                </div>
                <div class="form-group">
                    <label for="observaciones_ticket">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" readonly>{{ $ticket->observaciones}}</textarea>
                </div>
           
            
            </div>
            <div class="form-section">
            <h3>Mas info:</h3>
               <p><strong>Fecha y Hora de Creacion: </strong>{{$ticket->creado}}</p> 
               <p><strong>Fecha y Hora de Asignacion: </strong>{{$ticket->asignado}}</p>
               <p><strong>Fecha y Hora de Cierre: </strong>{{$ticket->cerrado}}</p>

              <form action="{{ route('guardar.atach', $ticket->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label for="ask_nova">Pregunta/respuesta NOVA</label>
                        <textarea name="ask_nova" id="ask_nova" >{{$ticket->ask_nova}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="answer_client">Respuesta Cliente</label>
                        <textarea name="answer_client" id="answer_client" >{{$ticket->answer_client}}</textarea>
                    </div>
                     <div class="form-group">
                        <label for="adjuntos">Adjuntar Archivos</label>
                        <input type="file" name="adjuntos[]" id="adjuntos" multiple>
                    </div>
                         <button type="submit" class="submit-btn">Guardar</button>
            </form> 
                

             
            </div>
             
   
       
        </div>
       <div class="form-section">
            <h3>Archivos adjuntos:</h3>

            @if(!empty($ticket->adjuntos) && is_array(json_decode($ticket->adjuntos, true)) && count(json_decode($ticket->adjuntos, true)) > 0)
              @foreach(json_decode($ticket->adjuntos, true) as $archivo)
                @php
                    $fechaSubida = \Carbon\Carbon::parse($archivo['fecha_subida']);
                    $diasRestantes = 20 - now()->diffInDays($fechaSubida);
                @endphp

                @if($diasRestantes > 0)
                    <div class="archivo-item">
                        <span class="archivo-nombre">{{ $archivo['nombre'] }}</span>
                        <small style="color:gray;">Visible por {{ $diasRestantes }} días más</small>
                        <div>
                            <a href="{{ route('archivo.descargar', ['nombre' => $archivo['nombre']]) }}" target="_blank" class="archivo-icono">
                                <i class="fa-solid fa-download" style="color:#8598b1"></i>
                            </a>
                            @if(Auth::user()->rol == "admin")
                            <form action="{{ route('archivo.eliminar', ['ticket' => $ticket->id, 'archivo' => $archivo['nombre']]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="archivo-icono" style="border: none; background: none;" onclick="return confirm('¿Seguro que quieres eliminar este archivo?')">
                                    <i class="fa-solid fa-trash" style="color:#d9534f;cursor:pointer"></i>
                                </button>
                            </form>
                             @endif
                        </div>
                    </div>
                @endif
            @endforeach


            @else
                <p>No hay archivos adjuntos.</p>
            @endif
        </div>

      </div>
       <div id="modal-asignar" style="display:none;">
        <div class="modal-content">
            <h2>Asignar Usuario</h2>
            <form id="form-asignar" action="{{ route('interno.asignar') }}" method="POST">
                @csrf
                <input type="hidden" id="ticket-id" name="ticket_id">
                <label for="user-select">Selecciona un usuario:</label>
                <select id="user-select" name="id_user">
                    <option value="" label="Selecciona.."></option>
                </select>
                <button type="submit">Asignar</button>
                <button type="button" onclick="closeModal()">Cerrar</button>
            </form>
        </div>
    </div>

<script>
    document.querySelectorAll('.btn-asignar').forEach(button => {
        button.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-ticket-id');
            console.log('Ticket ID antes de la llamada:', ticketId); 

            if (!ticketId) {
                console.error('No se encontró el ID del ticket.');
                return;
            }

            document.getElementById('ticket-id').value = ticketId;

            const url = '{{ route("interno.get-users") }}?ticket_id=' + ticketId;
            console.log('URL de fetch:', url); 

            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json(); 
            })
            .then(users => {
                console.log('Usuarios devueltos:', users); 

                if (!Array.isArray(users)) {
                    console.error('La respuesta no es un array:', users);
                    return;
                }

                const userSelect = document.getElementById('user-select');
                userSelect.innerHTML = '<option value="" label="Selecciona.."></option>'; 

          
                users.forEach(user => {
                    console.log('Usuario:', user);
                    const option = document.createElement('option');
                    option.value = user.id; 
                    option.textContent = user.username;
                    userSelect.appendChild(option);
                });

                
                document.getElementById('modal-asignar').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error:', error); 
            });
        });
    });



    function closeModal() {
        document.getElementById('modal-asignar').style.display = 'none';
    }
</script>

    <style>
        .archivo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 5px;
        }

        .archivo-nombre {
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .archivo-icono {
            margin-left: 15px;
            text-decoration: none;
        }

          #modal-asignar {
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
        }

        .modal-content {
            background-color: #ffffff; 
            padding: 25px;
            border-radius: 10px; 
            width: 90%;
            max-width: 400px; 
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2); 
            text-align: center;
            animation: fadeIn 0.3s ease-in-out; 
        }

        .modal-content h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .modal-content label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #666;
        }

        #user-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #333;
        }

        .modal-content button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .modal-content button[type="submit"] {
            background-color: #8598b1;
            color: #ffffff;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #b4c3d6;
        }

        .modal-content button[type="button"] {
            background-color: #e0e0e0;
            color: #333;
        }

        .modal-content button[type="button"]:hover {
            background-color: #cccccc; 
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .asignado{
            padding:6px;
            border-radius:6px;
            border: none; 
            cursor:pointer;
   
        }
 
        .asignado:hover{
            background-color:white
        }
            .sinasignar{
           border:none;
           padding:7px;
           border-radius:5px;
         cursor:pointer
        }
        #download{
            margin-left:20px;
        }
        body {
            font-family: "Roboto";
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5f5f5;
        }
     .submit-btn {
            background-color: #8598b1;
            color: white;
            border: none;
            float:right;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
          .submit-btn:hover {
            background-color: #b4c3d6;
        }
     
        h2{
            text-align:center
        }
        .navbar {
            background-color: white;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);  
        }

       
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar .logo {
            font-size: 26px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease;
        }

        .menu {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

   
        .menu a {
            color: #333; 
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            font-weight: bold;
            background-color: #fff; 
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .menu a:hover {
            color: #8598b1;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff; 
            min-width: 160px;
            top: 110%;
            left: 0;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            transition: opacity 0.3s ease, transform 0.3s ease, top 0.3s ease;
            opacity: 0;
            transform: translateY(10px);
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
            top: 120%;
        }
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-top:-3px;
            margin-bottom:-4px;;
        }

        /* Diseño de Columnas */
        .form-columns {
            display: flex;
            gap: 20px;
        }

        .form-section {
            flex: 1;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
        }

        .form-section h3 {
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #8598b1;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }

        .form-group textarea {
            min-height: 80px;
        }

    
        .estado {
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 23px;
        }
        .prioridad {
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .icono{
            color:#8598b1;
        }
        .icono:hover{
            color:#b4c3d6;
        }
        .estado span.green { color: green; }
        .estado span.grey { color: grey; }
        .estado span.blue { color: blue; }
        .estado span.purple { color: purple; }
        .prioridad span.red { color: red; }
        .prioridad span.yellow { color: orange; }
        .prioridad span.gray { color: gray; }
    </style>
</body>
</html>
