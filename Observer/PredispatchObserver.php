<?php
namespace Custom\Training1_Review\Observer;

use Custom\Training1_Review\Model\CookieManager;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class PredispatchObserver
 *
 * @package Custom\Second\Observer
 */
class PredispatchObserver implements ObserverInterface
{
    /**
     * Visitor Cookie Name Const
     */
    const VISITOR_COOKIE_NAME = 'visitor_info';

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var \Custom\Training1_Review\Api\CountryDefinerInterface
     */
    private $countryDefiner;

    /**
     * @var \Custom\Training1_Review\Model\CookieManager
     */
    private $cookieManager;

    /**
     * PredispatchObserver constructor.
     *
     * @param \Psr\Log\LoggerInterface                             $logger
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
     * @param \Custom\Training1_Review\Api\CountryDefinerInterface $countryDefiner
     * @param CookieManager                                        $cookieManager
     */
    public function __construct(\Psr\Log\LoggerInterface $logger,
                                \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
                                \Custom\Training1_Review\Api\CountryDefinerInterface $countryDefiner,
                                \Custom\Training1_Review\Model\CookieManager $cookieManager
    )
    {
        $this->logger = $logger;
        $this->remoteAddress = $remoteAddress;
        $this->countryDefiner = $countryDefiner;
        $this->cookieManager = $cookieManager;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $visitorInfo = $this->cookieManager->getCookie(self::VISITOR_COOKIE_NAME);
        $this->logger->alert($visitorInfo);
        if (!$visitorInfo) {
            $userIp = $this->remoteAddress->getRemoteAddress();
            $userData = $this->countryDefiner->defineCountry($userIp);
            if ($userData) {
                $this->cookieManager->setCookie(self::VISITOR_COOKIE_NAME, json_encode($userData));
            }
            $this->logger->alert('Visitor with ip: ' . $userIp . ' Visitor Country: ' . $userData['country']);
        }
        return $this;
    }
}
