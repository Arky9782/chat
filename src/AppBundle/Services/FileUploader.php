<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.12.2017
 * Time: 18:38
 */

namespace AppBundle\Services;




use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FileUploader
{

    public function getFile($uploadedFile)
    {
        $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();

        $uploadedFile->move('files_directory', $filename);

        $path = '/files_directory/'.$filename;

        return $path;

    }

}