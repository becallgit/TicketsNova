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
                    </span>

                    </div>
                    
                    
                </div>
            </div>
  
    
                <div class="form-group">
                    <label for="team_id">Para</label>
                    <input type="text" id="team_id" name="team_id" value="{{ $ticket->team ? $ticket->team->nombre : 'No asignado' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="id_user">Asignado a:</label>
                    <input type="text" id="id_user" name="id_user" value="{{ $ticket->usuarioAsignado->username ?? 'No asignado' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nombre_cliente">Nombre Cliente</label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" value="{{ $ticket->nombre_cliente }}" readonly>
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono de contacto</label>
                    <input type="text" id="telefono" name="telefono" value="{{ $ticket->telefono }}" readonly>
                </div>
                <div class="form-group">
                    <label for="matricula">Matricula</label>
                    <input type="text" id="matricula" name="matricula" value="{{ $ticket->matricula }}" readonly>
                </div>
                <div class="form-group">
                    <label for="bastidor">Bastidor</label>
                    <input type="text" id="bastidor" name="bastidor" value="{{ $ticket->bastidor }}" readonly>
                </div>
                <div class="form-group">
                    <label for="observaciones_ticket">Observaciones</label>
                    <textarea name="observaciones_ticket" id="observaciones_ticket" readonly>{{ $ticket->observaciones_ticket }}</textarea>
                </div>
           
            
            </div>
            <div class="form-section">
            <h3>Mas info:</h3>
               <p><strong>Fecha y Hora de Creacion: </strong>{{$ticket->creado}}</p> 
               <p><strong>Fecha y Hora de Asignacion: </strong>{{$ticket->asignado}}</p>
               <p><strong>Fecha y Hora de Edicion: </strong>{{$ticket->actualizado}}</p>
               <p><strong>Fecha y Hora de Cierre: </strong>{{$ticket->cerrado}}</p>
            </div>
          
        </div>
    </div>
    <style>
        body {
            font-family: "Roboto";
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5f5f5;
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
