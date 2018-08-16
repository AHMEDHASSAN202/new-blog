<?php
/**
 * Created by PhpStorm.
 * User: AHMED
 */

if (!function_exists('pre')) {
    /**
     * Show Arrays || Objects
     *
     * @param $var
     */
    function pre($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

if (!function_exists('pred')) {
    /**
     * Show Arrays || Objects and Exec Script
     *
     * @param $var
     */
    function pred($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        die;
    }
}

if(!function_exists('app')) {
    /**
     * Get Instance From Application Class
     *
     * @return object
     */
    function app() {
        return \System\App::getInstance();
    }
}

if (!function_exists('array_get')) {
    /**
     * Get Value From array
     *
     * @param $array
     * @param $key
     * @param $return
     * @return bool
     */
    function array_get( array $array,$key , $return = null) {
        return $array[$key] ?? $return;
    }
}

if (!function_exists('setLink')) {
    /**
     * Set Link
     *
     * @param $link
     * @return string
     */
    function setLink($link) {
        return baseUrl() . '/' . $link;
    }
}

if (!function_exists('baseUrl')) {
    /**
     * Get Base Url
     *
     * @return mixed
     */
    function baseUrl() {
        return app()->request->baseUrl();
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect URL
     *
     * @param $url
     */
    function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }
}

if (!function_exists('adminAssets')) {
    /**
     * Admin Assets
     *
     * @param $url
     * @return string
     */
    function adminAssets($url)
    {
        return setLink('_admin/'.$url);
    }
}

if (!function_exists('imagesAssets')) {
    /**
     * Images Assets
     *
     * @param $url
     * @return string
     */
    function imagesAssets($url)
    {
        return setLink('_images/'.$url);
    }
}

if (!function_exists('imagesPath')) {
    /**
     * Images Path
     *
     * @param $path
     * @return string
     */
    function imagesPath($path)
    {
        return str_replace(['/', '\\'], DS, IMAGE_PATH . $path);
    }
}

if (!function_exists('themeAssets')) {
    /**
     * Theme Assets
     *
     * @param $url
     * @return string
     */
    function themeAssets($url)
    {
        return setLink('_theme/'.$url);
    }
}

if (!function_exists('pluginsAssets')) {
    /**
     * Theme Assets
     *
     * @param $url
     * @return string
     */
    function pluginsAssets($url)
    {
        return setLink('_plugins/'.$url);
    }
}


/**
 * Escape Html tags
 *
 * @param $value
 */
if (! function_exists('escape_tags_html')) {

    function escape_tags_html($value) {
        return htmlspecialchars($value , ENT_QUOTES , 'UTF-8');
    }
}

/**
 * Strip All Tags [html - xml - php]
 *
 * @return clean value
 */
if (! function_exists('stripTags')) {

    function stripTags($value) {
        $value = trim($value);
        return strip_tags($value);
    }
}

/**
 * Clean Input
 *
 * @return valid value
 */
if (! function_exists('cleanInput')) {

    function cleanInput($value) {
        if (is_array($value)) {
            $cleanArray = [];
            foreach ($value AS $key=>$val) {
                $cleanArray[$key] = cleanInput($val);
            }
            return $cleanArray;
        }else {
            return strip_tags(escape_tags_html($value));
        }
    }
}

/**
 * Show 4O4
 *
 * @param $titlePage
 * @param $titleCenter
 * @param $subTitle
 * @param $buttonName
 * @param $buttonUrl
 * @return mixed
 */
if (!function_exists('show_404')) {
    function show_404($titlePage=null, $titleCenter=null, $subTitle=null,$buttonName=null, $buttonUrl=null)
    {
        $data['titlePage'] = $titlePage ?? 'not found';
        $data['titleCenter'] = $titleCenter ?? '404';
        $data['subTitle'] = $subTitle ?? "This page doesn't exist";
        $data['buttonName'] = $buttonName ?? 'go to back';
        $data['buttonUrl'] = $buttonUrl ?? app()->request->referer();
        ob_start();
        extract($data);
        require VIEW_PATH . DS . 'Errors/404_page.php';
        echo ob_get_clean();
        die;
    }
}

if (!function_exists('hasPermission')) {
    /**
     * Check if User Has Permission name
     *
     * @param $name
     * @return mixed
     */
    function hasPermission($name) {
        return app()->load->model('PrivilegedUser')->hasPrivilege($name, 'name');
    }
}

if (!function_exists('showErrors')) {
    function showErrors($errors) {
        $ul = '<ul>';
        array_map(function($error) use (&$ul) {
            $ul .= '<li>'. $error .'</li>';
        }, $errors);
        $ul .= '</ul>';
        return $ul;
    }
}


if (!function_exists('diff_date')) {
    /**
     * The diff_date function returns the difference between two Date.
     *
     * @param $date
     * @return string
     */
    function diff_date($date) {
        $date1 = date_create(date('Y-m-d-h-i', time()));
        $date2 = date_create(date('Y-m-d-h-i', $date));
        $diff = date_diff($date1, $date2);
        if ($diff->y != 0) {
            $timeAgo = ($diff->y == 1) ? $diff->y . ' year' : $diff->y . ' years';
        }elseif ($diff->m != 0) {
            $timeAgo = ($diff->m == 1) ? $diff->m . ' month' : $diff->m . ' months';
        }elseif ($diff->d != 0) {
            $timeAgo = ($diff->d == 1) ? $diff->d . ' day' : $diff->d . ' days';
        }elseif ($diff->h) {
            $timeAgo = ($diff->h == 1) ? $diff->h . ' hour' : $diff->h . ' hours';
        }else {
            $timeAgo = 'a few minuets';
        }
        return $timeAgo;
    }
}