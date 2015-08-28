<?php
class Mediastrategi_Shadowmedia_Block_Shadowmedia
    extends Mage_Core_Block_Template
{
    const COOKIE_KEY_SOURCE = 'mediastrategi_shadowmedia_source';
    public $units = array(
        'seconds'   => 1,
        'minutes'   => 60,
        'hours'     => 3600,
        'days'      => 86400,
        'weeks'     => 604800,
        'months'    => 2419200,
        'years'     => 29030400
    );

    public function _prepareLayout()
    {
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
            $this->setCanLoadTinyMce(true);
        }
        return parent::_prepareLayout();
    }

    public function getIsActive()
    {
        return Mage::getStoreConfig(
            'mediastrategi_shadowmedia/general/status'
        ) ? true : false;
    }

    public function getCookie()
    {
        return Mage::getModel('core/cookie')->get(
            self::COOKIE_KEY_SOURCE
        );
    }

    public function setCookie()
    {
        return Mage::getModel('core/cookie')->set(
            self::COOKIE_KEY_SOURCE,
            'shadowmedia',
            $this->_getCookieLifetime()
        );
    }

    public function getContent()
    {
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $content = Mage::getStoreConfig('mediastrategi_shadowmedia/content/content');
        $html = $processor->filter($content);
        echo $html;
    }

    public function getEffect()
    {
        return Mage::getStoreConfig(
          'mediastrategi_shadowmedia/design/effect'
        );
    }

    public function getFixed()
    {
        return Mage::getStoreConfig(
            'mediastrategi_shadowmedia/design/fixed'
        );
    }


    public function getCloseBtnColor()
    {
        return Mage::getStoreConfig(
          'mediastrategi_shadowmedia/design/close'
        );
    }

    public function getMaxWidth()
    {
        return Mage::getStoreConfig(
          'mediastrategi_shadowmedia/design/max-width'
        );
    }

    public function getMinWidth()
    {
        return Mage::getStoreConfig(
          'mediastrategi_shadowmedia/design/min-width'
        );
    }

    protected function _getCookieLifetime()
    {
        $unit = $this->units[Mage::getStoreConfig(
            'mediastrategi_shadowmedia/cookie/timeout_unit'
        )];

        $timeout = Mage::getStoreConfig(
            'mediastrategi_shadowmedia/cookie/timeout'
        );

        return (int)$unit * $timeout;
    }
}
