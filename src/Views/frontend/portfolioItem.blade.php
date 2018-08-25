<div class="row details">
    <div class="col-md-6">
        <div class="col-md-5 col-sm-12 slider">
            <div id="owl-demo" class="owl-carousel owl-theme">
                @foreach($images as $image)
                <div class="item">
                    <img src="{{$image}}" alt="slider-image" class="img-responsive">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- //Slider Section End -->
    <!-- Project Description Section Start -->
    <div class="col-md-6">
       {!!$item->description!!}
    </div>
</div>
<div class="row">
    <div class="col-md-12 project_images">
        <div class="text-center">
            <h3 class="border-success"><span class="heading_border bg-success">@lang('laravel_gallery_system.related_projecets')</span></h3>
        </div>
        @foreach($relatedItems as $related)
            <div class="col-md-3">
                <a href="{{route($route_name,['id'=>$related->portfolio->encode_id])}}"><img src="{{$related->portfolio->url}}" class="img-responsive"></a>
            </div>
        @endforeach
    </div>
</div>