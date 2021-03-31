<?php


namespace App\Resolver;


use App\Entity\GeneralSetting;

/**
 * Class GeneralSettingResolver
 * @package App\Resolver
 */
class GeneralSettingResolver
{
    /**
     * @var GeneralSetting[]
     */
    protected $settings = [];

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * @param GeneralSetting[] $settings
     */
    public function setSettings(array $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @return GeneralSetting[]
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param $key
     * @return string|null
     */
    public function get($key)
    {
        /** @var GeneralSetting $generalSetting */
        foreach ($this->getSettings() as $generalSetting){
            if($generalSetting->getVarKey() === $key){
                return $generalSetting->getVarValue();
            }
        }
        return null;
    }

    public function getSettingItem($key)
    {
        $foundGeneralSetting = new GeneralSetting();
        /** @var GeneralSetting $generalSetting */
        foreach ($this->getSettings() as $generalSetting){
            if($generalSetting->getVarKey() === $key){
                $foundGeneralSetting = $generalSetting;
            }
        }
        return $foundGeneralSetting;
    }

    /**
     * @return string|null
     */
    public function getLogo()
    {
        return $this->get('logo');
    }

    public function getSiteUrl()
    {
        return $this->get('site_url');
    }

    public function getTwitter()
    {
        return $this->get('twitter');
    }
    public function getFacebook ()
    {
        return $this->get('facebook');
    }
    public function getInstagram ()
    {
        return $this->get('instagram');
    }
    public function getLinkedin ()
    {
        return $this->get('linkedin');
    }
    public function getYoutube ()
    {
        return $this->get('youtube');
    }
}

