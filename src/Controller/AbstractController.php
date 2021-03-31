<?php


namespace App\Controller;

use App\Entity\GeneralSetting;
use App\Resolver\GeneralSettingResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;


abstract class AbstractController extends BaseAbstractController
{
    /**
     * @return GeneralSettingResolver
     */
    protected function getSettings()
    {
        $em =$this->getDoctrine()->getManager();
        $settings = $em->getRepository(GeneralSetting::class)->findAll();
        return new GeneralSettingResolver($settings);
    }
}