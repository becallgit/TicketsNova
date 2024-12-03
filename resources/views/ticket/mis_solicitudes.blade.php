<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS SOLICITUDES</title>
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
              
               
            </ul>
        </div>

        <ul class="menu">
        <!-- <li><a href="{{ route('ver.crearticket') }}"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Nueva Solicitud</a></li> -->

            <li class="dropdown">
                <a href="#"><i class="fa-solid fa-user-astronaut"></i>&nbsp;&nbsp;{{$username}}</a>
                <div class="dropdown-content">
                    
                    <a href="{{ route('signout') }}"><i class="fa-solid fa-power-off"></i> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </nav>


    <div class="container">
        <h2 style="text-align:center;">Mis Solicitudes</h2>
        <form method="GET" action="{{ route('vista-missolicitudes') }}">
    <div class="filter-container">
        <input type="text" name="id" placeholder="ID" value="{{ request('id') }}">
        <input type="text" name="asignado_a" placeholder="Asignado a" value="{{ request('asignado_a') }}">
        <input type="text" name="nombre_cliente" placeholder="Nombre cliente" value="{{ request('nombre_cliente') }}">        
        <input type="text" name="telefono" placeholder="Telefono" value="{{ request('telefono') }}">
        <input type="text" name="matricula" placeholder="Matricula" value="{{ request('matricula') }}">
        <input type="text" name="bastidor" placeholder="Bastidor" value="{{ request('bastidor') }}">
        <input type="text" name="observaciones_ticket" placeholder="Observaciones" value="{{ request('obserbaciones_ticket') }}">
        <input type="date" name="creado" placeholder="Fecha de creacion" value="{{ request('creado') }}">
        <button type="submit">Filtrar</button>
        <a href="{{ route('vista-missolicitudes') }}"><i class="fa-solid fa-eraser"></i> Limpiar</a>
    </div>
</form>
        <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Para</th>
                    <th>Asignado a</th>
                    <th>Nombre Cliente</th>
                    <!-- <th>Telefono de contacto</th> -->
                    <th>Matricula</th>
                    <th>Bastidor</th>
                    <th>Observaciones</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->team ? $ticket->team->nombre : 'No asignado' }}</td>
                        <td>
                        @if ($ticket->usuarioAsignado)
                        <button type="button" class="btn-asignar asignado" data-ticket-id="{{ $ticket->id }}" data-team-id="{{ $ticket->team_id }}">
                        <i class="fa-solid fa-user-gear"></i>  {{ $ticket->usuarioAsignado->username }}
                            </button>
                        @else
                            <button type="button" class="btn-asignar sinasignar" data-ticket-id="{{ $ticket->id }}" data-team-id="{{ $ticket->team_id }}">
                            Sin Asignar
                            </button>

                           
                        @endif
                        </td>
                        <td>{{ $ticket->nombre_cliente}}</td>
                        <!-- <td>{{ $ticket->telefono }}</td> -->
                        <td>{{ $ticket->matricula }}</td>
                        <td>{{ $ticket->bastidor }}</td>
                        <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $ticket->observaciones_ticket}}</td>
                        <td>
                        @if($ticket->estado === 'Abierto') 
                        <span  style="color:green;font-weight:bold"><i class="fa-regular fa-circle"></i>&nbsp;&nbsp;{{$ticket->estado}}</span>
                        @elseif($ticket->estado === 'Cerrado') 
                            <span style="color:grey;font-weight:bold"><i class="fa-solid fa-circle-xmark"></i>&nbsp;&nbsp;{{$ticket->estado}}</span> 
                        @elseif($ticket->estado === 'En Curso') 
                            <span style="color:blue;font-weight:bold"><i class="fa-solid fa-circle"></i>&nbsp;&nbsp;{{$ticket->estado}}</span>
                        @endif 
                          
                        </td>
                        <td>{{ $ticket->creado}}</td>
                        <td class="acciones">
                            <!-- <a href="{{ route('ver.Editar', $ticket->id) }}" class="icono" title="Editar Ticket"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;|&nbsp; -->
                            <!-- @if(Auth::user()->rol == "admin")
                            |&nbsp;<form action="/ticketsdel/{{ $ticket->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="icono borrar"  title="Eliminar Ticket"><i class="fa-solid fa-trash"></i></button>
                            </form>
                            @endif
                            &nbsp;| -->
                            <a href="{{ route('ticket.mostrado', $ticket->id) }}" class="icono"  title="VerTicket"><i class="fa-solid fa-eye"></i></a>&nbsp;|&nbsp;
                            
                            <a href="{{ route('cerrar.ticket', $ticket->id) }}" class="icono"  title="Cerrar Ticket"><i class="fa-solid fa-door-closed"></i></a>

                        </td>

                      
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        @if ($tickets->isEmpty())
            <p class="notickets">No tienes tickets asignados.</p>
        @endif
    </div>
    <div style="display: flex; justify-content: center;">
    {{ $tickets->links() }}
</div>
    <div id="modal-asignar" style="display:none;">
        <div class="modal-content">
            <h2>Asignar Usuario</h2>
            <form id="form-asignar" action="{{ route('asignar') }}" method="POST">
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

            const url = '{{ route("tickets.get-users") }}?ticket_id=' + ticketId;
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
        body {
            font-family: "Roboto";
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5f5f5;
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

        .tabla-contenedor {
            display: flex;
            justify-content: center; 
            align-items: center; 
            margin-top: 20px; 
        }

        table {
            width: 90%; 
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
            transition: background-color 0.3s ease; 
        }

        th {
            background-color: gray; 
            color: white;
            font-weight: bold;
            text-transform: uppercase; 
        }

        .estado-abierto {
            color: green;
        }

        .estado-cerrado {
            color: gray;
        }

        .estado-progreso {
            color: blue;
        }
        #modal-asignar {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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

        .notickets{
            text-align:center;
        }

    
        .acciones {
            align-items: center; 
        }

        .icono {
            color: #8598b1;
            font-size: 15px; 
            text-decoration: none; 
            transition: color 0.3s ease; 
        }

        .icono:hover {
            color: #b4c3d6; 
        }

        .borrar {
            background: none; 
            border: none; 
            padding: 0; 
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
        .filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            width:88%;
            margin: 0 auto; 
            justify-content:center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-container input[type="text"], .filter-container input[type="date"], .filter-container button {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
           width: 170px;
        }

        .filter-container button[type="submit"] {
            background-color: #8598b1;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .filter-container button[type="submit"]:hover {
            background-color:#b4c3d6;
        }

        .filter-container a {
            text-decoration: none;
            color: #8598b1;
            padding: 10px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>

</html>
