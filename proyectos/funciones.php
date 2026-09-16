<?php

const CARGO_ADMINISTRATIVO = 3.00;
const COSTO_HORA_EXTRA = 2.00;


function calcularPago(float $precio, string $modalidad, string $experiencia, int $horasExtras): array {

    $costoHoras = $horasExtras * COSTO_HORA_EXTRA;

    $subtotal = $precio + $costoHoras;


    $porcentajeDescuento = match (true) {

        $modalidad === "virtual" && $experiencia === "principiante" => 0.15,

        $experiencia === "principiante" => 0.10,

        $modalidad === "virtual" => 0.05,

        default => 0
    };


    $descuento = $precio * $porcentajeDescuento;


    $total = $subtotal - $descuento + CARGO_ADMINISTRATIVO;


    return [

        "precioOriginal" => $precio,

        "costoHoras" => $costoHoras,

        "subtotal" => $subtotal,

        "porcentajeDescuento" => $porcentajeDescuento,

        "descuento" => $descuento,

        "cargoAdministrativo" => CARGO_ADMINISTRATIVO,

        "total" => $total
    ];
}