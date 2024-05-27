<table>
    <thead>
        <tr>
            <th colspan="20" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
        <tr>
            <td colspan="20" align="center">REPORTE DE ORDEN DE COMPRA COMPLETO POR URG</td>
        </tr>
        <tr>
            <td><b>UNIDAD QUE GENERÓ EL REPORTE:</b></td>
            <td colspan="19" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>UNIDAD COMPRADORA:</b></td>
            <td colspan="19">
                @if (count($datos) != 0)
                    {{ $datos[0]->urg }}
                @else
                    {{ 'SIN DATOS' }}
                @endif
            </td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="19">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
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
            <td style="background-color: #235b4e; color: #ffffff;" width="20">DIRECTOR GENERAL DE ADMINISTRACIÓN U HOMÓLOGO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">RESPONSABLE DE GENERAR LA ORDEN DE COMPRA</td>
        </tr>
    </thead>
    <tbody>
        @php
            $totalOc = $totalEstimado = 0;
            $totalProveedores = [];
        @endphp
        @foreach ($datos as $key => $dato)
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
                <td>{{ $dato->director }}</td>
                <td>{{ $dato->responsable }}</td>
            </tr>
            @php
                $totalOc = $key + 1;
                $totalEstimado += $dato->monto_total_iva;
                $totalProveedores[$key] = $dato->rfc;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr></tr>
        <tr>
            <td>Resumen:</td>
        </tr>
        <tr>
            <td>Total de OC</td>
            <td>{{ $totalOc }}</td>
        </tr>
        <tr>
            <td>Valor total estimado</td>
            <td>${{ number_format($totalEstimado, 2) }}</td>
        </tr>
        <tr>
            <td>TOTAL DE PROVEEDORES</td>
            <td>{{ count(array_count_values($totalProveedores)) }}</td>
        </tr>
    </tfoot>
</table>
