@component('mail::message')
# Recordatorio: Último día para inscribirse al evento

Hola {{ $nombre }},

Te recordamos que hoy es el último día para inscribirte al evento:

**{{ $evento_nombre }}**

Fecha del evento: **{{ $fecha_evento }}**

@if(!empty($descripcion))
Descripción: {{ $descripcion }}
@endif

Quedan {{ $dias }} día(s) para el cierre de inscripciones.

@component('mail::button', ['url' => url('/')])
Ver evento
@endcomponent

¡No te lo pierdas!

Gracias,
{{ config('app.name') }}
@endcomponent
