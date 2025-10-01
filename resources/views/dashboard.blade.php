
@extends('layouts.app')

@section('title', 'INICIO')

@section('content')
 


    <div class="equipos-container {{ $userRole != 'admin' || (isset($ticketsPorEquipo) && $ticketsPorEquipo->count() == 1) ? 'centrado' : '' }}">
  @if (Auth::user()->rol == "admin" && Auth::user()->username != 'angel.lopez' && Auth::user()->username != 'generico')
    @foreach ($ticketsPorEquipo as $equipo)
        @if ($equipo->nombre == 'Nova') 
            <div class="equipo nova">
                <div class="team-title">{{ $equipo->nombre }} </div>
                

                <div class="tarjetas-container">
                    <div class="tarjeta">
                        <div class="texto">Solicitudes Abiertas</div>
                        <div class="numero">{{ $abiertos}}</div>
                    </div>
                    <div class="tarjeta">
                        <div class="texto">Solicitudes para Tatiana</div>
                        <div class="numero">{{ $paraTatiana }}</div>
                    </div>
                    <div class="tarjeta">
                        <div class="texto">Solicitudes para Ignacio</div>
                        <div class="numero">{{ $paraIgnacio }}</div>
                    </div>
                    <div class="tarjeta">
                        <div class="texto">Solicitudes para Inma</div>
                        <div class="numero">{{ $paraInma}}</div>
                    </div>
                 
                </div>
            </div>
        @endif
    @endforeach
@endif
  
  
    @if ($userRole == 'admin')
        @foreach ($ticketsPorEquipo as $equipo)
        @if ($equipo->nombre != 'Nova') 
        <a  class="direct" href="{{ route('ver.accesoDirecto',$equipo->id) }}">
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
            </a>
            @endif
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
        .exp{
            text-decoration:none;
            border:2px solid #8598b1;
            background-color:#8598b1;
            border-radius:5px;
            padding:6px;
            color:white;

            
        }
        .exp:hover{
                   background-color:transparent;
                   color:#8598b1;
                   font-weight:bold;
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
        cursor:pointer;

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

    .equipo:hover {
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
.equipo.nova {
    grid-column: span 2; /* ocupa las 2 columnas en grid */
    background-color:rgb(248, 248, 248);
    border: 2px solid rgb(243, 244, 245);
    max-width: none;
    width: 100%;
}

.equipo.nova .tarjetas-container {
    flex-wrap: wrap;
    justify-content: space-evenly;
}

.equipo.nova .tarjeta {
    max-width: 180px;
}

    .equipos-container.centrado {
    display: flex;
    justify-content: center;
    align-items: center;
  
    gap: 30px; 
}
.direct{
    text-decoration:none
}
 

    </style>
@endsection