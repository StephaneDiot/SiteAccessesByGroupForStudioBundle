<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ez\SiteAccessGroupStudioBundle\ApplicationConfig\Providers;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use EzSystems\StudioUIBundle\SiteAccess\ReverseMatcher;

class SiteAccesses
{
    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface */
    private $configResolver;

    /** @var \EzSystems\StudioUIBundle\SiteAccess\ReverseMatcher */
    private $reverseMatcher;

    /** @var array */
    private $siteAccessList;

    /** @var array */
    private $siteAccessGroups;

    /** @var \eZ\Publish\Core\MVC\Symfony\SiteAccess */
    private $currentSiteAccess;

    private $requestStack;

    /**
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     * @param array $siteAccessList
     * @param \EzSystems\StudioUIBundle\SiteAccess\ReverseMatcher $reverseMatcher
     */
    public function __construct(ConfigResolverInterface $configResolver, array $siteAccessList, ReverseMatcher $reverseMatcher, array $siteAccessGroups = null,  $siteaccess,  $requestStack)
    {
        $this->configResolver = $configResolver;
        $this->siteAccessList = $siteAccessList;
        $this->reverseMatcher = $reverseMatcher;
        $this->siteAccessGroups = $siteAccessGroups;
        $this->currentSiteAccess = $siteaccess;
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $request = $this->requestStack->getMasterRequest();
        $siteAccesses = [];
        $siteAccessesFromCurrentGroup = $this->getSiteaccessesByGroup();

        foreach ($siteAccessesFromCurrentGroup as $siteaccessElement) {
            if ($this->configResolver->hasParameter('languages', null, $siteaccessElement)) {
                $siteAccesses[$siteaccessElement]['languages'] = $this->configResolver->getParameter('languages', null, $siteaccessElement);
            }
            $siteAccesses[$siteaccessElement]['urlRoot'] = $this->reverseMatcher->getUrlRoot($siteaccessElement);
        }

        return $siteAccesses;
    }

    /**
     * Gets a list of siteaccesses grouped by siteaccess group.
     *
     * @return array
     */
    private function getSiteaccessesByGroup()
    {
        $currentGroupSiteaccesses = [];
        foreach ($this->siteAccessGroups as $siteaccessGroup) {
            if (in_array($this->currentSiteAccess->name, $siteaccessGroup)) {
                foreach ($siteaccessGroup as $siteaccessElement) {
                    array_push($currentGroupSiteaccesses, $siteaccessElement);
                }
            }
        }
        return array_unique($currentGroupSiteaccesses);
    }
}
