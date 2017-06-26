<?php
namespace Custom\Training1_Review\Model;

use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class CookieManager
 *
 * @package Custom\Training1_Review\Model
 */
class CookieManager
{
    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */

    protected $cookieMetadataFactory;

    /**
     * Name of cookie that holds private content version
     */

    public function __construct(
            \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
            \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory
    )
    {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
    }

    /**
     * @param $name
     * @return null|string
     */
    public function getCookie($name)
    {
        return $this->cookieManager->getCookie($name);
    }

    /**
     * @param     $name
     * @param     $value
     * @param int $duration
     */
    public function setCookie($name, $value, $duration = 7200)
    {
        $metadata = $this->cookieMetadataFactory
                ->createPublicCookieMetadata()
                ->setDuration($duration)
                ->setPath('/');
        $this->cookieManager->setPublicCookie(
                $name,
                $value,
                $metadata
        );
    }
}
