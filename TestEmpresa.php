<?php
include_once ("Canal.php");
include_once ("Cliente.php");
include_once ("Contrato.php");
include_once ("EmpresaCable.php");
include_once ("Oficina.php");
include_once ("Plan.php");
include_once ("Web.php");


$objEmpresaCable = new EmpresaCable([],[]);

$canal1 = new Canal("noticias", 0, true, true);
$canal2 = new Canal("musical", 0, false, true);
$canal3 = new Canal("deportivo", 0, true, false);

$plan1 = new Plan(111, [$canal1, $canal2], 100);
$plan2 = new Plan(222, [$canal2, $canal3], 150);

$cliente = new Cliente("Juan Pérez", "12345678", "Bandurrias 11");

$contrato1 = new Oficina("20-03-2013", "20-04-2013", $plan1, "pagado", 500, "no", $cliente );
$contrato2 = new Web("12-03-2024", "12-05-2024", $plan2, "pagado", 700, "si", $cliente, 10);
$contrato3 = new Web("12-03-2024", "12-05-2024", $plan2, "pagado", 700, "si", $cliente, 10);

echo $contrato1->calcularImporte() . "\n";
echo $contrato2->calcularImporte() . "\n";
echo $contrato3->calcularImporte() . "\n";

$objEmpresaCable->incorporarContrato($plan1, $cliente, date("Y-m-d"), date("Y-m-d", strtotime("+30 days")), false);
$objEmpresaCable->incorporarContrato($plan2, $cliente, date("Y-m-d"), date("Y-m-d", strtotime("+30 days")), true);

$objEmpresaCable->pagarContrato($contrato1);
$objEmpresaCable->pagarContrato($contrato2);
echo $objEmpresaCable->retornarContratos(111) . "\n";


?>