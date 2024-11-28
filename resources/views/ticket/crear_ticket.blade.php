<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREAR TICKET</title>
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

<form action="{{ route('guardar.ticket') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        <div class="form-section">
            <h3>Detalles</h3>
            <div class="form-group">
                <label for="team_id">Para</label>
                <select id="team_id" name="team_id" required> 
                    <option value="" disabled selected>Para quien es la solicitud...</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">
                            {{ $team->nombre }} 
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nombre_cliente">Nombre Cliente</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente" placeholder="Ingrese el nombre del cliente" >

            </div>
            <div class="form-group">
                <label for="telefono">Telefono de contacto</label>
                <input type="text" id="telefono" name="telefono" placeholder="Ingrese el telefono de contacto" >

            </div>
            <div class="form-group">
                <label for="matricula">Matricula</label>
                <input type="text" id="matricula" name="matricula" placeholder="Ingrese la matricula" >

            </div>
            <div class="form-group">
                <label for="bastidor">Bastidor</label>
                <input type="text" id="bastidor" name="bastidor" placeholder="Ingrese el bastidor" >

            </div>
            <div class="form-group">
                <label for="observaciones_ticket">Observaciones</label>
                <textarea name="observaciones_ticket" id="observaciones_ticket"></textarea>
            </div>
        </div>


        

    
        <div class="form-group">
            <button type="submit" class="submit-btn">Crear Ticket</button>
        </div>
    </div>
    </form>

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

        /* Formulario */
        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #8598b1;
            padding-bottom: 5px;
        }

        .form-group {
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center; /* Centra verticalmente */
    margin-bottom: 15px;
}

.form-group .submit-btn {
    background-color: #8598b1;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

        .form-group label {
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group select,
        .form-group input,
        .form-group textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
        }

        .form-group textarea {
            min-height: 100px;
        }

     

        .form-group .submit-btn:hover {
            background-color: #b4c3d6;
        }

        @media (min-width: 600px) {
            .form-group {
                flex-direction: row;
                align-items: center;
                gap: 15px;
            }

            .form-group label {
                width: 150px;
                text-align: right;
            }

            .form-group select,
            .form-group input,
            .form-group textarea {
                flex: 1;
            }
        }
    </style>
</body>
</html>
