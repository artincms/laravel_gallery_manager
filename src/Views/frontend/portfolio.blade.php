<div class="col-md-12">
    <div id="gallery">
        <div>
            <button class=" btn filter btn-primary" data-filter="all">@lang('laravel_gallery_system.all')</button>
            @foreach($filters as $filter)
            @if(isset($filter['faqs']))
            @if(count($filter['faqs'])>0)
                <button class="btn filter btn-primary" data-filter=".category-{{$filter['id']}}">{{$filter['title']}}</button>
            @endif
            @endif
            @endforeach
        </div>
        <div>
            @foreach($items as $item)
                <div class="mix @if($item['tags']) @foreach($item['tags'] as $tag) category-{{$tag['id']}} @endforeach @endif" data-my-order="8">
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <a class="fancybox" href="{{$item->url}}.jpeg"><i class="fa fa-search-plus"></i></a>
                        <a href="{{route($route_name,['id'=>$item->encode_id])}}"><i class="fa fa-link"></i></a>
                    </div>
                    <div class="thumb_zoom"><img src="{{$item->url}}" class="img-responsive"> </div>
                </div>
            @endforeach
        </div>
    </div>
</div>