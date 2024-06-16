<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Site;
use App\Models\User; // Add this line to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Add this line to import the Carbon class
use Ramsey\Uuid\Uuid;

class ReservasController extends Controller
{
    public function index()
    {
        Carbon::setLocale('es');
        $ahora = Carbon::now();
        $reservas = Reserva::where('start_time', '>', $ahora)->orWhere('end_time', '>', $ahora)
            ->orWhere(function ($query) use ($ahora) {
                $query->where('start_time', '<', $ahora)
                    ->where('end_time', '>', $ahora);
            })->orderBy('start_time')->get();
        // ...
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        foreach ($reservas as $reserva) {
            $date = Carbon::parse($reserva->start_time);
            $reserva->start_time = $date->format('d/m/Y H:i');

            $date = Carbon::parse($reserva->end_time);
            $reserva->end_time = $date->format('d/m/Y H:i');

            $reserva->usuario = User::find($reserva->user_id);
            // Asegúrate de que `start_time` esté en el formato correcto.
            $fecha = Carbon::createFromFormat('d/m/Y H:i', $reserva->start_time);

            // Suponiendo que $meses es una matriz con los nombres de los meses en español.
            $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

            $mes = substr($meses[intval($fecha->format('m')) - 1], 0, 3);
            $reserva->mes = $mes;
            $reserva->dia = $fecha->format('j'); // Día sin el 0 inicial
            $reserva->hora = $fecha->format('H:i'); // Hora y minutos
            if ($reserva->user_id == Auth::id() || Auth::user()->role_id == 1) {
                $reserva->borrable = true;
            } else {
                $reserva->borrable = false;
            }
        }
        $errors = new \Illuminate\Support\MessageBag();
        if ($reservas == null || count($reservas) == 0) {
            $errors->add('msg', 'No se encontraron reservas para mostrar.');
            return view('reservas.index', compact('reservas', 'errors'));
        } else {
            return view('reservas.index', compact('reservas'));
        }
    }

    public function create()
    {
        $userId = Auth::id();
        return view('reservas.create', compact('userId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'user_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $messages = [
            'name.required' => 'El título es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'start_time.date' => 'La hora de inicio debe ser una fecha válida.',
            'end_time.required' => 'La hora de finalización es obligatoria.',
            'end_time.date' => 'La hora de finalización debe ser una fecha válida.',
            'end_time.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ];

        // Validar solapamiento de reservas
        $overlappingReservations = Reserva::where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_time', '<', $request->start_time)
                        ->where('end_time', '>', $request->end_time);
                });
        })->exists();

        if ($overlappingReservations) {
            return back()->withErrors(['error' => 'Ya hay una reserva en esas fechas'])->withInput();
        }

        Reserva::create([
            'uuid' => (string) Uuid::uuid4(),
            'name' => $request->name,
            'user_id' => $request->user_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva creada con éxito.');
    }

    public function destroy(string $id)
    {
        $reserva = Reserva::find($id);
        $reserva->delete();
        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada con éxito');
    }

    public function edit($id)
    {
        $userId = Auth::id();
        $reserva = Reserva::find($id);
        $reserva->usuario = User::find($reserva->user_id);
        return view('reservas.edit', compact('reserva', 'userId'));
    }

    public function update(Request $request, string $uuid)
    {
        $request->validate([
            'name' => 'required|max:255',
            'user_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $messages = [
            'name.required' => 'El título es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'start_time.date' => 'La hora de inicio debe ser una fecha válida.',
            'end_time.required' => 'La hora de finalización es obligatoria.',
            'end_time.date' => 'La hora de finalización debe ser una fecha válida.',
            'end_time.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ];

        // Validar solapamiento de reservas
        $overlappingReservations = Reserva::where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_time', '<', $request->start_time)
                        ->where('end_time', '>', $request->end_time);
                });
        })->where('uuid', '<>', $request->uuid)->exists();

        if ($overlappingReservations) {
            return back()->withErrors(['error' => 'Ya hay una reserva en esas fechas'])->withInput();
        }
        $reserva = Reserva::where('uuid', $uuid)->first();
        $reserva->update([
            'uuid' => (string) Uuid::uuid4(),
            'name' => $request->name,
            'user_id' => $request->user_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada con éxito.');
    }
}
