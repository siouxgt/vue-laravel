<table>
    <thead>
        <tr>
            <th colspan="19" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="19" align="center">ANALÍTICO DE CONTRATOS MARCO COMPLETO</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="18" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="18">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">TRIMESTRE</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">OBJETO DEL CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">TIPO DE CONTRATACIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE CREACIÓN DEL CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="40">FECHA DE TÉRMINO DEL CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE MODIFICACIÓN DE CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">RESPONSABLE DEL ALTA DEL CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE INGRESO DE LA URG</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE INGRESO DEL PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CAPÍTULO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PARTIDA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">URG</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS URG</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">RFC PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">NOMBRE PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTADO DEL CONTRATO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID ORDEN DE COMPRA</td>
        </tr>

        @for ($i = 0; $i < count($datos); $i++)
            <tr>
                <td>{{ $datos[$i]->mes }}</td>
                <td>{{ $datos[$i]->numero_cm }}</td>
                <td>{{ $datos[$i]->objetivo }}</td>
                <td>{{ $datos[$i]->tipo_contratacion }}</td>
                <td>{{ $datos[$i]->fecha_creacion }}</td>
                <td height="80">{{ $datos[$i]->f_fin }}</td>
                <td>{{ $datos[$i]->fecha_modificacion }}</td>
                <td>{{ $datos[$i]->nombre_responsable_alta }}</td>
                <td>{{ $datos[$i]->fecha_ingreso_urg }}</td>
                <td>{{ $datos[$i]->fecha_ingreso_proveedor }}</td>
                <td>{{ $datos[$i]->capitulo }}</td>
                <td>{{ $datos[$i]->partida }}</td>
                <td>{{ $datos[$i]->urg }}</td>
                <td>{{ $datos[$i]->estatus_urg }}</td>
                <td>{{ $datos[$i]->rfc }}</td>
                <td>{{ $datos[$i]->nombre_proveedor }}</td>
                <td>{{ $datos[$i]->estatus_proveedor }}</td>
                <td>{{ $datos[$i]->estatus_contrato }}</td>
                <td>{{ $datos[$i]->id_orden_compra }}</td>

            </tr>
        @endfor
    </tbody>
</table>
