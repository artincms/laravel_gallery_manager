# laravel_gallery_system
laravel gallery manager is a laravel package for 
<ul>
<li>manage gallery</li>
<li>manage slider</li>
</ul> 

# Requiments 
<ul>
<li>
PHP >= 7.0
</li>
<li>
Laravel 5.5|5.6
</li>
</ul>

# Installation
<h3>Quick installation</h3> 
<div class="highlight highlight-source-shell"><pre>composer require artincms/laravel_gallery_system</pre></div>
<h6>publish vendor</h6>
 <div class="highlight highlight-text-html-php"><pre>
 $ php artisan vendor:publish --provider=ArtinCMS\LGS\LGSServiceProvider
</pre> </div>

if update package for publish vendor you should run : 
 <div class="highlight highlight-text-html-php"><pre>
 $ php artisan vendor:publish --provider=ArtinCMS\LGS\LGSServiceProvider --force
</pre> </div>
 <h6>migrate tabales</h6>
  <div class="highlight highlight-text-html-php"><pre>
   $ php artisan migrate
   </pre> </div>
   
   <h1>usage</h1> 
    for use this package you should use bellow helper function anywhere in your project such as in your controller . 
    this helper function is :
   <h5>create html modal for show Gallery manager in backed</h5>
    <div class="highlight highlight-text-html-php"><pre>
        LGS_CreateModalGalleryManager()
      </pre> </div>
    <h5>create html modal for show Slider manager in backed</h5>
      <div class="highlight highlight-text-html-php"><pre>
            LGS_CreateModalSliderManager()
          </pre> 
      </div>