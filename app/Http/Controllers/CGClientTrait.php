<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

/**
 * CGClient methods for Controller
 * For Congraph CMS page meta data
 */
trait CGClientTrait
{
    protected $allLocales = null;
    protected $locale = null;
    
    protected function getPageByUrl($requestUrl, $requestLocale)
    {

        $pages = $this->getPages();
        
        foreach ($pages as &$entity) {
            foreach ($entity['urls'] as $locale => $url) {
                // var_dump($url);
                if ($locale == $requestLocale && trim($url, '/') == $requestUrl) {
                    return $entity;
                }
            }
        }
        
        return false;
    }

    protected function getPages()
    {
        $useCache = Config::get('cg.api.use_cache');
        $cacheDuration = Config::get('cg.api.cache_duration');

        if (!$useCache) {
            return $this->getPagesFromAPI();
        }

        if ($cacheDuration == 0) {
            $value = Cache::rememberForever('pages', function () {
                return $this->getPagesFromAPI();
            });
            return $value;
        }
        
        $value = Cache::remember('pages', $cacheDuration, function () {
            return $this->getPagesFromAPI();
        });

        return $value;
    }

    protected function getPagesFromAPI()
    {
        $apiUrl = Config::get('cg.api.api_url');
        if (empty($apiUrl)) {
            return false;
        }
        
        $getPagesHref = Config::get('cg.api.pages_href');
        if (empty($getPagesHref)) {
            return false;
        }

        $client = new \GuzzleHttp\Client(['base_uri' => $apiUrl]);
        $response = $client->request('GET', $getPagesHref);
        $body = $response->getBody();
        $response = json_decode($body, true);
        $data = $response['data'];

        foreach ($data as &$entity) {
            $urls = $this->setUrls($entity, $data);
            $entity['urls'] = $urls;
        }

        return $data;
    }

    protected function fetchLocales()
    {
        $useCache = Config::get('cg.api.use_cache');
        $cacheDuration = Config::get('cg.api.cache_duration');

        if (!$useCache) {
            return $this->fetchLocalesFromAPI();
        }

        if ($cacheDuration == 0) {
            $value = Cache::rememberForever('locales', function () {
                return $this->fetchLocalesFromAPI();
            });
            return $value;
        }
        
        $value = Cache::remember('locales', $cacheDuration, function () {
            return $this->fetchLocalesFromAPI();
        });

        return $value;
    }

    protected function fetchLocalesFromAPI()
    {
        $apiUrl = Config::get('cg.api.api_url');
        if (empty($apiUrl)) {
            return false;
        }
        
        $getLocalesHref = 'locales';

        $client = new \GuzzleHttp\Client(['base_uri' => $apiUrl]);
        $response = $client->request('GET', $getLocalesHref);
        $body = $response->getBody();
        $response = json_decode($body, true);

        $data = $response['data'];

        return $data;
    }

    protected function getLocales()
    {
        if ($this->allLocales === null) {
            $this->allLocales = $this->fetchLocales();
        }

        return $this->allLocales;
    }

    protected function getLocaleCodes()
    {
        if ($this->allLocales === null) {
            $this->fetchLocales();
        }

        $codes = [];
        foreach ($this->allLocales as $locale) {
            $codes[] = $locale['code'];
        }

        return $codes;
    }

    protected function getLocaleByCode($code)
    {
        foreach ($this->getLocales() as $locale) {
            if ($locale['code'] == $code) {
                return $locale;
            }
        }

        return false;
    }

    protected function cleanRouteSegments($segments)
    {
        $newSegments = [];
        foreach ($segments as $segment) {
            if(!empty($segment)) {
                $newSegments[] = $segment;
            }
        }

        return $newSegments;
    }

    
    /**
     * Parse URL
     * @param  string $url
     * @return array
     */
    protected function parseUrl($url = null)
    {
        if (empty($url)) {
            $url = Request::path();
        }
        
        $url = urldecode($url);
        $url = trim($url, '/');
        $route_segments = explode('/', $url);

        $route_segments = $this->cleanRouteSegments($route_segments);

        $defaultLocale = Config::get('cg.pagemeta.default_locale');
        $useLocalizedDomains = Config::get('cg.pagemeta.use_localized_domains');
        $localizedDomains = Config::get('cg.pagemeta.localized_domains');



        if ($useLocalizedDomains && !empty($localizedDomains) && array_key_exists($this->domain, $localizedDomains)) {
            $defaultLocale = $localizedDomains[$this->domain]['locale'];
        } else {
            $localeInUrl = true;

            if(empty($route_segments)) {
                $localeInUrl = false;
                $default_locale = $defaultLocale;
                $language = $this->getLocaleByCode($default_locale);
            } else {
                $locale = $route_segments[0];
                $language = $this->getLocaleByCode($locale);
            }
            

            if (! $language) {
                $localeInUrl = false;
                $default_locale = $defaultLocale;
                $language = $this->getLocaleByCode($default_locale);
            }
        }

        $this->locale = $language;

        // var_dump($this->locale);
        // var_dump($localeInUrl);

        if (empty($this->locale)) {
            App::abort(404);
        }

        if ($localeInUrl) {
            array_splice($route_segments, 0, 1);
        }

        if (empty($route_segments)) {
            $homeUrl = Config::get('cg.pagemeta.' . $this->locale['code'] . '.home_url');
            $home_url = $homeUrl;
            $home_segments = explode('/', $home_url);
            // array_splice($home_segments, 0, 1);
            $route_segments = $home_segments;
        }

        $url = $this->locale['code'] . '/' . implode('/', $route_segments);
        
        $locale = $defaultLocale;
        return [
            $url,
            $this->locale['code'],
            $route_segments,
        ];
    }



