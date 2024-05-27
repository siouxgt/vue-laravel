<table>
    <thead>
        <tr>
            <th colspan="18" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
        <tr>
            <td colspan="18" align="center">REPORTE DE ORDEN DE COMPRA COMPLETO</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="17" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="17">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID ORDEN DE COMPRA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID REQUISICIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">URG (UNIDAD RESPONSABLE DE GASTO)</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CLAVE CABMS CDMX</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">DESCRIPCIÓN DEL BIEN </td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">UNIDAD DE MEDIDA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PRECIO UNITARIO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CANTIDAD</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">MONTO TOTAL DE LA ORDEN DE COMPRA CON IVA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">MONTO TOTAL DE LA ORDEN DE COMPRA SIN IVA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CAPÍTULO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">RFC PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">TIPO DE CONTRATO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">NOMBRE CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE ORDEN DE COMPRA</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
            <tr>
                <td>{{ $dato->orden_compra }}</td>
                <td>{{ $dato->requisicion }}</td>
                <td height="100">{{ $dato->urg }}</td>
                <td>{{ $dato->cabms }}</td>
                <td>{{ $dato->descripcion_producto }}</td>
                <td>{{ $dato->unidad_medida }}</td>
                <td>${{ number_format($dato->precio_unitario, 2) }}</td>
                <td>{{ $dato->cantidad }}</td>
                <td>${{ number_format($dato->monto_total_iva, 2) }}</td>
                <td>${{ number_format($dato->monto_total_sin_iva, 2) }}</td>
                <td>{{ $dato->capitulo }}</td>
                <td>{{ $dato->estatus }}</td>
                <td>{{ $dato->nombre }}</td>
                <td>{{ $dato->rfc }}</td>
                <td>{{ $dato->tipo_contrato }}</td>
                <td>{{ $dato->id_contrato }}</td>
                <td>{{ $dato->nombre_contrato }}</td>
                <td>{{ $dato->fecha_creacion }}</td>
            </tr>
        @endforeach        
    </tbody>
</table>
