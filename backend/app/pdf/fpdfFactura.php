<?php
require_once __DIR__ . "/../../libs/fpdf.php";

class PDF_Factura extends FPDF {
    public function generar($factura) {
        $this->AddPage();
        $this->SetFont("Arial","B",16);
        $this->Cell(0,10,"Taller Automotriz - Factura #".$factura['id'],0,1,"C");
        $this->Ln(5);
        $this->SetFont("Arial","",12);
        $this->Cell(0,7,"Fecha: ".$factura['fecha'],0,1);
        $this->Cell(0,7,"Cliente: ".$factura['cliente'],0,1);
        $this->Cell(0,7,"Vehiculo: ".$factura['vehiculo'],0,1);
        $this->Cell(0,7,"Empleado: ".$factura['empleado'],0,1);
        $this->Ln(8);

        $this->SetFont("Arial","B",12);
        $this->Cell(110,8,"Servicio",1,0);
        $this->Cell(30,8,"Cantidad",1,0,"C");
        $this->Cell(40,8,"Precio",1,1,"R");
        $this->SetFont("Arial","",12);
        if (!empty($factura['servicios'])) {
            foreach ($factura['servicios'] as $s) {
                $this->Cell(110,8,$s['nombre'],1,0);
                $this->Cell(30,8,$s['cantidad'],1,0,"C");
                $this->Cell(40,8,"$".number_format($s['costo'],2),1,1,"R");
            }
        } else {
            $this->Cell(180,8,"Sin servicios asociados",1,1);
        }

        $this->Ln(6);
        $this->SetFont("Arial","B",14);
        $this->Cell(140,10,"TOTAL",1,0);
        $this->Cell(40,10,"$".number_format($factura['total'],2),1,1,"R");
        $this->Output("I","Factura_".$factura['id'].".pdf");
    }
}
