<?php

namespace App\Supports;

use \Log;

class Cms
{
    
    public function send($cms)
    {
        sleep(3);
        Log::info("CMS: $cms");
        
    }
}