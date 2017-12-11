<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.12.2017
 * Time: 18:51
 */

namespace AppBundle\Services;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlGen
{
    private $URL;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->URL = $generator;
    }

    public function genUrl()
    {
        $URL = '/files_directory/';

        return $URL;
    }

}