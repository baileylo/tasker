<?php namespace Portico\Core\Gravatar;

class GravatarGenerator
{
    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $size Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $default Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $rating Maximum rating (inclusive) [ g | pg | r | x ]
     * @param bool $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function get($email, $size = 80, $default = 'mm', $rating = 'g')
    {
        $url = 'https://secure.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$size&d=$default&r=$rating";

        return $url;
    }
} 