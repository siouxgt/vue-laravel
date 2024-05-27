<table>
    <thead>
        <tr>
            <th colspan="10" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="10" align="center">REPORTE DE ADHESIÓN DE URG EN CONTRATO MARCO</td>
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
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID ADHESIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="40">TRIMESTRE DE REGISTRO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">NOMBRE DE CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">OBJETO DE CONTRATACIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">CENTRO GESTOR ADHERIDO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">CLAVE DEL CENTRO GESTOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE ADHESIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE VIGENCIA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS</td>
        </tr>

        @for($i = 0; $i < count($datos); $i++)
            <tr>
                <td>{{ $datos[$i]->numero_archivo_adhesion }}</td>
                <td height="100">{{ $datos[$i]->fecha_registro }}</td>
                <td>{{ $datos[$i]->numero_cm }}</td>
                <td>{{ $datos[$i]->nombre_cm }}</td>
                <td>{{ $datos[$i]->objetivo }}</td>
                <td>{{ $datos[$i]->nombre }}</td>    
                <td>{{ $datos[$i]->ccg }}</td>                    
                <td>{{ $datos[$i]->fecha_firma }}</td>
                <td>{{ $datos[$i]->f_fin }}</td>
                <td>{{ $datos[$i]->estatus }}</td>
            </tr>
        @endfor
    </tbody>
</table>
