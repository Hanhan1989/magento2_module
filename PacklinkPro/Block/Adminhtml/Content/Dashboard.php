<?php
/**
 * @package    Packlink_PacklinkPro
 * @author     Packlink Shipping S.L.
 * @copyright  2020 Packlink
 */

namespace Packlink\PacklinkPro\Block\Adminhtml\Content;

use Magento\Backend\Block\Template;
use Magento\Framework\Module\ModuleListInterface;
use Packlink\PacklinkPro\Bootstrap;
use Packlink\PacklinkPro\Helper\UrlHelper;
use Packlink\PacklinkPro\IntegrationCore\BusinessLogic\Configuration;
use Packlink\PacklinkPro\IntegrationCore\Infrastructure\ServiceRegister;
use Packlink\PacklinkPro\Services\BusinessLogic\ConfigurationService;

/**
 * Class Dashboard
 *
 * @package Packlink\PacklinkPro\Block\Adminhtml\Content
 */
class Dashboard extends Content
{
    /**
     * List of help URLs for different country codes.
     *
     * @var array
     */
    private static $helpUrls = [
        'ES' => 'https://support-pro.packlink.com/hc/es-es/sections/202755109-Prestashop',
        'DE' => 'https://support-pro.packlink.com/hc/de/sections/202755109-Prestashop',
        'FR' => 'https://support-pro.packlink.com/hc/fr-fr/sections/202755109-Prestashop',
        'IT' => 'https://support-pro.packlink.com/hc/it/sections/202755109-Prestashop',
    ];
    /**
     * List of terms and conditions URLs for different country codes.
     *
     * @var array
     */
    private static $termsAndConditionsUrls = [
        'ES' => 'https://pro.packlink.es/terminos-y-condiciones/',
        'DE' => 'https://pro.packlink.de/agb/',
        'FR' => 'https://pro.packlink.fr/conditions-generales/',
        'IT' => 'https://pro.packlink.it/termini-condizioni/',
    ];
    /**
     * @var ModuleListInterface
     */
    protected $moduleList;

    /**
     * Dashboard constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Packlink\PacklinkPro\Bootstrap $bootstrap
     * @param \Packlink\PacklinkPro\Helper\UrlHelper $urlHelper
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Bootstrap $bootstrap,
        UrlHelper $urlHelper,
        ModuleListInterface $moduleList,
        array $data = []
    ) {
        parent::__construct($context, $bootstrap, $urlHelper, $data);

        $this->moduleList = $moduleList;
    }

    /**
     * Returns URL for help documentation in user's preferred language.
     *
     * @return string
     */
    public function getHelpUrl()
    {
        $locale = $this->getUserLocale();

        return self::$helpUrls[$locale];
    }

    /**
     * Returns URL for Packlink terms and conditions in user's preferred language.
     *
     * @return string
     */
    public function getTermsAndConditionsUrl()
    {
        $locale = $this->getUserLocale();

        return self::$termsAndConditionsUrls[$locale];
    }

    /**
     * Returns current plugin version.
     *
     * @return string
     */
    public function getPluginVersion()
    {
        return $this->moduleList->getOne('Packlink_PacklinkPro')['setup_version'];
    }

    /**
     * Returns user's country code (locale).
     *
     * @return string
     */
    private function getUserLocale()
    {
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        $userInfo = $configService->getUserInfo();
        $locale = 'ES';

        if ($userInfo !== null && array_key_exists($userInfo->country, self::$helpUrls)) {
            $locale = $userInfo->country;
        }

        return $locale;
    }
}
