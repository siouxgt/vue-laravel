<table>
	<thead>
		<tr>
			<th colspan="18" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="18" align="center">REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="15">{{ $reporte->urg->nombre }}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="15">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID PARTIDA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CLAVE CABMS CDMX</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CAPÍTULO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE PUBLICACIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VALIDACIÓN ECONÓMICA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VALIDACIÓN TÉCNICA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VALIDACION ADMINISTRATIVA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">NOMBRE CONTRATO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ESTATUS DEL PRODUCTO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PRECIO UNITARIO SIN IVA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PRECIO UNITARIO CON IVA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">UNIDAD DE MEDIDA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">DESCRIPCIÓN DEL BIEN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE MODIFICACIÓN DE LA FECHA DE PRODUCTO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">NO. FICHA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VERSIÓN</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->partida }}</td>
            <td>{{ $value->cabms }}</td>
            <td>{{ $value->capitulo }}</td>
            <td>{{ $value->fecha_publicacion }}</td>
            <td>{{ $value->validacion_economica }}</td>
            <td>{{ $value->validacion_tecnica }}</td>
            <td>{{ $value->validacion_administrativa }}</td>
            <td>{{ $value->nombre_cm }}</td>
            <td>{{ $value->numero_cm }}</td>
            <td>{{ $value->estatus }}</td>
            <td>{{ $value->proveedor }}</td>
            <td>${{ number_format($value->precio_unitario,2) }}</td>
            <td>${{ number_format($value->precio_iva,2) }}</td>
            <td>{{ $value->medida }}</td>
            <td>{{ $value->descripcion_producto }}</td>
            <td>{{ $value->fecha_update }}</td>
            <td>{{ $value->numero_ficha }}</td>
            <td>{{ $value->version }}</td>
		</tr>
		@endforeach
	</tbody>
</table>