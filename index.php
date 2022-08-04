<?php

/**Author : Oladele John

** © 2022 Oladele John

** 7/21/2022

** Web application

** File name : index.php

** About : this serves as the index file and landing page for the pasteX app

*/  

/**PSUEDO ALGORITHM
 * 
 * Dependencies
 * home page class
 * cache home page
 * 
 * *
 */

//Dependencies

require('vendor/autoload.php');

//cache library
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

//image optimizer
use Spatie\ImageOptimizer\OptimizerChainFactory;


//home page class
class landingPage{

    public $landing_page;

    public function displayLandingPage(){

        $image_optimizer = OptimizerChainFactory::create();

        $optimize_to = 'public/images/optimized-images/optimized-logo.png';

        $image_optimizer->optimize('public/images/logo.jpg', $optimize_to);

        $this->landing_page = '
        
        <!doctype html>

            <html lang="en">

                <head>

                    <!-- Required meta tags -->
                    <meta charset="utf-8">

                    <meta name="viewport" content="width=device-width, initial-scale=1">

                    <meta name = "author" content ="oladele john">

                    <title>pasteX</title>

                    <!-- boostrap css -->
                    <link href="public/assets/bootstrap-library/css/bootstrap.min.css" rel="stylesheet"/>

                    <!-- font awesome icon css -->
                    <link href="public/assets/font-awesome-library/css/font-awesome.min.css" rel="stylesheet"/>

                    <!- custom css -->
                    <link href="./public/assets/css/landing-page/index.css" rel="stylesheet"/>

                </head>

                <body class="bg-dark">

                <div class="px-4 py-5 my-5 text-center">

                    <img class="rounded-circle" src='.$optimize_to.' alt="logo" width="124px" height="100px">

                    <h1 class="display-5 fw-bold text-light">
                        Hi, Welcome To paste<font color="#00AAF4">X</font>
                    </h1>

                    <div class="col-lg-6 mx-auto text-light">

                        <p class="lead mb-4">
                            PasteX is a web based global clipboard that allows you to copy, paste, and share textual <b>secured</b> 
                            stuff which can be accessed across several devices.
                        </p>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">

                            <div>

                                <button type="button" class="btn btn-md btn-lg px-4 gap-3 text-light" 
                                style="background-color:#00AAF4;">

                                    <a id="sign_up_link" class="text-light" href="./public/pages/login/login.php">
                                        Login <i class="fa fa-sign-in"></i>
                                    </a>

                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg px-4 text-light">

                                    <a id="login_link" class="text-light" href="./public/pages/signup/sign-up.php">
                                        Sign up <i class="fa fa-user-circle-o"></i>
                                    </a>

                                </button>

                            <!-- still in development

                            <button type="button" class="btn btn-md btn-lg px-4 gap-3 text-light" 
                            style="background-color:#00AAF4;">
                                Still in development <i class="fa fa-code"></i>
                            </button>

                            <!-- still in development -->

                            </div>

                        </div>

                    </div>

                    <div class="footer">

                        <div class="pt-5 mt-5 text-light">

                            <a href="https://twitter.com/cyber_geek__" style="text-decoration:none;">Oladele John</a> © 2022

                        </div>

                    </div>

                </div>

                </body>

            </html>
        
        ';

    }

    public function cacheLandingPage(){

        CacheManager::setDefaultConfig(new ConfigurationOption([
            'path' => '', // or in windows "C:/tmp/"
        ]));
        
        $InstanceCache = CacheManager::getInstance('files');
        
        $key = "landing_page";
        $Cached_page = $InstanceCache->getItem($key);
        
        if (!$Cached_page->isHit()) {
            $Cached_page->set($this->landing_page)->expiresAfter(1);//in seconds, also accepts Datetime
    
            $InstanceCache->save($Cached_page); // Save the cache item just like you do with doctrine and entities
        
            echo $Cached_page->get();
            //echo 'FIRST LOAD // WROTE OBJECT TO CACHE // RELOAD THE PAGE AND SEE // ';
         
        } else { 
            
            echo $Cached_page->get();
            //echo 'READ FROM CACHE // ';
        
            $InstanceCache->deleteItem($key);
        } 
    

    }

}

$landing_page = new landingPage();

$landing_page->displayLandingPage();

$landing_page->cacheLandingPage();

?>