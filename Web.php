<?php
class Web extends Contrato{
private $descuento;

public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $estado, $costo,$seRennueva,$objCliente, $descuento){
    parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $estado, $costo,$seRennueva,$objCliente);
    $this->descuento = 10;
}

public function setDescuento($descuento){
    $this->descuento = $descuento;
}

public function getDescuento(){
    return $this->descuento;
}


public function calcularImporte(){
    $importeplan = $this->getObjPlan()->getImporte();
    $colCanales = $this->getObjPlan()->getColCanales();
    $importeCanal = 0;

    foreach ($colCanales as $unCanalImporte){
         $importeCanal += $unCanalImporte->getImporte();
    }
    $totCosto = $importeCanal + $importeplan;
    $this->setCosto($totCosto);
    return $totCosto;
}

public function totDescuento(){
    $costoBase = $this-> calcularImporte();

    $CostoDescuento = ($this->getDescuento() * $costoBase) / 100;
    $totCosto = $CostoDescuento - $CostoDescuento;
    $this->setCosto($totCosto);
    return $totCosto;
}

public function __toString(){
    $cadena = parent::__toString();
    $cadena = $cadena. "Total con descuentos: ".$this->getDescuento()."\n";
    return $cadena;
}

}
?>