<table>
    <thead>
        <tr>
            <th colspan="5" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>
        <tr>
            <td colspan="5" align="center">REPORTE DIRECTORIO DE UNIDADES COMPRADORAS</td>
        </tr>
        <tr>
            <td><b>PROVEEDOR</b></td>
            <td colspan="4" height="50">{{ Auth::guard('proveedor')->user()->nombre }}</td>
        </tr>
        <tr>
            <td><b>FECHA DE REPORTE</b></td>
            <td colspan="4">{{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">URG (UNIDAD RESPONSABLE DE GASTO)</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CORREO ELECTRÓNICO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">TELÉFONO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="50">FECHA DE CREACIÓN DE CUENTA</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
            <tr>
                <td>{{ $dato->id }}</td>
                <td height="100">{{ $dato->nombre_urg }}</td>
                <td>{{ $dato->correo }}</td>
                <td>{{ $dato->telefono }}</td>
                <td>{{ $dato->fecha_creacion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
