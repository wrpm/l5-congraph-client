<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

class FrontController extends Controller
{
    use SEOTrait;

    // Public Functions
    // -------------------------------------------------------------------------

    public function getIndex()
    {
        
        // ----- OLD CTRL ------

        list($url, $locale, $segments) = $this->parseUrl(Request::path());
        
        $entity = $this->getPageByUrl($url, $locale);

        if (!$entity) {
            $pageMetaData = [
                'meta_title' =>  '404 - Not Found'
            ];

            return view('application', ['meta' => $pageMetaData, 'entity' => []]);

            // App::abort(404);
        }

        // get page meta data
        $pageMetaData = $this->getPageMeta($entity);
        
        // echo '<pre>';
        // print_r($pageMetaData);
        // echo '</pre>';
        
        // echo '<pre>';
        // print_r($entity);
        // echo '</pre>';

        return view('application', ['meta' => $pageMetaData, 'entity' => $entity]);
    }
}
