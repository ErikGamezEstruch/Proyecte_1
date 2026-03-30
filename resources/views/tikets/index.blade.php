<h1>Tickets del projecte: {{ $projecte->id }}</h1>

<a href="{{ route('projectes.tickets.create', $projecte) }}">Crear ticket</a>

<ul>
    @foreach ($tickets as $ticket)
        <li>
            <a href="{{ route('projectes.tickets.show', [$projecte, $ticket]) }}">
                {{ $ticket->titol }}
            </a>
        </li>
    @endforeach
</ul>
