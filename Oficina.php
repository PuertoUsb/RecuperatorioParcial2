<?php 
class Oficina extends Contrato{

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

public function __toString(){
    $cadena = parent::__toString();
    $cadena = $cadena ."Importe total". $this->calcularImporte(). "\n"; //
}
}

?>