<?php

namespace App\Services;

class PdfService
{
    /**
     * Generar PDF de reporte de pacientes
     */
    public static function generarReportePacientes($pacientes)
    {
        $html = view('exports.reportes.pacientes', compact('pacientes'))->render();
        return $html;
    }

    /**
     * Generar PDF de reporte de consultas
     */
    public static function generarReporteConsultas($consultas)
    {
        $html = view('exports.reportes.consultas', compact('consultas'))->render();
        return $html;
    }

    /**
     * Generar PDF de reporte financiero
     */
    public static function generarReporteFinanciero($data)
    {
        $html = view('exports.reportes.financiero', $data)->render();
        return $html;
    }

    /**
     * Generar PDF de historial de paciente
     */
    public static function generarHistorialPaciente($paciente)
    {
        $html = view('exports.historial', compact('paciente'))->render();
        return $html;
    }
}
