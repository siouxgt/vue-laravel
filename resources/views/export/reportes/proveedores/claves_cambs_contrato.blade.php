<table>
    <thead>
        <tr>
            <th colspan="6" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" align="center">REPORTE CLAVES CAMBS POR CONTRATO MARCO</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="5" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="5">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID PARTIDA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CAPÍTULO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CABMS CDMX</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">NOMBRE CONTRATO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="40">DESCRIPCIÓN DEL BIEN
            </td>
        </tr>

        @for ($i = 0; $i < count($datos); $i++)
            <tr>
                <td>{{ $datos[$i]->partida }}</td>
                <td>{{ $datos[$i]->capitulo }}</td>
                <td>{{ $datos[$i]->cabms }}</td>
                <td>{{ $datos[$i]->numero_cm }}</td>
                <td>{{ $datos[$i]->nombre_cm }}</td>
                <td height="80">{{ $datos[$i]->descripcion_producto }}</td>
            </tr>
        @endfor
    </tbody>
</table>
