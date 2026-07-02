<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{

font-family: DejaVu Sans;

font-size:13px;

color:#333;

}

h1{

text-align:center;

color:#065f46;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

th{

background:#059669;

color:white;

padding:10px;

}

td{

padding:10px;

border:1px solid #ddd;

text-align:center;

}

.footer{

margin-top:40px;

font-size:12px;

text-align:right;

color:#666;

}

</style>

</head>

<body>

<h1>

REPORTE GENERAL DEL SISTEMA

</h1>

<p>

<strong>Fecha:</strong>

{{ $fecha->format('d/m/Y H:i') }}

</p>

<table>

<thead>

<tr>

<th>Módulo</th>

<th>Total</th>

</tr>

</thead>

<tbody>

<tr>

<td>Usuarios</td>

<td>{{ $usuarios }}</td>

</tr>

<tr>

<td>Emprendimientos</td>

<td>{{ $emprendimientos }}</td>

</tr>

<tr>

<td>Sitios Turísticos</td>

<td>{{ $sitios }}</td>

</tr>

<tr>

<td>Actividades</td>

<td>{{ $actividades }}</td>

</tr>

<tr>

<td>Festividades</td>

<td>{{ $festividades }}</td>

</tr>

</tbody>

</table>

<div class="footer">

Sistema Web de Gestión Turística - GAD La Candelaria

</div>

</body>

</html>