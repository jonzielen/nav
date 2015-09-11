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
        return '<a href="/'.self::urlFix($url).'">'.$text.'</a>';
    }

    protected function arrayLoop($navVal, $tryArray) {
        $navBuild = '';

        foreach ($navVal as $key => $value) {
            if (is_array($value)) {
                if (is_string($key)) {
                    $navBuild .= '<li>'.self::linkReplace(self::removeKeySlash($key), $key);
                }

                if (is_array($value)) {
                    $navBuild .= '<ul>';
                    foreach ($value as $newKey => $newValue) {
                        if (is_string($newKey)) {
                            $path = self::removeKeySlash($key.'~'.$newKey);
                            $navBuild .= '<li>'.self::linkReplace($path, $newKey);
                        }
                        if (is_numeric($newKey)) {
                            $path = self::removeKeySlash($key.'~'.$newValue);
                            $navBuild .= '<li>'.self::linkReplace($path, $newValue);
                        }

                        if (is_array($newValue)) {
                            $navBuild .= '<ul>';
                            foreach ($newValue as $newKey2 => $newValue2) {
                                if (is_string($newKey2)) {
                                    $path = self::removeKeySlash($key.'~'.$newKey.'~'.$newKey2);
                                    $navBuild .= '<li>'.self::linkReplace($path, $newKey2);
                                }
                                if (is_numeric($newKey2)) {
                                    $path = self::removeKeySlash($key.'~'.$newKey.'~'.$newValue2);
                                    $navBuild .= '<li>'.self::linkReplace($path, $newValue2);
                                }

                                if (is_array($newValue2)) {
                                    $navBuild .= '<ul>';
                                    foreach ($newValue2 as $newKey3 => $newValue3) {
                                        if (is_string($newKey3)) {
                                            $path = self::removeKeySlash($key.'~'.$newKey.'~'.$newKey2.'~'.$newKey3);
                                            $navBuild .= '<li>'.self::linkReplace($path,$newKey3);
                                        }
                                        if (is_numeric($newKey3)) {
                                            $path = self::removeKeySlash($key.'~'.$newKey.'~'.$newKey2.'~'.$newValue3);
                                            $navBuild .= '<li>'.self::linkReplace($path, $newValue3);
                                        }

                                        if (is_array($newValue3)) {
                                            loopCheck($newValue2, $navBuild);
                                        }
                                    }
                                    $navBuild .= '</ul></li>';
                                }

                            }
                            $navBuild .= '</ul></li>';
                        }
                    }
                    $navBuild .= '</ul></li>';
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
