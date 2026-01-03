<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * PdfController
 * Handles PDF viewing with PDF.js integration
 */
class PdfController extends Controller
{
    /**
     * Display PDF viewer with PDF.js
     * @param string $filename The PDF filename (from public/uploads/pdf or books folder)
     */
    public function view($filename = null)
    {
        // Allow framing for virtual browser
        header('X-Frame-Options: ALLOWALL');
        header('Content-Security-Policy: frame-ancestors *');
        
        if (!$filename) {
            return $this->response->setStatusCode(404)->setBody('PDF not found');
        }
        
        // Sanitize filename
        $filename = basename($filename);
        
        // Check multiple possible locations
        $possiblePaths = [
            FCPATH . 'uploads/pdf/' . $filename,
            FCPATH . 'uploads/books/' . $filename,
            FCPATH . 'assets/pdf/' . $filename,
            WRITEPATH . 'uploads/' . $filename,
        ];
        
        $pdfPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $pdfPath = $path;
                break;
            }
        }
        
        // Generate URL for PDF.js
        $pdfUrl = $pdfPath ? base_url('pdf/stream/' . $filename) : null;
        
        return view('pdf/viewer', [
            'filename' => $filename,
            'pdfUrl' => $pdfUrl,
            'title' => pathinfo($filename, PATHINFO_FILENAME)
        ]);
    }
    
    /**
     * Stream PDF file with proper headers
     * @param string $filename
     */
    public function stream($filename = null)
    {
        // Allow framing
        header('X-Frame-Options: ALLOWALL');
        header('Content-Security-Policy: frame-ancestors *');
        header('Access-Control-Allow-Origin: *');
        
        if (!$filename) {
            return $this->response->setStatusCode(404);
        }
        
        $filename = basename($filename);
        
        $possiblePaths = [
            FCPATH . 'uploads/pdf/' . $filename,
            FCPATH . 'uploads/books/' . $filename,
            FCPATH . 'assets/pdf/' . $filename,
            WRITEPATH . 'uploads/' . $filename,
        ];
        
        $pdfPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $pdfPath = $path;
                break;
            }
        }
        
        if (!$pdfPath) {
            return $this->response->setStatusCode(404)->setBody('PDF file not found');
        }
        
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setHeader('Content-Length', filesize($pdfPath))
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($pdfPath));
    }
    
    /**
     * Demo PDF viewer with sample content
     */
    public function demo()
    {
        header('X-Frame-Options: ALLOWALL');
        header('Content-Security-Policy: frame-ancestors *');
        
        return view('pdf/viewer', [
            'filename' => 'demo.pdf',
            'pdfUrl' => 'https://mozilla.github.io/pdf.js/web/compressed.tracemonkey-pldi-09.pdf',
            'title' => 'PDF Demo'
        ]);
    }
}
