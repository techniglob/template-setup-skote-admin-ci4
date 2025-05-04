<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\AvatarGenerator;
class FileController extends BaseController
{
    public function getFile($filename)
    {
        $path = WRITEPATH . 'uploads/';
        $fullpath = $path . $filename;
        if(is_file($fullpath)){
            $file = new \CodeIgniter\Files\File($fullpath, true);
            $binary = readfile($fullpath);
            return $this->response
                    ->setHeader('Content-Type', $file->getMimeType())
                    ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
                    ->setStatusCode(200)
                    ->setBody($binary);
        }

        return null;
        
    }

    public function show($name = 'Pritam Khan')
    {
        $avatar = new AvatarGenerator();
        return $avatar->generateFromName(urldecode($name));
    }
}
