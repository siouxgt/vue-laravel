@extends('layouts.admin')

	@section('content')
		<div class="container">
				<ol>
					@foreach ($invitaciones as $invitacion)
						<li>
						 <a class="btn btn-info btn-rounded" href="{{ route('invitacion.edit', ['invitacion' => $invitacion->id_e]) }}">{{ $invitacion->id_e }}</a> 
						</li>
					@endforeach
				</ol>
		</div>
	@endsection