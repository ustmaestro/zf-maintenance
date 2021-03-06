<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\View\Helper;

use Jgut\Zf\Maintenance\Provider\ProviderInterface;

/**
 * Allows to retrieve active maintenance mode message
 */
class MaintenanceMessage extends AbstractHelper
{
    /**
     * Get maintenance mode message if maintenance is On
     *
     * @return string
     */
    public function __invoke()
    {
        if (!count($this->providers)) {
            return '';
        }

        $helperManager  = $this->getServiceLocator();
        $serviceManager = $helperManager->getServiceLocator();

        foreach (array_keys($this->providers) as $providerName) {
            if ($serviceManager->has($providerName)) {
                $provider = $serviceManager->get($providerName);
                if ($provider instanceof ProviderInterface && $provider->isActive()) {
                    return $provider->getMessage();
                }
            }
        }

        return '';
    }
}
