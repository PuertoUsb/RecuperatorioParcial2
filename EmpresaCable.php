<?php

class EmpresaCable {
    private $colPlanes;
    private $colContrato;

    public function __construct($colPlanes, $colContrato) {
        $this->colPlanes=$colPlanes;
        $this->colContrato=$colContrato;
    }
    public function setColPlanes($colPlanes){
        $this->colPlanes=$colPlanes;
    }
    public function getColPlanes(){
        return $this->colPlanes;
    }
    public function setColContrato($colContrato){
        $this->colContrato=$colContrato;
    }
    public function getColContrato(){
        return $this->colContrato;
    }

    public function __toString(){
        $cadena = "";
        $cadena = $cadena. $this->verArray($this->getColPlanes())."\n";
        $cadena = $cadena. $this->verArray($this->getColContrato())."\n";
        return $cadena;
    }

    public function verArray($array){
        $cadena = "";
        foreach($array as $item){
            $cadena = $cadena. " " .$item."\n";
        }
        return $cadena;
    }

    public function incorporarPlan($objPlan) {
        $numPlanes = count($this->getColPlanes());
        for ($i = 0; $i < $numPlanes; $i++) {

            if ($this->identicos($objPlan, $this->getColPlanes()[$i])) {
                return false;
            }
        }
        $this->getColPlanes()[] = $objPlan;
        return true;
    }

    private function identicos($planA, $planB) {
        $iguales = true;

        if ($planA->getTipo() !== $planB->getTipo()) {
            $iguales = false;
        }

        if ($planA->getIncluyeMG() && $planB->getIncluyeMG()) {
            if ($planA->getMegabytes() !== $planB->getMegabytes()) {
                $iguales = false;
            }
        } elseif ($planA->getIncluyeMG() || $planB->getIncluyeMG()) {
            $iguales = false;
        }
        return $iguales;
    }
    public function incorporarContrato($objPlan, $objCliente, $fechaDesde, $fechaVenc, $esViaWeb){
        $colContrato = array(); 
        if ($esViaWeb){
            $unContrato = new Web($fechaDesde, $fechaVenc, $objPlan, null, 0, null,$objCliente, 0);
         }else{
            $unContrato = new Oficina($fechaDesde, $fechaVenc, $objPlan, null, 0, null, $objCliente);
         }
         $colContrato [] = $unContrato;
         $this->setColContrato($colContrato);
    }

    public function retornarContratos($codigoPlan) {
        $importeTotal = 0;
        foreach ($this->getColContrato() as $contrato) {
            if ($contrato->getObjPlan()->getCodigo() === $codigoPlan) {
                $importeTotal += $contrato->getImporte();
            }
        }
        return $importeTotal;
    }

    public function pagarContrato($objContrato) {
        $importeFinal = false;
        if ($objContrato->getEstado() === 'Pagado') {
            $importeFinal = true;
        } else{
        $importeFinal = $objContrato->getImporte();
        $objContrato->setEstado('Pagado');
        return $importeFinal;
        }
    }

}

?>