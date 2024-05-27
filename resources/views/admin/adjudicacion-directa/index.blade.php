@extends('layouts.admin')

	@section('content')
		<div class="container">
				<ol>
					@foreach ($adjudicaciones as $adjudicacion)
						<li>
						 <a class="btn btn-info btn-rounded" href="{{ route('adjudicacion.edit', ['adjudicacion' => $adjudicacion->id_e]) }}">{{ $adjudicacion->id_e }}</a> 
						</li>
					@endforeach
				</ol>
		</div>
	@endsection