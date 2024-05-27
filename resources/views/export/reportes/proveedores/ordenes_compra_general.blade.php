<table>
    <thead>
        <tr>
            <th colspan="9" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
        <tr>
            <td colspan="9" align="center">REPORTE DE ORDEN DE COMPRA GENERAL</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="8" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="8">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID ORDEN DE COMPRA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID REQUISICIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">URG (UNIDAD RESPONSABLE
                DE GASTO)</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">MONTO TOTAL DE LA ORDEN
                DE COMPRA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CAPÍTULO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">RFC PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">FECHA DE ORDEN DE COMPRA</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
            <tr>
                <td>{{ $dato->orden_compra }}</td>
                <td>{{ $dato->requisicion }}</td>
                <td height="100">{{ $dato->nombre_urg }}</td>
                <td>${{ number_format($dato->monto_total, 2) }}</td>
                <td>{{ $dato->capitulos }}</td>
                <td>{{ $dato->estatus }}</td>
                <td>{{ $dato->nombre_proveedor }}</td>
                <td>{{ $dato->rfc }}</td>
                <td>{{ $dato->fecha_oc }}</td>
            </tr>
        @endforeach        
    </tbody>
</table>
