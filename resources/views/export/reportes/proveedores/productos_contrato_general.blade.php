<table>
    <thead>
        <tr>
            <th colspan="14" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="14" align="center">REPORTE DE PRODUCTOS POR CONTRATO MARCO GENERAL</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="13" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="13">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID PARTIDA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="40">CLAVE CAMBSCDMX</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CAPÍTULO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PRODUCTO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE PUBLICACIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">VALIDACIÓN ECONÓMICA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">VALIDACIÓN TÉCNICA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">VALIDACIÓN ADMINISTRATIVA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CONTRATO MARCO(NOMBRE)</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS DEL PRODUCTO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">NO. FICHA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">VERSIÓN</td>
        </tr>

        @for($i = 0; $i < count($datos); $i++)
            <tr>
                <td>{{ $datos[$i]->partida }}</td>
                <td height="100">{{ $datos[$i]->cabms }}</td>
                <td>{{ $datos[$i]->capitulo }}</td>
                <td>{{ $datos[$i]->nombre_producto }}</td>
                <td>{{ $datos[$i]->fecha_publicacion }}</td>
                <td>{{ $datos[$i]->validacion_precio }}</td>
                <td>{{ $datos[$i]->validacion_tecnica }}</td>    
                <td>{{ $datos[$i]->validacion_administracion }}</td>                    
                <td>{{ $datos[$i]->nombre_cm }}</td>
                <td>{{ $datos[$i]->numero_cm }}</td>
                <td>{{ $datos[$i]->estatus }}</td>
                <td>{{ $datos[$i]->nombre }}</td>
                <td>{{ $datos[$i]->numero_ficha }}</td>
                <td>{{ $datos[$i]->version }}</td>
            </tr>
        @endfor
    </tbody>
</table>