    protected function slugify($text)
    {
        if (is_array($text)) {
            $slugs = [];
            foreach ($text as $locale => $value) {
                $slug = $this->slugify($value);
                $slugs[$locale] = $slug;
            }
            return $slugs;
        }

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove everything that's not alphanumeric or space
        $text = preg_replace('/[^A-Za-z0-9 ]/', '', $text);
        
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d\w]+~u', '-', $text);


        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    protected function setUrls($entity, $data)
    {
        
        // get slug
        // get attribute by primary attribute
        $attributeName = $entity['primary_field'];
        $localizedTitle = [];
        $title = $entity['fields'][$attributeName];
    
        $locales = $this->getLocaleCodes();
        foreach ($locales as $localeCode) {
            if (is_array($title) && array_key_exists($localeCode, $title)) {
                $localizedTitle[$localeCode] = $title[$localeCode];
            } elseif (is_string($title)) {
                $localizedTitle[$localeCode] = $title;
            } else {
                $localizedTitle[$localeCode] = null;
            }
        }
        
        $slugs = $this->slugify($localizedTitle);

        // get parent
        $parentKeys = Config::get('cg.pagemeta.parent_keys');
        $parentUrls = [];
        $hasParent = false;
        foreach ($parentKeys as $parentKey) {
            // var_dump($parentKey);
            if (array_key_exists($parentKey, $entity['fields'])) {
                // var_dump('parent exists');
                $parent = $entity['fields'][$parentKey];
                // var_dump($parent);

                if (is_array($parent) && array_key_exists('id', $parent) && $parent['id']) {
                    $parent = $this->findById($parent['id'], $data);
                    // set parent url
                    if ($parent) {
                        $parentUrls = $this->setUrls($parent, $data);
                    }
                }
            }
        }

        $defaultParents = [];
        foreach ($this->getLocales() as $locale) {
            $parents = Config::get('cg.pagemeta.' . $locale['code'] . '.default_parents');
            if (!empty($parents)) {
                $defaultParents[$locale['code']] = $parents;
            }
        }

        if (!empty($defaultParents)) {
            // var_dump('has_default_parents');
            $defaultParentUrls = [];
            foreach ($defaultParents as $locale => $routes) {
                foreach ($routes as $parentUrl => $attributeSets) {
                    foreach ($attributeSets as $attributeSet) {
                        if ($entity['attribute_set_code'] == $attributeSet) {
                            $defaultParentUrls[$locale] = $locale . '/' . $parentUrl;
                        }
                    }
                }
            }
        }

        // set url
        // parent url + slug
        $urls = [];
        foreach ($slugs as $locale => &$slug) {
            if ($slug === null || !array_key_exists($locale, $entity['status'])) {
                $urls[$locale] = null;
                continue;
            }
            
            if (array_key_exists($locale, $parentUrls)) {
                // var_dump('parent exists');
                $urls[$locale] = $parentUrls[$locale] . '/' . $slug;
                continue;
            }

            if ($defaultParentUrls && array_key_exists($locale, $defaultParentUrls)) {
                // var_dump('parent exists');
                $urls[$locale] = $defaultParentUrls[$locale] . '/' . $slug;
                continue;
            }

            $urls[$locale] = $locale . '/' . $slug;
        }

        return $urls;
        // return url;
    }
    
    protected function findById($id, $data)
    {
        foreach ($data as $entity) {
            if (is_array($entity) && array_key_exists('id', $entity) && $entity['id'] == $id) {
                return $entity;
            }
        }

        return false;
    }
}
