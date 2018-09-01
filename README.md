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
<h6>vendor publish</h6>
 <div class="highlight highlight-text-html-php"><pre>
    @php artisan lgs:install --force --full
</pre> </div>
this command install all require package if you want install full requirement
you should type '--full' for rewrite your vendor you should type 
'--force' 
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
<h5>use frontend Gallery Manager</h5> 
in frontend used vue js to create template for use packages template 
you should set bellow html in your page .
<div class="highlight highlight-text-html-php"><pre>

```html
<div id="gallery">
    <laravel_gallery_system gallery_id="5" lang_id="2" rtl=false></laravel_gallery_system>
</div>
 ```
 that rtl can just two parameter true or false .
 you should create your vue js file and include in your page . an example of this js file is exist in 
 assets/js/gallery.js
<h5>use gallery manager as Porfolio</h5>
you can use gallery manager as porfolio . the portfolio manager
backend url is : 
 <div class="highlight highlight-text-html-php">
 <pre>
 http://yourDomain/LGS/Portfolio
  </pre> 
  </div>
after you define porfoli for show all portfolio can use this
helper functions :
 <div class="highlight highlight-text-html-php">
 <pre>
createPortfolio($lang_id,$route_name) ;
  </pre> 
  </div>
 that lang id is the id of language and $route_name is name of 
 route for show more detail of portfolio
 and for show more detail of portfolio you can use this helper functions
 <div class="highlight highlight-text-html-php">
  <pre>
 createPortfolioItem($lang_id,$route_name) ;
   </pre> 
   </div>
 the input of this function similar the createPortfolio function
 example of use two function is : 
 <div class="highlight highlight-text-html-php">
   <pre>
   public function portfolio()
      {
          $url_name='portfolioItem';
          $view =createPortfolio(1,$url_name) ;
          return view('portfolio',compact('view'));
      }
      public function portfolioItem($id)
      {
          $url_name='portfolioItem';
          $item =createPortfolioItem($id,$url_name) ;
          return view('portfolioItem',compact('item'));
      }
</pre>
</div>
