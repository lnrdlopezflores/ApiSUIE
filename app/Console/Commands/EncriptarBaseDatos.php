<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api\Docente;
use App\Models\Api\Alumno;
use Illuminate\Support\Facades\Crypt;

class EncriptarBaseDatos extends Command
{
    protected $signature = 'db:encrypt-legacy';
    protected $description = 'Cifra los datos en texto plano existentes en la base de datos';

    public function handle()
    {
        $this->info('Iniciando cifrado de datos planos...');

        // 1. Cifrar Docentes
        // Desactivamos temporalmente el cast automático para leer el texto plano puro
        config(['model.docente.casts' => []]); 
        
        $docentes = \DB::table('docentes')->get();
        foreach ($docentes as $docente) {
            // Validamos si ya está cifrado (las cadenas cifradas por Laravel suelen ser muy largas)
            if (strlen($docente->nombre) < 60) {
                \DB::table('docentes')->where('id', $docente->id)->update([
                    'nombre' => Crypt::encryptString($docente->nombre),
                    'apellido_paterno' => Crypt::encryptString($docente->apellido_paterno),
                    'apellido_materno' => $docente->apellido_materno ? Crypt::encryptString($docente->apellido_materno) : null,
                    'telefono' => $docente->telefono ? Crypt::encryptString($docente->telefono) : null,
                    'correo' => $docente->correo ? Crypt::encryptString($docente->correo) : null,
                ]);
            }
        }
        $this->info('¡Docentes cifrados con éxito!');

        // 2. Cifrar Alumnos
        $alumnos = \DB::table('alumnos')->get();
        foreach ($alumnos as $alumno) {
            if (strlen($alumno->nombre) < 60) {
                \DB::table('alumnos')->where('id', $alumno->id)->update([
                    'nombre' => Crypt::encryptString($alumno->nombre),
                    'apellido_paterno' => Crypt::encryptString($alumno->apellido_paterno),
                    'apellido_materno' => $alumno->apellido_materno ? Crypt::encryptString($alumno->apellido_materno) : null,
                    'nombre_tutor' => Crypt::encryptString($alumno->nombre_tutor),
                    'telefono_tutor' => Crypt::encryptString($alumno->telefono_tutor),
                ]);
            }
        }
        $this->info('¡Alumnos cifrados con éxito!');
    }
}
