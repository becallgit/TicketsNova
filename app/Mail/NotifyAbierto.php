<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;


class NotifyAbierto extends Mailable
{

    public $enlace;


    public function __construct($enlace)
    {
       
        $this->enlace = $enlace;
    }

    // Funcion para generar los correos
    public function build(){
    
        return $this->subject('Se ha abierto un nuevo ticket') // Introducimos el asunto del correo
                    ->view('emails.nuevoTicket');
                 
    }
}
