<table>
	<thead>
		<tr>
			<th colspan="8" align="center">SISTEMA DE CONTRATRO MARCO</th>
		</tr>
		<tr>
			<th colspan="8" align="center">REPORTE DE ADHESIÓN DE PROVEEDOR EN CONTRATO MARCO</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="5">{{ $reporte->urg->nombre}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="5">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
			<th style="background-color: #235b4e; color: #ffffff; width:100px">ID CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">NOMBRE DE CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">OBJETO DE CONTRATACIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">RFC PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">FECHA DE ADHESIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">FECHA DE VIGENCIA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px">ESTATUS</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->numero_cm }}</td>
            <td>{{ $value->nombre_cm }}</td>
            <td>{{ $value->objetivo }}</td>
            <td>{{ $value->proveedor }}</td>
            <td>{{ $value->rfc }}</td>
            <td>{{ $value->fecha_adhesion }}</td>
            <td>{{ $value->fecha_fin }}</td>
            <td>{{ $value->estatus }}</td>
		</tr>
		@endforeach
	</tbody>
</table>