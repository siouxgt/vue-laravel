<table>
    <thead>
        <tr>
            <th colspan="10" align="center">SISTEMA DE CONTRATO MARCO - DESGLOSE DE INCIDENCIA</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="10" align="center">INFORME DE INCIDENCIAS Y REPORTES DE LA URG, DURANTE EL PROCESO DEL FLUJO DE COMPRA DE CONTRATO MARCO</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="9" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="9">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID DE IDENTIFICACIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">URG</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">MOTIVO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">DESCRIPCIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CLAVE DE LA URG</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE LA INCIDENCIA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">TIPO DE LLAMADA DE ATENCIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ETAPA</td>
        </tr>

        @for($i = 0; $i < count($datos); $i++)
            <tr>
                <td>{{ $datos[$i]->id_identificacion }}</td>
                <td height="100">{{ $datos[$i]->urg }}</td>
                <td>{{ $datos[$i]->nombre_cm }}</td>
                <td>{{ $datos[$i]->numero_cm }}</td>
                <td>{{ $datos[$i]->motivo }}</td>
                <td>{{ $datos[$i]->descripcion }}</td>
                <td>{{ $datos[$i]->ccg }}</td>    
                <td>{{ $datos[$i]->fecha_incidencia }}</td>    
                <td>INCIDENCIA</td>    
                <td>{{ $datos[$i]->etapa }}</td>    
            </tr>
        @endfor
    </tbody>
</table>
