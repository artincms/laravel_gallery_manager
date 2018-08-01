<div class="container-fluid">
    <div class="row">
        @foreach($galleryItems as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card no-padding">
                    <div class="card-header pr-0">
                        <span class="float-right"><input type="checkbox" name="selected_slider_items[]" class="form-check-input" id="select_slider_item_{{$item->encode_id}}" value="{{$item->encode_id}}"></span>
                        <h5>{{$item->title}}</h5>
                    </div>
                    <div class="card-body no-padding">
                    </div>
                    <img class="card-img-top" src="{{LFM_GenerateDownloadLink('ID',$item->file_id,'small','404.png',100,200,150)}}" alt="Card image" style="width:100%">
                </div>
            </div>
        @endforeach
    </div>
</div>