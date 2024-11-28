<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTADO CAMPAÑAS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
</head>
<body>
<nav class="navbar">
        <div class="navbar-left">
            <a href="#" class="logo"><img src="{{ asset('images/logolargo.png') }}" width="150" alt="Logo"></a>
            <ul class="menu">
                <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-house"></i>&nbsp;&nbsp;Inicio</a></li>
                <li class="dropdown">
                    <a href="#"><i class="fa-solid fa-list-check"></i>&nbsp;&nbsp;Solicitudes</a>
                    <div class="dropdown-content">
                        <a href="{{ route('ver.solicitudes.totales') }}"><i class="fa-solid fa-user-xmark"></i>&nbsp;Sin Asignar</a>
                        <a href="{{ route('ver.solicitudes.departamento') }}"><i class="fa-solid fa-people-group"></i>&nbsp;Para mi Departamento</a>
                        <a href="{{ route('ver.cerrados') }}"><i class="fa-solid fa-door-closed"></i>&nbsp;Cerradas</a>
    
                    </div>
                </li>
    
                <li class="dropdown">
                    <a href="{{ route('vista-missolicitudes') }}"><i class="fa-solid fa-check-to-slot"></i>&nbsp;&nbsp;Mis Solicitudes</a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('ver.peticiones') }}"><i class="fa-solid fa-paper-plane"></i>&nbsp;&nbsp;Peticiones Realizadas</a>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fa-solid fa-shield-halved"></i>&nbsp;&nbsp;Administración</a>
                    <div class="dropdown-content">
                        <a href="{{ route('tickets.export') }}"> <i class="fa-solid fa-file-excel"></i> Exportar a Excel</a>
                        <a href="{{ route('listado.campana') }}"> <i class="fa-regular fa-rectangle-list"></i> Campañas</a>
                        <a href="{{ route('listado.categorias') }}"><i class="fa-solid fa-layer-group"></i> Categorías</a>
                        <a href="{{ route('listado.sedes') }}"><i class="fa-solid fa-location-dot"></i> Sedes</a>
                        <a href="{{ route('listado.tipos') }}"><i class="fa-solid fa-table"></i> Tipos</a>
                        <a href="{{ route('listado.motivos') }}"><i class="fa-solid fa-pause"></i> Motivos Pausa</a>
                    </div>
                </li>
            </ul>
        </div>

        <ul class="menu">
        <li><a href="{{ route('ver.crearticket') }}"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Nueva Solicitud</a></li>

            <li class="dropdown">
                <a href="#"><i class="fa-solid fa-user-astronaut"></i>&nbsp;&nbsp;{{$username}}</a>
                <div class="dropdown-content">
                    <a href="#">Ajustes</a>
                    <a href="{{ route('signout') }}"><i class="fa-solid fa-power-off"></i> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </nav>
   

    <div class="container">


<h2>LISTADO DE CAMPAÑAS <button id="add" class="button icono" title="Añadir Campaña"> <i class="fa-solid fa-plus" style="font-size:25px;"></i></button>
</h2>

        <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($campanas as $campana)
                <tr data-id="{{ $campana->id }}">
                    <td>{{ $campana->id }}</td>
                    <td class="nombre">
                            <span class="nombre-campana">{{ $campana->nombre }}</span>
                            <form class="form-editar" style="display: none;" action="{{ route('guardar.editar.campana',$campana->id)}}" method="POST">
                                @csrf
                                <input type="text" name="nombre" value="{{ $campana->nombre }}" required><br>
                                <button type="submit" class="edit"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>
                                <button type="button" class="cancelar edit"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                            </form>
                        </td>
                        
                        <td class="acciones">
                            <button type="button" class="editar icono" title="Editar Campaña"><i class="fa-solid fa-pen-to-square"></i></button>
                            @if(Auth::user()->rol == "admin")
                            |&nbsp;
                            <form action="/campanasdel/{{ $campana->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="icono borrar" title="Eliminar Campaña"><i class="fa-solid fa-trash"></i></button>
                            </form>
                            @endif
                        </td>

                      
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        @if ($campanas->isEmpty())
            <p class="notickets">No hay campañas</p>
        @endif
    </div>
<div id="modal-asignar" style="display: none;">
    <div class="modal-content">

        <form id="form-add-campana" method="POST" action="{{ route('guardar.add.campaign') }}">
            @csrf
            <label for="campana-select">Campaña:</label>
            <input type="text" name="nombre">
            <button type="submit">Añadir Campaña</button>
            <button type="button" id="cancelar-modal">Cancelar</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('add').addEventListener('click', function() {
        document.getElementById('modal-asignar').style.display = 'flex';
    });

    document.getElementById('cancelar-modal').addEventListener('click', function() {
        document.getElementById('modal-asignar').style.display = 'none';
    });
</script>

    <script>

        


        // Seleccionar todos los botones de editar
        document.querySelectorAll('.editar').forEach(function(button) {
            button.addEventListener('click', function() {
                // Seleccionar la fila en la que se hizo clic
                const row = button.closest('tr');
                const nombreCampo = row.querySelector('.nombre-campana');
                const formEditar = row.querySelector('.form-editar');

                // Ocultar el nombre y mostrar el formulario
                nombreCampo.style.display = 'none';
                formEditar.style.display = 'inline-block';
            });
        });

        // Cancelar edición y restaurar el nombre original
        document.querySelectorAll('.cancelar').forEach(function(button) {
            button.addEventListener('click', function() {
                const formEditar = button.closest('.form-editar');
                const nombreCampo = formEditar.previousElementSibling;

                // Mostrar el nombre y ocultar el formulario
                nombreCampo.style.display = 'inline';
                formEditar.style.display = 'none';
            });
        });
    </script>
 <style>
        body {
            font-family: "Segoe UI Light", Arial, sans-serif;
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
            color: #f7a731;
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
            width: 50%; 
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

        tbody tr {
            background-color: #f9f9f9; 
            cursor: pointer; 
        }

        tbody tr:hover {
            background-color: #f1f1f1;
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
        .sinasignar{
           border:none;
           padding:7px;
           border-radius:5px;
         cursor:pointer
        }
        .sinasignar:hover{
            background-color: white;
        }

        .notickets{
            text-align:center;
        }

    
        .acciones {
            align-items: center; 
        }

        .icono {
            color: #047b8d;
            font-size: 15px; 
            text-decoration: none; 
            transition: color 0.3s ease; 
            border:none;
            background-color:transparent;
        }

        .icono:hover {
            color: #f7a731; 
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
            background-color: #047b8d;
            color: #ffffff;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #035d6b;
        }

        .modal-content button[type="button"] {
            background-color: #e0e0e0;
            color: #333;
        }

        .modal-content button[type="button"]:hover {
            background-color: #cccccc; 
        }
        input{            
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
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

   /* Filter styles */
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
           width: 120px;
        }

        .filter-container button[type="submit"] {
            background-color: #047b8d;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .filter-container button[type="submit"]:hover {
            background-color: #035d6b;
        }

        .filter-container a {
            text-decoration: none;
            color: #047b8d;
            padding: 10px;
            font-size: 14px;
            cursor: pointer;
        }
        h2{
            text-align:center
        }
        .edit{
            background-color:transparent;
            border:2px solid  #047b8d;
            padding:3px;
            border-radius:3px;
            color : #047b8d;
            cursor:pointer;
            margin-top:4px;
        }
        .edit:hover{
            background-color: #047b8d;
            color:white;
        }
    </style>
</html>
