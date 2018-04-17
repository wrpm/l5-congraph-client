<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

/**
 * SEO methods for Controller
 * For CMS Version -assets
 */
trait SEOTrait
{
    use CGClientTrait;
    
    protected $pageLocale;

    /**
     * Get meta data for export in template
     *
     * @param  [type] $pageData [description]
     * @return [type]           [description]
     */
    protected function getPageMeta($pageData)
    {
        $meta = array();

        $this->pageLocale = $this->locale['code'];

        // Meta Title
        // ---------------------------------------------
        $meta['meta_title'] = $this->getMetaTitle($pageData);
        $meta['meta_description'] = $this->getMetaDescription($pageData);
        $meta['meta_keywords'] = $this->getMetaKeywords($pageData);

        // merge with og meta
        $meta = array_merge($meta, $this->getOpenGraphMeta($pageData, $meta));

        return $meta;
    }

    protected function getMetaTitle($pageData)
    {
        // $isProject = $pageData['type'] == 'project';

        $defaultMetaTitle = Config::get('cg.pagemeta.' . $this->pageLocale . '.default_meta_title', '');
        $attributeKey = Config::get('cg.pagemeta.meta_title_key', 'meta_title');

        $metaTilteParts = [];

        $metaTitle = $this->getPageDataAttribute($attributeKey, $pageData);

        if (empty($metaTitle)) {
            $metaTitle = $this->getPrimaryAttribute($pageData);

            if (empty($metaTitle)) {
                $metaTitle = $defaultMetaTitle;
            }
        }

        if (!Config::get('cg.pagemeta.' . $this->pageLocale . '.use_meta_title_prefix', false)) {
            return $metaTitle;
        }
        
        $metaTitlePrefix = Config::get('cg.pagemeta.' . $this->pageLocale . '.meta_title_prefix', '');

        return sprintf(
            "%s - %s",
            $metaTitlePrefix,
            $metaTitle
        );
    }

    protected function getPrimaryAttribute($entity)
    {
        $primaryAttributeKey = $entity['primary_field'];
        if (isset($entity['fields'][$primaryAttributeKey])) {
            $value = $entity['fields'][$primaryAttributeKey];
            if (is_string($value)) {
                return $value;
            }
        }

        return '';
    }

    protected function getMetaDescription($pageData)
    {
        $defaultMetaDesc = Config::get('cg.pagemeta.' . $this->pageLocale . '.meta_description', '');
        $attributeKey = Config::get('cg.pagemeta.meta_description_key', 'meta_description');

        $metaDesc = $this->getPageDataAttribute($attributeKey, $pageData);

        if (empty($metaDesc)) {
            $metaDesc = $defaultMetaDesc;
        }

        // @todo get excerpt or something like that
        return $metaDesc;
    }

    protected function getMetaKeywords($pageData)
    {
        $defaultMetaKeywords = Config::get('cg.pagemeta.' . $this->pageLocale . '.meta_keywords', '');
        $attributeKey = Config::get('cg.pagemeta.meta_keywords_key', 'meta_keywords');

        $metaKeywords = $this->getPageDataAttribute($attributeKey, $pageData);

        if (empty($metaKeywords)) {
            $metaKeywords = $defaultMetaKeywords;
        }

        return $metaKeywords;
    }

    // Open Graph
    // -------------------------------------------------------------------
    /**
     * The Open Graph protocol enables any web page to become a rich object in a social graph
     * see more at http://ogp.me/
     */

    protected function getOpenGraphMeta($pageData)
    {
        $ogMeta = [];

        $ogMeta['og_title'] = $this->getOpenGrapTitle($pageData);
        $ogMeta['og_description'] = $this->getOpenGrapDescription($pageData);
        $ogMeta['og_type'] = $this->getOpenGrapType($pageData);
        $ogMeta['og_site_name'] = $this->getOpenGrapSiteName($pageData);
        $ogMeta['og_url'] = $this->getOpenGrapUrl($pageData);
        $ogMeta['og_image'] = $this->getOpenGrapImage($pageData);
        $ogMeta['og_locale'] =  $this->getOpenGrapLocale($pageData);
        
        return $ogMeta;
    }

    protected function getOpenGrapTitle($pageData)
    {
        return $this->getMetaTitle($pageData);
    }

    protected function getOpenGrapDescription($pageData)
    {
        return $this->getMetaDescription($pageData);
    }

    protected function getOpenGrapType($pageData)
    {
        $path = Request::path();

        // for root / homepage
        if ($path == '/'
            || $path == Config::get('cg.pagemeta.default_locale')
            || $path == Config::get('cg.pagemeta.home_url')) {
            return 'website';
        }
        
        // for page
        return 'article';
    }

    protected function getOpenGrapSiteName($pageData)
    {
        return Config::get('cg.pagemeta.' . $this->pageLocale . '.site_name', '');
    }

    protected function getOpenGrapUrl($pageData)
    {
        return Request::url();
    }

    protected function getOpenGrapImage($pageData)
    {
        $imageKey = Config::get('cg.pagemeta.og_image_key');
        $imageVersion = Config::get('cg.pagemeta.og_image_version', '');

        // 1. try custom image
        $imageObject = $this->getPageDataAttribute($imageKey, $pageData);

        $apiUrl = Config::get('cg.api.api_url');

        if (!empty($imageObject) && is_array($imageObject) && array_key_exists('url', $imageObject)) {
            $imageUrl = $apiUrl . $imageObject['url'];

            if (!empty($imageVersion)) {
                $imageUrl .= '?v=' . $imageVersion;
            }
            return $imageUrl;
        }

        // 2. try config
        $defaultImage = Config::get('cg.pagemeta.default_og_image', null);
        if (!empty($defaultImage)) {
            return $defaultImage;
        }

        return null;
    }

    protected function getOpenGrapLocale($pageData)
    {
        return $this->pageLocale;
    }


    private function getPageDataAttribute($key, $pageData)
    {
        if (!array_key_exists($key, $pageData['fields'])) {
            return '';
        }

        $value = $pageData['fields'][$key];

        if (empty($value) || !is_string($value)) {
            return '';
        }

        return $value;
    }
}
