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

class FileNameGen
{

    public function genFileName()
    {

        $filename = md5(uniqid()).'.'.$_FILES['file']['name'];

        return $filename;
    }

}