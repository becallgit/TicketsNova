
@extends('layouts.app')

@section('title', 'editar')

@section('content')
 


    <form action="{{ route('guardar.editar', $ticket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-container">
            <h2>EDITAR TICKET Nª {{$ticket->id}}</h2>
        <div class="form-section">
            <h3>Detalles</h3>
            <div class="form-group">
                <label for="team_id">Para</label>
                <select id="team_id" name="team_id">
                    <option value="" disabled selected>Para que departamento es la solicitud...</option>
                    @foreach ($teams as $team)
                    <option value="{{ $team->id }}" {{ $team->id == $ticket->team_id ? 'selected' : '' }}>
                        {{ $team->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_user">Asignado a:</label>
                <input type="text" id="id_user" name="id_user" value="{{ $ticket->usuarioAsignado->username ?? 'No asignado' }}" readonly>
            </div>

            <div class="form-group">
                <label for="nombre_cliente">Nombre Cliente:</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente" value="{{ $ticket->nombre_cliente}}" readonly>
            </div>

            <div class="form-group">
                <label for="telefono">Telefono de contacto:</label>
                <input type="text" id="telefono" name="telefono" value="{{ $ticket->telefono}}" >
            </div>
            <div class="form-group">
                <label for="matricula">Matricula:</label>
                <input type="text" id="matricula" name="matricula" value="{{ $ticket->matricula }}">
            </div>

            <div class="form-group">
                <label for="bastidor">Bastidor:</label>
                <input type="text" id="bastidor" name="bastidor" value="{{ $ticket->bastidor }}">
            </div>
            <div class="form-group">
                <label for="observaciones_ticket">Observaciones:</label>
                <textarea name="observaciones_ticket" id="observaciones_ticket">{{ $ticket->observaciones_ticket }}</textarea>
            </div>


            <div class="form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    <option value="" label="Selecciona..."></option>
                    <option value="Abierto" {{ $ticket->estado == "Abierto" ? 'selected' : '' }}>Abierto</option>
                    <option value="En Curso" {{ $ticket->estado == "En Curso" ? 'selected' : '' }}>En Curso</option>
                    <option value="Cerrado" {{ $ticket->estado == "Cerrado" ? 'selected' : '' }}>Cerrado</option>
                </select>
            </div>
          
        </div>
    

    
        <div class="form-group">
            <button type="submit" class="submit-btn">EDITAR TICKET</button>
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
            flex-direction: column;
            margin-bottom: 15px;
        }
        #motivo_pausa_container{
            
            margin-left:2vw;
            margin-bottom: 15px;
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

        .form-group .submit-btn:hover {
            background-color: #b4c3d6;
        }
        h2{
            margin-top:-13px;
            text-align:center;
            margin-bottom:-30px;
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
        .delete-btn {
        color: red;
        margin-left: 10px;
        text-decoration: none;
        font-weight: bold;
    }

    .delete-btn:hover {
        color: darkred;
    }

    </style>
@endsection
