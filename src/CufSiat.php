<?php

namespace Arielfad\CufSiatBolivia;

require ('AuxiliaryMethods.php');
class CufSiat
{
    private $date_time;
    private $nit_emitter;
    private $offie_code;
    private $bill_modality;
    private $emission_type;
    private $invoice_type;
    private $document_type_sector;
    private $invoice_number;
    private $point_of_sale;
    private $control_code;

    public function getDateTime()
    {
        return $this->date_time;
    }

    public function setDateTime($date_time)
    {
        $this->date_time = $date_time;
    }

    public function getNitEmitter()
    {
        return $this->nit_emitter;
    }

    public function setNitEmitter($nit_emitter)
    {
        $this->nit_emitter = $nit_emitter;
    }

    public function getOffieCode()
    {
        return $this->offie_code;
    }

    public function setOffieCode($offie_code)
    {
        $this->offie_code = $offie_code;
    }

    public function getBillModality()
    {
        return $this->bill_modality;
    }

    public function setBillModality($bill_modality)
    {
        $this->bill_modality = $bill_modality;
    }

    public function getEmissionType()
    {
        return $this->emission_type;
    }

    public function setEmissionType($emission_type)
    {
        $this->emission_type = $emission_type;
    }

    public function getInvoiceType()
    {
        return $this->invoice_type;
    }

    public function setInvoiceType($invoice_type)
    {
        $this->invoice_type = $invoice_type;
    }

    public function getDocumentTypeSector()
    {
        return $this->document_type_sector;
    }

    public function setDocumentTypeSector($document_type_sector)
    {
        $this->document_type_sector = $document_type_sector;
    }

    public function getInvoiceNumber()
    {
        return $this->invoice_number;
    }

    public function setInvoiceNumber($invoice_number)
    {
        $this->invoice_number = $invoice_number;
    }

    public function getPointOfSale()
    {
        return $this->point_of_sale;
    }

    public function setPointOfSale($point_of_sale)
    {
        $this->point_of_sale = $point_of_sale;
    }

    public function getControlCode()
    {
        return $this->control_code;
    }

    public function setControlCode($control_code)
    {
        $this->control_code = $control_code;
    }

    /***
     * @param $nit
     * Nit del emisor
     * @param $date_time
     * Fecha y hora del emision en formato YmdHisu
     * @param $office
     * Código de la sucursal:
     *  0 = Casa Matriz;
     *  1 = Sucursal 1;
     *  2 = Sucursal 2;
     *  N = Sucursal N;
     * @param $emission
     * Este valor describe como se está emitiendo la factura:
     * 1 = Online;
     * 2 = Offline;
     * 3 = Masiva;
     * @param $type_invoice
     * El tipo de factura que emitirá segun su previa configuración:
     * 1 = Factura con Derecho a Crédito Fiscal;
     * 2 = Factura sin Derecho a Crédito Fiscal;
     * 3 = Documento de Ajuste;
     * @param $modality
     * La modalidad representa el ámbito al cual esta suscrito su sistema de facturación:
     * 1 = Electrónica en Línea;
     * 2 = Computarizada en Línea;
     * 3 = Portal Web en Línea;
     * @param $sector_document
     * El documento sector lo obtiene en el endpoint de la API de sincronización del SIAT:
     * 1 = Factura Compra Venta;
     * 2 = Recibo de Alquiler de Bienes Inmuebles;
     * 24 = Nota Crédito - Débito;
     * @param $invoice_number
     * Número secuencial
     * @param $point_of_sale
     * Número de punto de venta:
     * 0 = No corresponde;
     * 1,2,3,4,….n;
     * @param $control_code
     * Código obtenido en el endpoint de la API CUFD
     */
    public function __construct($nit, $date_time, $office, $emission, $type_invoice, $modality, $sector_document, $invoice_number, $point_of_sale, $control_code)
    {
        $this->nit_emitter = $nit;
        $this->date_time = $date_time;
        $this->offie_code = $office;
        $this->bill_modality = $modality;
        $this->emission_type = $emission;
        $this->invoice_type = $type_invoice;
        $this->document_type_sector = $sector_document;
        $this->invoice_number = $invoice_number;
        $this->point_of_sale = $point_of_sale;
        $this->control_code = $control_code;
    }

    public function generateCuf()
    {
        // fill in with leading zeros (1)
        $this->leadingZeros();
        // concat data (2)
        $code = $this->concatData();

        // get module 11 (3)
        $module_11 = AuxiliaryMethods::getModule11($code, 1, 9, false);
        $code .= $module_11;

        // apply to base 16 string (4)
        $cuf = AuxiliaryMethods::getBase16($code);

        $cuf .= $this->getControlCode();
        return $cuf;
    }

    public function leadingZeros(): void
    {
        $this->setNitEmitter(str_pad($this->nit_emitter, 13, '0', STR_PAD_LEFT));
        $this->setOffieCode(str_pad($this->offie_code, 4, '0', STR_PAD_LEFT));
        $this->setDocumentTypeSector(str_pad($this->document_type_sector, 2, '0', STR_PAD_LEFT));
        $this->setInvoiceNumber(str_pad($this->invoice_number, 10, '0', STR_PAD_LEFT));
        $this->setPointOfSale(str_pad($this->point_of_sale, 4, '0', STR_PAD_LEFT));
    }

    public function concatData(): string
    {
        return $this->getNitEmitter().$this->getDateTime().$this->getOffieCode().$this->getBillModality().$this->getEmissionType().
            $this->getInvoiceType().$this->getDocumentTypeSector().$this->getInvoiceNumber().$this->getPointOfSale();
    }
}
