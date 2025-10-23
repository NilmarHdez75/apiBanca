<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrato del Socio</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; }
        h1 { text-align: center; color: #1a1a1a; }
        .info { margin-bottom: 15px; }
        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #777; }
    </style>
</head>
<body>
<h1>Contrato de Afiliación</h1>

<p>En la ciudad de San Cristóbal de las Casas, Chiapas, a la fecha {{ $fecha }}, la Caja Popular San Juan Bosco acuerda con el socio:</p>

<div class="info">
    <strong>Nombre completo:</strong> {{ $socio->nombre }} {{ $socio->apellidos }} <br>
    <strong>Número de socio:</strong> {{ $socio->numero_socio }} <br>
    <strong>CURP:</strong> {{ $socio->curp }} <br>
    <strong>INE:</strong> {{ $socio->ine }} <br>
    <strong>Domicilio:</strong> {{ $socio->direccion?->calle }} {{ $socio->direccion?->numero_ext }}, {{ $socio->direccion?->colonia }}, {{ $socio->direccion?->municipio }}, {{ $socio->direccion?->estado }}
</div>

<p>El socio acepta los términos y condiciones establecidos por la Caja Popular San Juan Bosco para el manejo de sus cuentas de ahorro y servicios financieros.</p>

<div class="footer">
    <p>Documento generado automáticamente por el sistema - No requiere firma digital</p>
</div>
</body>
</html>
