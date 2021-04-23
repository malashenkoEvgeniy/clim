<?php

namespace App\Modules\Users\Components;

use App\Modules\Users\Models\User;
use Hybridauth\Provider\Facebook;
use Hybridauth\Provider\Google;
use Hybridauth\Provider\Instagram;
use Hybridauth\Provider\Twitter;

/**
 * Class SocialAdapter
 * @package App\Modules\Users\Components
 */
class SocialAdapter
{
    /**
     * @param $alias
     * @return bool|Facebook|Google|Instagram|Twitter
     */
   public static function getAdapter($alias)
   {
       $checkSocials = User::getSettingsForSocialsLogin();
       $config = [
           'callback' => route('site.social-network', ['alias' => $alias]),
           'keys' => ['key' => $checkSocials[$alias][$alias . '-api-key'], 'secret' => $checkSocials[$alias][$alias . '-api-secret']]
       ];
       switch ($alias) {
           case 'google' :
               $adapter = new Google($config);
               break;
           case 'facebook' :
               $adapter = new Facebook($config);
               break;
           case 'twitter' :
               $adapter = new Twitter($config);
               break;
           case 'instagram' :
               $adapter = new Instagram($config);
               break;
           default:
               return false;
       }
       return $adapter;
   }

}
