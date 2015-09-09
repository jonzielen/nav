<?php

namespace navbuilderjz;

class Navbuilder
{
    protected $navBuilder;

    public function __construct($navArray)
    {
        $this->navBuilder = '<ul class="nav navbar-nav">'.self::buildNav('', $navArray).'</ul>';
        self::arrayLoop($navArray);
    }

    protected function removeKeySlash($text)
    {
        return preg_replace('/\//', '-', $text);
    }

    protected function replaceChar($text)
    {
        $replace[] = '/\(.*?\)/';
        $replace[] = '/&/';
        $replace[] = '/ +/';

        $replacement[] = '';
        $replacement[] = '';
        $replacement[] = ' ';

        $text = preg_replace($replace, $replacement, $text);

        if (substr($text, -1) == ' ') {
            return rtrim($text, ' ');
        } else {
            return $text;
        }
    }

    protected function urlFix($title)
    {
        $title = self::replaceChar($title);

        return str_replace(' ', '-', strtolower($title));
    }

    protected function linkReplace($url, $text)
    {
        return '<a href="'.self::urlFix($url).'">'.$text.'</a>';
    }

    protected function buildNav($baseUrl, $navVal)
    {
        $navBuild = '';

        foreach ($navVal as $key => $value) {
            if (is_string($key)) {
                $navBuild .= '<li>'.self::linkReplace($baseUrl.self::removeKeySlash($key), $key).'';
                $baseUrl .= $key.'/';
            }

            if (is_numeric($key)) {
                $navBuild .= '<li>'.self::linkReplace($baseUrl.self::removeKeySlash($value), $value).'</li>';
            }

            if (is_array($value)) {
                $navBuild .= '<ul>'.self::buildNav($baseUrl, $value).'</ul></li>';
                //$baseUrl = '';
            }
        }

        return $navBuild;
    }

    protected function arrayLoop($navVal) {
        echo '<pre>';
        //print_r($navVal);
        echo '</pre>';

        function moreLoop($navVal, $tryArray = []) {

            foreach ($navVal as $key => $value) {
                if (is_string($key)) {
                    echo $key.'<br>';
                    $tryArray[] = $key;
                }

                if (is_numeric($key)) {
                    echo $value.'<br>';
                    $tryArray[] = $value;
                }


                if (is_array($value)) {
                    moreLoop($value, $tryArray);
                }
            }
        }

        moreLoop($navVal, '');
    }

    public function __toString()
    {
        return $this->navBuilder;
    }
}
