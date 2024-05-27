@extends('layouts.admin')

	@section('content')
		<div class="container">
				<ol>
					@foreach ($licitaciones as $licitacion)
						<li>
						 <a class="btn btn-info btn-rounded" href="{{ route('licitacion.edit', ['licitacion' => $licitacion->id_e]) }}">{{ $licitacion->id_e }}</a> 
						</li>
					@endforeach
				</ol>
		</div>
	@endsection