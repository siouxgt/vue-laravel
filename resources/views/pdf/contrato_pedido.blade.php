<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('asset/css/tienda_urg.css') }}" rel="stylesheet">
    <style>
        @page {
            margin-top: 100px;
        }
        body {
            font-size: 6px;
        }

        .cdmx {
            width: 40%;
            height: auto;
        }

        .logos {
            display: flex;
        }

        .justify-content-start {
            justify-content: flex-start !important;
        }

        .col-md-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-md-3 {
            flex: 0 0 25%;
            max-width: 50%;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 90px;
        }

        footer {
            position: fixed;
            bottom: -110px;
            left: 0px !important;
            right: 0px !important;
            height: 350px;
            background-color: #FFF;;
        }

        footer strong{
            color: #4c4b4b;
        }

        .firma{
            font-size: 5px;
            text-aling: justify;
            line-height: 6px;
        }

        table {
            border: 1px solid #dee2e6 !important;
            width: 100%;
            font-size: 6px;
        }

        table tr td{
            border: 1px solid #dee2e6 !important;
            font-size: 6px;
        }

        table tr th{
            border: 1px solid #dee2e6 !important;
            color: #4c4b4b !important;
            font-size: 6px;
        }

        .td-50{
            width: 50%;
            font-size: 6px;
        }

        .interlineado{
            line-height: 11px;
        }

        .text-center{
            text-align: center !important;
        }
        .text-justify{
            text-align: justify !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .page_break { 
            page-break-before: always; 
        }
    </style>
</head>

<body>

    <header>
        <img class="cdmx" src="{{ asset('asset/img/gobierno_cdmx.png') }}" />
    </header>

    <footer>
        <table>
            <tr>
                
                <td class="td-50 text-center interlineado"><strong>ELABORO </strong><br>
                    NOMBRE: {{ $firmantes['adquisiciones']['nombre'] }} <br> CARGO: {{ $firmantes['adquisiciones']['cargo'] }}<br>
                    <span class="text1"><strong>FIRMA:</strong> <span class="firma"> {{ $firmantes['adquisiciones']['folio'] }}<br>{{ $firmantes['adquisiciones']['sello'] }} </span></span>
                </td>
                 <td class="td-50 text-center interlineado"><strong class="text-center">POR LA DIRECCIÓN GENERAL DE ADMINISTRACIÓN Y FINANZAS U HOMÓLOGA</strong><br>
                    NOMBRE: {{ $firmantes['titular']['nombre'] }} <br> CARGO: {{ $firmantes['titular']['cargo'] }}<br>
                    <strong>FIRMA:</strong><span class="firma"> {{ $firmantes['titular']['folio'] }}<br>{{ $firmantes['titular']['sello'] }}</span>
                 </td>
            </tr>
            <tr>
                <td class="text-center interlineado" colspan="2"><strong>POR EL PROVEEDOR</strong><br>
                    NOMBRE: {{ $firmantes['proveedor']['nombre'] }} <br> APODERADO (A) LEGAL DE  LA EMPRESA ({{ $contrato->proveedor->nombre}}): <br>
                    <strong>FIRMA:</strong><span class="firma">{{ $firmantes['proveedor']['folio'] }}<br>{{ $firmantes['proveedor']['sello'] }} </span>
                </td>
            </tr>
            @if(isset($firmantes['financiera']) or isset($firmantes['requiriente']))
                <tr>
                    @if(isset($firmantes['financiera']))
                        <td class="td-50 text-center interlineado"><strong class="text-center">POR El ÁREA FINANCIERA (OPCIONAL)</strong><br>
                            NOMBRE: {{ $firmantes['financiera']['nombre'] }} <br> CARGO: {{ $firmantes['financiera']['cargo'] }}<br>
                            <strong>FIRMA: </strong><span class="firma">{{ $firmantes['financiera']['folio'] }}<br>{{ $firmantes['financiera']['sello'] }} </span>
                        </td>
                    @else
                        <td></td>
                    @endif
                    @if(isset($firmantes['requiriente']))
                        <td class="text-center td-50 interlineado"><strong>POR EL ÁREA REQUIRENTE (OPCIONAL)</strong><br>
                            NOMBRE: {{ $firmantes['requiriente']['nombre'] }} &nbsp;&nbsp; CARGO: {{ $firmantes['requiriente']['cargo'] }}<br>
                            <strong>FIRMA: </strong><span class="firma">{{ $firmantes['requiriente']['folio'] }}<br>{{ $firmantes['requiriente']['sello'] }} </span>
                        </td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endif
        </table>
    </footer>
    
    <main>
        <div class="row">
            <table>
                <tr>
                    <td colspan="2" class="text-center"><strong>CONTRATO PEDIDO {{ $contrato->contrato_pedido }}</strong></td>
                </tr>
                <tr>
                    <td>FECHA DE GENERACIÓN DE CONTRATO:</td>
                    <td>{{ Carbon\Carbon::parse($contrato->created_at)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>INSTITUCIÓN:</td>
                    <td>{{ $contrato->institucion }}</td>
                </tr>
                <tr>
                    <td>ANTECEDENTES:</td>
                    <td>CONTRATO MARCO PARA LA ADQUISICIÓN DE {{ $contrato->antecedentes }}</td>
                </tr>
                <tr>
                    <td>ORDEN DE COMPRA:</td>
                    <td>{{ $contrato->orden_compra }}</td>
                </tr>
                <tr>
                    <td>ÁREA(S) REQUIRENTE(S):</td>
                    <td>{{ $contrato->area_requiriente }}</td>
                </tr>
                <tr>
                    <td>REQUISICIÓN (ES) N°(S):</td>
                    <td>{{ $contrato->requisicion }}</td>
                </tr>
                <tr>
                    <td>PARTIDA(S) PRESUPUESTAL(ES):</td>
                    <td>{{ $contrato->partida }} </td>
                </tr>
                <tr>
                    <td>OFICIO DE ADHESIÓN NÚM:</td>
                    <td>{{ $contrato->oficio_adhesion }}</td>
                </tr>
                <tr>
                    <td>AÑO FISCAL:</td>
                    <td>{{ $contrato->anio_fiscal }}</td>
                </tr>
                <tr>
                    <td>FUNDAMENTO LEGAL:</td>
                    <td>ARTÍCULOS 2, FRACCIÓN XXVII, 26 INCISO C), Y 55 DE LA LEY DE ADQUISICIONES PARA EL DISTRITO FEDERA</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>TIPO DE PROCEDIMIENTO DE CONTRATACIÓN</strong></td>
                </tr>
                <tr>
                    <td class="text-center">TIPO DE PROCEDIMIENTO</td>
                    <td class="text-center">FECHA DE FALLO</td>
                </tr>
                <tr>
                    <td class="text-center">ADJUDICACIÓN DIRECTA</td>
                    <td class="text-center">{{ Carbon\Carbon::parse($contrato->fecha_fallo)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>NOMBRE DEL SERVIDOR PÚBLICO CON FACULTADES PARA LA FIRMA DEL CONTRATO</strong></td>
                </tr>
                <tr>
                    <td>C. DIRECTOR GENERAL U HOMÓLOGO:</td>
                    <td>{{ $contrato->director }}</td>
                </tr>
                <tr>
                    <td>R.F.C. DE LA UNIDAD ADMINISTRATIVA:</td>
                    <td>{{ $contrato->rfc_fiscal }}</td>
                </tr>
                <tr>
                    <td>DOMICILIO PARA OÍR Y RECIBIR NOTIFICACIONES:</td>
                    <td>{{ $contrato->direccion_urg }}</td>
                </tr>
                <tr>
                    <td>TELÉFONO:</td>
                    <td>{{ $contrato->telefono_urg }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>DATOS DEL CONTRATO</strong></td>
                </tr>
                <tr>
                    <td>VIGENCIA DEL CONTRATO:</td>
                    <td>{{ Carbon\Carbon::parse($contrato->fecha_inicio)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($contrato->fecha_fin)->format('d/m/Y') }}</td>
                    
                </tr>
                <tr>
                    <td>LUGAR DE ENTREGA DE LOS BIENES:</td>
                    <td>{{ $contrato->direccion_almacen }}</td>
                </tr>
                <tr>
                    <td>FECHA LÍMITE DE ENTREGA DE BIENES:</td>
                    <td>{{ Carbon\Carbon::parse($contrato->fecha_entrega)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>FACTURAR A DOMICILIO FISCAL:</td>
                    <td>{{ $contrato->domicilio_fiscal }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>CONDICIONES DE PAGO</strong></td>
                </tr>
                <tr>
                    <td colspan="2">CONDICIONES DE PAGO: LOS PAGOS DERIVADOS DEL PRESENTE CONTRATO SE CUBRIRÁN A LOS 20 DÍAS HÁBILES POSTERIORES A LA RECEPCIÓN Y VALIDACIÓN DE LA (S) FACTURA (S) DEBIDAMENTE REQUISITADA (S)</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>DATOS DEL PROVEEDOR</strong></td>
                </tr>
                <tr>
                    <td>NOMBRE RAZÓN SOCIAL O DENOMINACIÓN:</td>
                    <td>{{ $contrato->nombre_proveedor }}</td>
                </tr>
                <tr>
                    <td>R.F.C.:</td>
                    <td>{{ $contrato->rfc_proveedor }}</td>
                </tr>
                <tr>
                    <td>DOMICILIO FISCAL:</td>
                    <td>{{ $contrato->domicilio_proveedor }}</td>
                </tr>
                <tr>
                    <td>TELÉFONO:</td>
                    <td>{{ $contrato->telefono_proveedor }}</td>
                </tr>
                @if($contrato->proveedor->persona == "Fisica")
                <tr>
                    <td colspan="2">
                        <strong>PERSONA FISICA</strong> ACREDITA SU PERSONALIDAD CON CONSTANCIA DE SITUACIÓN FISCAL QUE LE PERMITE PRESTAR LOS SERVICIOS DEL PRESENTE CONTRATO: {{ $contrato->cedula_identificacion }}
                    </td>
                </tr>
                @endif
                @if($contrato->proveedor->persona == "Moral")
                    <tr>
                        <td colspan="2"><strong>PERSONA MORAL</strong> ACREDITA SU PERSONALIDAD MEDIANTE ESCRITURA PÚBLICA No. {{ $contrato->acta_identidad }} DE FECHA @if($contrato->fecha_constitucion_identidad) {{ strtoupper($contrato->fecha_constitucion_identidad->formatLocalized('%d de %B de %Y')) }} @endif. NOMBRE Y No. DEL NOTARIO: LIC. {{ strtoupper($contrato->titular_identidad) }} {{ $contrato->num_notaria_identidad }} NOTARÍA PÚBLICA No. {{ strtoupper($contrato->num_notaria_identidad) }} DE LA {{ strtoupper($contrato->entidad_identidad) }}, INSCRIPCIÓN EN: FOLIO MERCANTIL {{ $contrato->num_reg_identidad }} DE FECHA @if($contrato->fecha_reg_identidad) {{ strtoupper($contrato->fecha_reg_identidad->formatLocalized('%d de %B de %Y')) }} @endif. </td>
                    </tr>
                @endif
                @if($contrato->proveedor->acreditacion_acta_constitutiva == true)
                    <tr>
                        <td colspan="2"><strong>NOMBRE DEL REPRESENTANTE LEGAL:</strong> {{ $contrato->representante_proveedor }}, QUIEN ACREDITA SU PERSONALIDAD COMO APODERADO (GENERAL, ESPECIAL) CON FACULTADES PARA FIRMAR EL PRESENTE CONTRATO, MEDIANTE LA ESCRITURA PÚBLICA NÚMERO {{ $contrato->acta_identidad }}, DE FECHA: @if($contrato->fecha_reg_representante) {{ strtoupper($contrato->fecha_reg_representante->formatLocalized('%d de %B de %Y')) }} @endif. NOMBRE Y No. DEL NOTARIO: LIC. {{ $contrato->titular_identidad }} {{ $contrato->num_notaria_identidad }}, NOTARÍA PÚBLICA No. {{ $contrato->num_notaria_identidad}} DE {{ strtoupper($contrato->entidad_identidad) }}.</td>
                    </tr>
                @else 
                    <tr>
                        <td colspan="2"><strong>NOMBRE DEL REPRESENTANTE LEGAL:</strong> {{ $contrato->representante_proveedor }}, QUIEN ACREDITA SU PERSONALIDAD COMO APODERADO (GENERAL, ESPECIAL) CON FACULTADES PARA FIRMAR EL PRESENTE CONTRATO, MEDIANTE LA ESCRITURA PÚBLICA NÚMERO {{ $contrato->num_reg_representante }}, DE FECHA: @if($contrato->fecha_reg_representante) {{ strtoupper($contrato->fecha_reg_representante->formatLocalized('%d de %B de %Y')) }} @endif. NOMBRE Y No. DEL NOTARIO: LIC. {{ $contrato->titular_representante }} {{ $contrato->num_notaria_representante }}, NOTARÍA PÚBLICA No. {{ $contrato->num_notaria_representante}} DE {{ strtoupper($contrato->entidad_representante) }}.</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2" class="text-center"><strong>PENAS CONVENCIONALES</strong></td>
                </tr>
                <tr>
                    <td colspan="2">“LAS PARTES” CONVIENEN QUE EN CASO DE QUE “EL PROVEEDOR” INCUMPLA CON LAS OBLIGACIONES DERIVADAS DEL PRESENTE CONTRATO, EN CUANTO A CALIDAD Y OPORTUNIDAD DEL SUMINISTRO, ESTARÁ OBLIGADO AL PAGO DE UNA PENA CONVENCIONAL DEL 1% (UNO POR CIENTO), SIN INCLUIR EL IMPUESTO AL VALOR AGREGADO (I.V.A.), PORCENTAJE QUE SE APLICARÁ POR CADA DÍA NATURAL DE INCUMPLIMIENTO Y SERÁ CON CARGO DIRECTO A LA FACTURACIÓN.</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>GARANTÍAS ANEXAS</strong></td>
                </tr>
                <tr>
                    <td colspan="2">CONFORME AL ARTÍCULO 74 DE LA LEY DE ADQUISICIONES PARA EL DISTRITO FEDERAL, EL PRESTADOR QUEDA EXIMIDO DE LA PRESENTACIÓN DE LA GARANTÍA DE CUMPLIMIENTO DEL PRESENTE CONTRATO<br/> {{ strtoupper($contrato->garantias_anexas) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>SE OTORGARA ANTICIPO</strong></td>
                </tr>
                <tr>
                    <td class="text-center">SÍ &nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
                    <td class="text-center">NO &nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;X&nbsp;&nbsp;)</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">ESTE CONTRATO NO RECIBIÓ ANTICIPO DE NINGÚN TIPO</td>
                </tr>
            </table>
        </div>
        <div class="row page_break">
            {{-- <p class="text-center mt-2"><strong>CONTRATO PEDIDO {{ $contrato->contrato_pedido }} <br>(REVERSO)</strong></p> --}}
            <p class="text-center mt-1"><strong>DECLARACIONES Y CLÁUSULAS GENERALES</strong> </p>
            <p class="mt-2">Para los efectos del presente Contrato Pedido, se entenderá por <strong>“La Contratante”</strong> a la Unidad Administrativa que adquiere los bienes o contrata los bienes que se describen en este documento, y por <strong>“El proveedor o Prestador”</strong>, a la persona física o moral que se obliga a enajenar los bienes cuyos datos han quedado debidamente señalados:</p>
            <p class="text-center mt-3"><strong>DECLARACIONES</strong></p>
            <p class="mt-1 text-justify">
                <strong>I. Declara “La Contratante", por conducto de su representante, que:</strong> <br>
                a.      Es una Unidad Responsable de Gasto de la Administración Pública de la Ciudad de México. <br>
                b.      Tiene atribuciones para suscribir contratos, en términos de lo dispuesto por el artículo  {{ $contrato->articulo }}  de la Ley Orgánica del Poder Ejecutivo y de la Ley Orgánica de la Ciudad de México. <br>
                c.     La adjudicación del contrato se llevó a cabo conforme al procedimiento previsto en los artículos 2, fracción XXVII, 27 fracción C), 55 y 56 de la Ley de Adquisiciones para el Distrito Federal, derivado del Contrato Marco que celebró la Dirección General de Recursos Materiales y Servicios Generales el pasado {{ strtoupper($contrato->fecha_contrato_marco->formatLocalized('%d de %B de %Y')) }}. <br>
                d.      Que cuenta con la suficiencia presupuestal para cubrir el compromiso de este contrato.
            </p>
            <p class="mt-2 text-justify">
                <strong>II. Declara “El Proveedor o Prestador” a través de su Apoderado legal que:</strong> <br>
                a.  Ratifica los datos contenidos en la carátula del presente Contrato. <br>
                b. Los socios de su representada; los miembros de la administración de la misma, sus apoderados y representantes legales; el personal que labora al servicio de aquella, Así como los cónyuges de todos ellos, no tienen lazos de consanguinidad ni de afinidad hasta el cuarto grado, con persona alguna que labore en la Administración Pública de la Ciudad de México, y entre cuyas funciones se encuentra la de participar en actividades relativas a la enajenación de los bienes materia del presente Contrato. <br>
                c. Se encuentra al corriente de su declaración de impuestos, derechos, aprovechamientos y productos referidos en el Código Fiscal del Distrito Federal (el proveedor deberá presentar constancia de adeudos expedida por la Secretaría de Administración y Finanzas o la autoridad competente que corresponda, de las contribuciones siguientes: impuesto predial, impuesto sobre adquisición de inmuebles, impuesto sobre nóminas, impuesto sobre tenencia o uso de vehículos, impuesto por la prestación de servicios de hospedaje y derechos por el suministro de agua, según le resulten aplicables). <br>
            </p>
            <p class="mt-2 text-justify">
                <strong>III. Declaran ambas partes que:</strong> <br>
                a. El presente Contrato se regula por el Contrato Marco N° {{ $contrato->numero_contrato_marco }}, celebrado en términos de la Ley de Adquisiciones para el Distrito Federal, su Reglamento y demás disposiciones aplicables, así como con los Términos Generales y Lineamientos Administrativos del Contrato Marco y demás disposiciones aplicables. <br>
                b. En este acto se reconocen mutuamente la personalidad con la que se ostentan y la capacidad legal para celebrar el presente contrato pedido. <br>
                c. Manifiestan bajo protesta de decir verdad, que en este contrato no existe dolo, lesión ni mala fe y que lo celebran de acuerdo con su libre y espontánea voluntad. <br><br>
                Expresado lo anterior, las partes se obligan al tenor de las siguientes:
            </p>
        </div>
        <div class="row">
            <p class="text-center mt-1"><strong>CLÁUSULAS</strong></p>
            <p class="text-justify">
                 <strong>Primera:</strong> “El proveedor” otorga a favor de “La Contratante” el servicio/suministro cuya descripción, cantidad y precio unitario se indican en el contenido de este contrato y anexo que, firmado por las partes  lo reconocen como elemento integral de este contrato.<br>
                Los bienes deberán cumplir las especificaciones contenidas en la ficha de estándar de producto, así como en el anexo que firmado por las partes y forma parte integrante de este contrato.<br>
                “La Contratante” podrá solicitar un incremento en la cantidad de los bienes solicitados en el presente contrato mediante convenio modificatorio que no exceda del 25% del total del contrato que se suscriba.
                <strong>Segunda:</strong> “La Contratante” pagará a “El proveedor” en concepto de contraprestación por los bienes objeto del presente contrato, hasta la cantidad estipulada en el (los) anverso (s) de este contrato. <br>
                <strong>Tercera:</strong> Ambas partes convienen que el importe del presente contrato será liquidado a “El proveedor” dentro del plazo estipulado en el anverso de este contrato. Ambas partes convienen en que para el supuesto de que se realicen pagos en exceso a “El proveedor”, éste deberá reintegrar los remanentes, más los intereses correspondientes conforme a una tasa que será igual a la establecida por la Ley de Ingresos de la Ciudad de México, para los casos de prórroga para el pago de créditos fiscales. <br>
                <strong>Cuarta:</strong> “El proveedor” se obliga a entregar los bienes, objeto del presente contrato, en el domicilio y fecha señalados en el (los) anverso (s) del presente contrato. <br>
                <strong>Quinta:</strong> Ambas partes convienen que una vez que hayan sido otorgados los bienes objeto de este contrato, “La Contratante” podrá realizar pruebas de calidad a los mismos, cuyo costo será cubierto por “El proveedor”. Las muestras requeridas para realizar las pruebas serán repuestas por “El proveedor” sin costo alguno para “La Contratante”. <br>
                <strong>Sexta:</strong> “La Contratante”, podrá rescindir el presente contrato cuando se desprenda que los bienes materia del presente contrato, no cumplen con las características y especificaciones técnicas solicitadas, sin responsabilidad para esta. <br>
                Para los efectos del presentes Contrato, se entenderá por “La Contratante” a la Unidad Administrativa que adquiere los bienes que se describen en este documento y por “El Proveedor a la persona física o moral, que se obliga a enajenar los bienes, cuyos datos han quedado debidamente señalados. <br>
                <strong>Séptima:</strong> La vigencia del contrato será la estipulada en el (los) anverso (s) del presente Contrato. <br>
                <strong>Octava:</strong> Ambas partes convienen en que “El Proveedor” será el único responsable de la utilización de las patentes, marcas, certificados de invención y todo lo relacionado con los derechos de propiedad industrial o intelectual del Licenciamiento objeto del presente Contrato, deslindando de toda responsabilidad por su uso a “La Contratante”. <br>
                <strong>Novena:</strong> “El proveedor”” quedará obligado ante “La Contratante”, a responder ante los defectos y vicios ocultos de los bienes objeto del presente Contrato por el término de treinta días  a partir de la entrega total de los mismos y por cualquier otra responsabilidad en que incurra. <br>
                <strong>Décima:</strong> El presente contrato no requerirá de la presentación de una fianza de cumplimiento. <br>
                <strong>Décima Primera: “El Proveedor o Prestador”</strong> no podrá ceder, traspasar o subcontratar en forma parcial o total los derechos y obligaciones que se deriven del presente Contrato y en caso de hacerlo será considerado causa de rescisión. <br>
                <strong>Décima Segunda:</strong> Las partes establecen como pena convencional por retraso o incumplimiento en el otorgamiento de los bienes, el porcentaje indicado en el (los) anverso (s) del presente Contrato, por cada día de retraso calculado por el importe total de la entrega incumplida, de tal manera que el monto máximo de la pena será aquel que iguale el 15% del importe del presente Contrato sin incluir I.V,A. si se iguala o supera, la aplicación del porcentaje como pena convencional “La Contratante”, podrá rescindir el Contrato sin ninguna responsabilidad para la misma.  Esta pena será descontada directamente del CFDI que como pago deba hacerse al proveedor. <br>
                <strong>Décima Tercera:</strong> La falta de observancia y cumplimiento en el contenido del presente Contrato por parte de <strong>“El Proveedor o Prestador”</strong>, faculta expresamente a “La Contratante”, para darlo por rescindido y aplicar las penas a que por incumplimiento se haga acreedor “El Proveedor”. <br>
                <strong>Décima Cuarta:</strong> Las partes aceptan que si “La Contratante”, considera que <strong>“El Proveedor o Prestador”</strong> ha incurrido en alguna de las causas de rescisión que se consignan en este documento, podrá decretar la rescisión del mismo que opera de pleno Derecho y sin responsabilidad para “La Contratante”. <br><br>

                <strong>“La Contratante”</strong> rescindirá el Contrato por cualquiera de las causas que a continuación se señalan: <br><br>

                1.- Si <strong>“El Proveedor o Prestador”</strong> no cumple con la entrega del Licenciamiento dentro del plazo señalado en el (los) anverso (s) del presente Contrato. <br>
                2.- Si "El Proveedor o Prestador" no cumple con lo establecido en la cláusula primera del presente Contrato. <br>
                3.- Si "El Proveedor o Prestador" es declarado en concurso mercantil. <br>
                4.- Si "El Proveedor o Prestador" subcontrata, cede o traspasa en forma total o parcial los derechos derivados del presente contrato. <br>
                5.- En general por cualquier otra causa imputable a "El Proveedor o Prestador" que lesione los intereses de "la contratante". <br><br>

                Décima Quinta: Ambas partes convienen que la terminación anticipada del presente Contrato, la suspensión temporal o definitiva del mismo, ya sea de común acuerdo o por caso fortuito o fuerza mayor, será sin responsabilidad alguna para "La Contratante". <br>
                Décima Sexta: Para todo lo relacionado con la interpretación, cumplimiento y ejecución del presente Contrato, así como para dirimir controversias que se susciten con motivo de su incumplimiento y/o interpretación, las partes se someten a los tribunales de la Ciudad de México, renunciando expresamente en este acto, al fuero y jurisdicción de cualquier otro domicilio que les corresponde en el presente, o pudiere corresponderles en lo futuro. 
            </p>
        </div>
        <div class="row page_break">
              <p class="text-center mt-2"><strong>CONTRATO PEDIDO {{ $contrato->contrato_pedido }}</strong></p>
            <table class="mt-2">
                <tr>
                    <th>PARTIDA</th>
                    <th>DESCRIPCION DE LOS BIENES Y/O SERVICIO</th>
                    <th>MARCA Y/O MODELO</th>
                    <th>CANTIDAD</th>
                    <th>UNIDAD DE MEDIA</th>
                    <th>PRECIO UNITARIO</th>
                </tr>
                @php $subtotal = 0; @endphp
                @foreach($productos as $producto)
                @php $subtotal += $producto->subtotal; @endphp
                <tr>
                    <td>{{ substr($producto->cabms,0,4) }}</td>
                    <td>{{ $producto->descripcion_producto }}</td>
                    <td>{{ $producto->marca }} / {{ $producto->modelo}}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>{{ $producto->medida }}</td>
                    <td>${{ number_format($producto->precio,2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" rowspan="3" class="text-center">{{ strtoupper($totalLetra) }} PESOS {{$decimal}}/100 M.N.</td>
                    <td>SUBTOTAL</td>
                    <td>${{ number_format($subtotal,2) }}</td>
                </tr>
                <tr>
                    <td>I.V.A</td>
                    <td>${{ number_format($subtotal * .16,2) }}</td>
                </tr>
                <tr>
                    <td>TOTAL</td>
                    <td>${{ number_format(($subtotal * .16) + $subtotal,2) }}</td>
                </tr>
            </table>
        </div>    
    </main>
   
    
    
     <script type="text/php">
            if ( isset($pdf) ) {
                $GLOBALS['page'] = 1;
                $pdf->page_script('
                    $PAGE_COUNT = ceil($PAGE_COUNT / 2);
                    $PAGE = 1;
                    $font = $fontMetrics->get_font("Source Sans Pro, sans-serif", "normal");
                    if(($PAGE_NUM % 2) == 1){
                        if($PAGE_NUM != 1){
                            $GLOBALS["page"]++;
                            $PAGE = $GLOBALS["page"];
                        }
                        $pdf->text(450, 40, " Hoja No. $PAGE de $PAGE_COUNT",$font, 8);   
                    }
                    
                ');

            }
        </script>
</body>

</html>