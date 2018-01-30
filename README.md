# SiteAccessesByGroupForStudioBundle

## Description

This bundle allows you to display only the siteaccesses of the group where belongs your current siteaccess.

## Installation

1. Put the bundle in the 'src' folder of your install
2. Register the bundle AND MAKE SURE IT'S REGISTETERED AFTER 'EzSystemsStudioUIBundle' by adding ``` new Ez\SiteAccessGroupStudioBundle\EzSiteAccessGroupStudioBundle(), ```
3. Update your 'routing.yml' with 
``` 
ez_site_access_group_studio:
    resource: "@EzSiteAccessGroupStudioBundle/Resources/config/routing.yml"
    prefix:   / 
 ```
 ## How to use
 
 The first point is that you need to have your siteaccesses matching by 'Map\Host' matcher. 
 Note that In eZ Enterprise, when using the Map\Host matcher, you need to provide the following line in your Twig template (e.g. in the head of the main template file): ```{{ multidomain_access() }}```
 Of course you can still use compounded site access matcher.
 
 Now you can connect to your back office using different host name. And when accessing studio you will only see the siteaccesses present in the group(s) of the siteaccess which match your hostname
 
 For example:
 
 With such a conf:
 ```
 siteaccess:
        list: [site, fr1, fr2]
        groups:
            site_group: [site]
            fra: [fr1, fr2]
        default_siteaccess: site
        match:
            Map\Host:
                main: site
                fre: fr1
                fre2: fr2
   ```
   By connecting to 'http://fre', you'll only see 'fr1' and 'fr2' siteaccesses in studio
   or when accessing 'http://main', you'll only see 'site' siteaccess in studio
   
