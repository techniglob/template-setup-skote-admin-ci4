<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
class CommonController extends BaseController
{
    
    public function sessionFlash()
    {
        return $this->response->setJSON([
            'status' => session()->getFlashdata('status'),
            'message' => session()->getFlashdata('message'),
        ]);
        
    }

    public function file()
    {
        $fileName = $this->request->getVar('str') ?? null;
        $writablePath = WRITEPATH . 'uploads/';
        $rootPath = ROOTPATH . 'public/default/';

        // Validate filename
        if (empty($fileName)) {
            return $this->response->setStatusCode(400)->setBody('Invalid file request');
        }

        // Get full file path
        $fullPath = $writablePath . $fileName;

        // Check if file exists
        if (is_file($fullPath)) {
            $file = new \CodeIgniter\Files\File($fullPath, true);
            // Serve HLS files correctly
            if (strpos($fileName, '.m3u8') !== false) {
                $mimeType = 'application/vnd.apple.mpegurl';
            } elseif (strpos($fileName, '.ts') !== false) {
                $mimeType = 'video/mp2t';
            } else {
                $mimeType = $file->getMimeType();
            }

            return $this->response
                ->setHeader('Content-Type', $mimeType)
                ->setHeader('Access-Control-Allow-Origin', '*') // Fix CORS issues
                ->setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS')
                ->setHeader('Access-Control-Allow-Headers', 'Range')
                ->setHeader('Content-Disposition', 'inline; filename="' . $file->getBasename() . '"')
                ->setStatusCode(200)
                ->setBody(file_get_contents($fullPath));
        }else{
            $emptyImagePath = $rootPath . 'empty.png';
            $file = new \CodeIgniter\Files\File($emptyImagePath, true);
            $binary = readfile($emptyImagePath);

            return $this->response
                    ->setHeader('Content-Type', $file->getMimeType())
                    ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
                    ->setStatusCode(200)
                    ->setBody($binary);
        }

        // File not found
        return $this->response->setStatusCode(404)->setBody('File not found');
    }
}
