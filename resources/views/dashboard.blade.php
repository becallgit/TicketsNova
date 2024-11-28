<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKETING</title>
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



    <div class="equipos-container {{ $userRole != 'admin' || (isset($ticketsPorEquipo) && $ticketsPorEquipo->count() == 1) ? 'centrado' : '' }}">
    @if ($userRole == 'admin')
        @foreach ($ticketsPorEquipo as $equipo)
            <div class="equipo">
                <div class="team-title">{{ $equipo->nombre }}</div>
                <div class="tarjetas-container">
                    <div class="tarjeta">
                        <div class="texto">Solicitudes Abiertas</div>
                        <div class="numero">{{ $equipo->tickets_abiertos }}</div>
                    </div>
                    <div class="tarjeta">
                        <div class="texto">Solicitudes Sin Asignar</div>
                        <div class="numero">{{ $equipo->tickets_sin_asignar }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="equipo">
            <div class="team-title">{{ $teamName }}</div>
            <div class="tarjetas-container">
                <div class="tarjeta">
                    <div class="texto">Solicitudes Abiertas</div>
                    <div class="numero">{{ $ticketsAbiertos }}</div>
                </div>
                <div class="tarjeta">
                    <div class="texto">Solicitudes Sin Asignar</div>
                    <div class="numero">{{ $ticketsSinAsignar }}</div>
                </div>
            </div>
        </div>
    @endif
</div>


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

      

        .equipos-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 50px; 
        max-width: 800px;
        width: 100%;
        margin: 0 auto; 
        margin-top:30px;
        justify-content: center; 
    }

    .equipo {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%; 
        max-width: 460px; 
        margin: 0 auto; 
    }

  
    .team-title {
        font-size: 20px;
        font-weight: bold;
        color: #555;
        margin-bottom: 10px;
        text-align: center;
    }

  
    .tarjetas-container {
        display: flex;
        gap: 15px;
        justify-content: center; 
    }

   
    .tarjeta {
        background-color: #fff;
        flex: 1;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        max-width: 150px;
    }

    .tarjeta:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

  
    .texto {
        font-size: 16px;
        color: #333;
    }

    .numero {
        font-size: 20px;
        font-weight: bold;
        color: #8598b1;
        background-color: #e6f2ff;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .equipos-container.centrado {
    display: flex;
    justify-content: center;
    align-items: center;
  
    gap: 30px; 
}

 

    </style>
</body>
</html>
