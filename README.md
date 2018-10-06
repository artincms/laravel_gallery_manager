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
for install manually this package you should bellow structure . at first publish 
bellow packages : 

```apple js
php artisan vendor:publish --provider="ArtinCMS\LGS\LGSServiceProvider" --force
php artisan vendor:publish --provider="ArtinCMS\LFM\LFMServiceProvider" --force
php artisan vendor:publish --provider="ArtinCMS\LCS\LCSServiceProvider" --force
php artisan vendor:publish --provider="ArtinCMS\LLS\LLSServiceProvider" --force
php artisan vendor:publish --provider="ArtinCMS\LVS\LVSServiceProvider" --force
php artisan vendor:publish --provider="ArtinCMS\LMM\LMMServiceProvider" --force
```
and sure bellow seed run in your project

```apple js
 php artisan db:seed --class="ArtinCMS\LFM\Database\Seeds\FilemanagerTableSeeder"
 php artisan db:seed --class="ArtinCMS\LGS\Database\Seeds\LmmMorphableTableSeeder"
```
   <h1>usage</h1> 
    for use this package you should use bellow helper function anywhere in your project such as in your controller . 
    this helper function is :
   <h2>create html modal for show Gallery manager in backed</h5>
    <div class="highlight highlight-text-html-php"><pre>
        LGS_CreateModalGalleryManager()
      </pre> </div>
    <h2>create html iframe to show Slider manager in backed</h4>
      <div class="highlight highlight-text-html-php"><pre>
            LGS_CreateModalSliderManager()
          </pre> 
      </div>
<h2>Show Gallery In front</h3> 
for show gallery we use Vue js . you can create your page as bellow :
<h3><a id="user-content-browser-es5" class="anchor" aria-hidden="true" href="#browser-es5"><svg class="octicon octicon-link" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9h1v1H4c-1.5 0-3-1.69-3-3.5S2.55 3 4 3h4c1.45 0 3 1.69 3 3.5 0 1.41-.91 2.72-2 3.25V8.59c.58-.45 1-1.27 1-2.09C10 5.22 8.98 4 8 4H4c-.98 0-2 1.22-2 2.5S3 9 4 9zm9-3h-1v1h1c1 0 2 1.22 2 2.5S13.98 12 13 12H9c-.98 0-2-1.22-2-2.5 0-.83.42-1.64 1-2.09V6.25c-1.09.53-2 1.84-2 3.25C6 11.31 7.55 13 9 13h4c1.45 0 3-1.69 3-3.5S14.5 6 13 6z"></path></svg></a>Browser</h3>


```html
<script src="{{ asset('vendor/laravel_gallery_system/components/gallery.min.js') }}" defer></script>
.
.
.
.

  <div id="lgs_gallery">
        <laravel_gallery_system :gallery_id='0' :lang_id='1' :rtl=true :jalali_data=true></laravel_gallery_system>
    </div>
 ```
 at first you should create js file to load vue and define component div as bellow : 
```gallery js
window.Vue = require('vue');
Vue.component('laravel_gallery_system', require('./components/laravel_gallery_system/gallery/laravel_gallery_system.vue'));
window.onload = function () {
    const gallery = new Vue({
        el: '#lgs_gallery',
    });
}
```
if you dont want devlope gallery component you can use sample js file in 'public/vendor/laravel_gallery_system/components/gallery.min.js'
and use it on your page .
after you create js file (both you create or use sample js file) you should put component element in 
page as bellow 
```apple js
   <div id="lgs_gallery">
         <laravel_gallery_system :gallery_id='0' :lang_id='1' :rtl=true></laravel_gallery_system>
     </div>
```
<h2><a id="user-content-props" class="anchor" aria-hidden="true" href="#props"><svg class="octicon octicon-link" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9h1v1H4c-1.5 0-3-1.69-3-3.5S2.55 3 4 3h4c1.45 0 3 1.69 3 3.5 0 1.41-.91 2.72-2 3.25V8.59c.58-.45 1-1.27 1-2.09C10 5.22 8.98 4 8 4H4c-.98 0-2 1.22-2 2.5S3 9 4 9zm9-3h-1v1h1c1 0 2 1.22 2 2.5S13.98 12 13 12H9c-.98 0-2-1.22-2-2.5 0-.83.42-1.64 1-2.09V6.25c-1.09.53-2 1.84-2 3.25C6 11.31 7.55 13 9 13h4c1.45 0 3-1.69 3-3.5S14.5 6 13 6z"></path></svg></a>Props</h2>
<table>
<thead>
<tr>
<th>Props</th>
<th align="left">Type</th>
<th>Default</th>
<th>Description</th>
</tr>
</thead>
<tbody>
<tr>
    <td>gallery_id</td>
    <td align="left">Number</td>
    <td>0</td>
    <td>gallery you want show if you set it to 0 show all gallery in main root</td>
</tr>
<tr>
    <td>lang_id</td>
    <td align="left">Number</td>
    <td>null</td>
    <td>The language item if set to null select all language</td>
</tr>
<tr>
    <td>rtl</td>
    <td align="left">Boolean</td>
    <td>true</td>
    <td>the direction of page rtl set true and ltr set to false</td>
</tr></tbody></table>
</div>
<h3>Other my Vue JS plugins</h3>
<table>
<thead>
<tr>
<th>Project</th>
<th>Description</th>
<th>npm install</th>
</tr>
</thead>
<tbody>

<tr>
<td><a href="https://vuex.vuejs.org/installation.html" rel="nofollow">Vuex</a></td>
<td>Vuex is a state management pattern + library for Vue.js applications</td>
<td>npm install vuex --save</td>
</tr>
<tr>
<td><a href="https://www.npmjs.com/package/axios" rel="nofollow">axios</a></td>
<td>Promise based HTTP client for the browser and node.js</td>
<td>npm install axios</td>
</tr>
<tr>
<td><a href="https://www.npmjs.com/package/vue-translate-plugin" rel="nofollow">Vue Translate Plugin</a></td>
<td>A VueJS (1.x, 2.0+) plugin for basic translations.</td>
<td>npm i vue-translate-plugin</td>
</tr>
<tr>
<td><a href="https://www.npmjs.com/package/vue-scrollto" rel="nofollow">Vue-scrollto</a></td>
<td>Scrolling to elements was never this easy!</td>
<td>npm install --save vue-scrollto</td>
</tr>
</tbody>
</table>
