<?php

namespace navbuilderjz;

class Navbuilder
{
    protected $navBuilder;

    public function __construct($navArray)
    {
        $this->navBuilder = '<ul class="nav navbar-nav">'.self::arrayLoop($navArray, array()).'</ul>';
    }

    protected function removeKeySlash($text)
    {
        return preg_replace('/\//', '-', $text);
    }

    protected function textReplace($text) {
        $replace[] = '/&/';

        $replacement[] = '&amp;';

        return preg_replace($replace, $replacement, $text);
    }

    protected function replaceChar($text)
    {
        $replace[] = '/\(.*?\)/';
        $replace[] = '/&/';
        $replace[] = '/ +/';
        $replace[] = '/~/';

        $replacement[] = '';
        $replacement[] = '';
        $replacement[] = ' ';
        $replacement[] = '/';

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
        return '<a href="/'.self::urlFix($url).'" '.self::addDropdownToLink($text).'>'.self::textReplace($text).'</a>';
    }

    protected function addDropdownToLi($key, $value) {
        return 'class="dropdown"';
    }

    protected function addDropdownToLink($key) {
        $innerLink = 'class="dropdown-toggle" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
        return 'class="'.self::urlFix(self::replaceChar(self::removeKeySlash($key))).'"';
    }

    protected function addDropdownToMenu($key, $value) {
        return 'class="dropdown-menu" aria-labelledby="'.self::urlFix(self::replaceChar($key)).'"';
    }

    public function loopRecursive($newValue, $basePath, $build = null) {
        $build .= '<ul>';
        foreach ($newValue as $newKey => $newValue) {
            if (is_string($newKey)) {
                $path = self::removeKeySlash($basePath.'~'.$newKey);
                $build .= '<li>'.self::linkReplace($path, $newKey);
            }
            if (is_numeric($newKey)) {
                $path = self::removeKeySlash($basePath.'~'.$newValue);
                $build .= '<li>'.self::linkReplace($path, $newValue);
            }

            if (is_array($newValue)) {
                $path = self::removeKeySlash($basePath.'~'.$newKey);
                $build = self::loopRecursive($newValue, $path, $build);
            }
        }
        $build .= '</ul></li>';

        return $build;
    }

    protected function arrayLoop($navVal, $tryArray) {
        $navBuild = '';
        $dropDown = '';

        foreach ($navVal as $key => $value) {
            if (is_array($value)) {
                if (is_string($key)) {
                    $dropDown = self::addDropdownToLi($key, $value);
                    $navBuild .= '<li '.$dropDown.'>'.self::linkReplace(self::removeKeySlash($key), $key);
                }

                if (is_array($value)) {
                    $navBuild .= self::loopRecursive($value,$key);
                }
            }
        }

        return $navBuild;
    }

    public function __toString()
    {
        return $this->navBuilder;
    }
}
