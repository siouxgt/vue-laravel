<table>
	<thead>
		<tr>
			<th colspan="9" align="center">DESGLOSE DE INCIDENCIA</th>
		</tr>
        <tr>
            <th colspan="9" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
		<tr>
			<th colspan="9" align="center">REPORTE DE SOLICITUD DE PRÓRROGA</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="6">{{ $reporte->urg->nombre }}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="6">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID DE PRORROGA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">RFC PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID ORDEN DE COMPRA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ESTATUS</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">MOTIVO DE LA SOLICITUD</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE SOLICITUD DE PRÓRROGA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">JUSTIFICACIÓN DE LA SOLICITUD</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">DÍAS DE LA SOLICITUD DE PRÓRROGA</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->id_prorroga }}</td>
            <td>{{ $value->proveedor }}</td>
            <td>{{ $value->rfc }}</td>
            <td>{{ $value->orden_compra }}</td>
            <td>{{ $value->estatus }}</td>
            <td>{{ $value->descripcion }}</td>
            <td>{{ $value->fecha_solicitud }}</td>
            <td>{{ $value->justificacion }}</td>
            <td>{{ $value->dias_solicitados }}</td>
		</tr>
		@endforeach
	</tbody>
</table>