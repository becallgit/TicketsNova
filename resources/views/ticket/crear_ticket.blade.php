
@extends('layouts.app')

@section('title', 'CREAR TICKET')

@section('content')
 


<form action="{{ route('guardar.ticket') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
        <div class="form-section">
            <h3>Detalles</h3>
    
            <div class="form-group">
                <label for="tipo_solicitud">Tipo de solicitud</label>
                <select name="tipo_solicitud" id="tipo_solicitud" required>
                    <option value="" disabled selected>Selecciona...</option>
                    <option value="Incidencia">Incidencia</option>
                    <option value="Mejora">Mejora</option>
                    <option value="Consulta">Consulta</option>
                </select>
            </div>
         <div class="form-group">
            <label for="cliente">Cliente</label>
            <select id="cliente" name="cliente">
                <option value="" disabled selected>Selecciona...</option>
                @if (Auth::user()->team_id == 1)
                     <option value="Dismoauto" selected>Dismoauto</option>
                @endif
                  @if (Auth::user()->team_id == 3)
                     <option value="Riscal" selected>Riscal</option>
                @endif
                 @if (Auth::user()->team_id == 2)
                   <option value="Vera Import" selected>Vera Import</option>
                @endif
                 @if (Auth::user()->team_id == 5)
                   <option value="Aldauto" selected>Aldauto</option>
                @endif
                 @if (Auth::user()->rol== "admin")
                  <option value="Dismoauto">Dismoauto</option>
                   <option value="Riscal">Riscal</option>
                    <option value="Vera Import">Vera Import</option>
                    <option value="Aldauto">Aldauto</option>
                @endif
                </select>
        </div>

        <div class="form-group">
            <label for="marca">Marca</label>
            <select id="marca" name="marca">
                <option value="" disabled selected>Selecciona cliente primero</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sede">Sede</label>
            <select id="sede" name="sede" required>
                <option value="" disabled selected>Selecciona cliente primero</option>
            </select>
        </div>

       
            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones"></textarea>
            </div>
        </div>


        

    
        <div class="form-group">
            <button type="submit" class="submit-btn">Crear Ticket</button>
        </div>
    </div>
    </form>
<script>
  const marcaOptions = {
    "Dismoauto": ["Skoda"],
    "Riscal": ["Audi", "Volkswagen", "Otras marcas"],
    "Vera Import": ["Volkswagen", "Audi", "Seat", "Cupra", "Skoda", "Comerciales"],
    "Aldauto": ["Skoda"]
};

const sedeOptions = {
    "Dismoauto": ["Málaga"],
    "Riscal": ["Alcorcón"],
    "Vera Import": ["El Ejido", "Vera", "Huércal de Almería", "Albox"],
    "Aldauto": ["Alcobendas","Colmenar Viejo"],
};

const clienteSelect = document.getElementById("cliente");
const marcaSelect = document.getElementById("marca");
const sedeSelect = document.getElementById("sede");

clienteSelect.addEventListener("change", function () {
    const selectedCliente = this.value;

    // Actualizar marcas
    marcaSelect.innerHTML = '<option value="" disabled>Selecciona...</option>';
    if (marcaOptions[selectedCliente]) {
        marcaOptions[selectedCliente].forEach(marca => {
            const option = document.createElement("option");
            option.value = marca;
            option.textContent = marca;
            marcaSelect.appendChild(option);
        });
    }

    // Si Aldauto, seleccionar Skoda por defecto en marca
    if (selectedCliente === "Aldauto") {
        marcaSelect.value = "Skoda";
    } else {
        // Deseleccionar para otros clientes (que quede en el placeholder)
        marcaSelect.selectedIndex = 0;
    }

    // Actualizar sedes dependiendo del cliente y marca
    actualizarSedes(selectedCliente, marcaSelect.value);
});

marcaSelect.addEventListener("change", function () {
    const selectedCliente = clienteSelect.value;
    const selectedMarca = this.value;
    actualizarSedes(selectedCliente, selectedMarca);
});

function actualizarSedes(cliente, marca) {
    sedeSelect.innerHTML = '<option value="" disabled selected>Selecciona...</option>';

    if (cliente === "Vera Import") {
        let sedes = [];
        if (["Volkswagen", "Comerciales", "Audi"].includes(marca)) {
            sedes = ["El Ejido", "Vera", "Huércal de Almería"];
        } else if (["Seat", "Cupra"].includes(marca)) {
            sedes = ["Vera", "Albox"];
        } else if (marca === "Skoda") {
            sedes = ["Vera"];
        }
        sedes.forEach(sede => {
            const option = document.createElement("option");
            option.value = sede;
            option.textContent = sede;
            sedeSelect.appendChild(option);
        });
    } else if (cliente === "Dismoauto" && marca === "Skoda") {
        const option = document.createElement("option");
        option.value = "Málaga";
        option.textContent = "Málaga";
        sedeSelect.appendChild(option);
    } else if (cliente === "Riscal" && ["Audi", "Volkswagen", "Otras marcas"].includes(marca)) {
        const option = document.createElement("option");
        option.value = "Alcorcón";
        option.textContent = "Alcorcón";
        sedeSelect.appendChild(option);
    } else if (cliente === "Aldauto") {
      
        sedeOptions["Aldauto"].forEach(sede => {
            const option = document.createElement("option");
            option.value = sede;
            option.textContent = sede;
            sedeSelect.appendChild(option);
        });
    } else {
        sedeSelect.innerHTML = '<option value="" disabled selected>No hay sedes disponibles</option>';
    }
}

window.addEventListener("DOMContentLoaded", function () {
    const selectedCliente = clienteSelect.value;
    if (selectedCliente) {
        clienteSelect.dispatchEvent(new Event("change"));
    }
});

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
@endsection