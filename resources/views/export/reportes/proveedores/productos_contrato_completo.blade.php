<table>
    <thead>
        <tr>
            <th colspan="19" align="center">SISTEMA DE CONTRATO MARCO</th>
        </tr>    
        <tr>
            <td colspan="19" align="center">REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO</td>
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
            <td style="background-color: #235b4e; color: #ffffff;" width="25">ID PARTIDA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20" height="40">CLAVE CAMBSCDMX</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CAPÍTULO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">FECHA DE PUBLICACIÓN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">VALIDACIÓN ECONÓMICA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">VALIDACIÓN TÉCNICA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">VALIDACIÓN ADMINISTRATIVA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">CONTRATO MARCO(NOMBRE)</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ID CONTRATO MARCO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">ESTATUS DEL PRODUCTO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PROVEEDOR</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">PRECIO UNITARIO SIN IVA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">PRECIO UNITARIO CON IVA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">UNIDAD DE MEDIDA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">PRODUCTO</td><!-- Ya se trae el dato-->
            <td style="background-color: #235b4e; color: #ffffff;" width="20">DESCRIPCIÓN DEL BIEN</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="15">FECHA DE MODIFICACIÓN DEL PRECIO</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="20">NO. FICHA</td>
            <td style="background-color: #235b4e; color: #ffffff;" width="10">VERSIÓN</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datos as $dato)
            <tr>
                <td>{{ $dato->partida }}</td>
                <td height="100">{{ $dato->cabms }}</td>
                <td>{{ $dato->capitulo }}</td>
                <td>{{ $dato->fecha_publicacion }}</td>
                <td>{{ $dato->validacion_economica }}</td>
                <td>{{ $dato->validacion_tecnica }}</td>    
                <td>{{ $dato->validacion_administrativa }}</td>                    
                <td>{{ $dato->nombre_cm }}</td>
                <td>{{ $dato->numero_cm }}</td>
                <td>{{ $dato->estatus }}</td>
                <td>{{ $dato->nombre }}</td>
                <td>${{ number_format($dato->precio_unitario, 2) }}</td>
                <td>${{ number_format($dato->precio_unitario_iva, 2) }}</td>
                <td>{{ $dato->unidad_medida }}</td>
                <td>{{ $dato->nombre_producto }}</td>
                <td>{{ $dato->descripcion_producto }}</td>
                <td>{{ $dato->fecha_modificacion_precio }}</td>
                <td>{{ $dato->numero_ficha }}</td>
                <td>{{ $dato->version }}</td>
            </tr>
        @endforeach       
    </tbody>
</table>
