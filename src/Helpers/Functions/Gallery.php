<?php
if (!function_exists('enCodeId'))
{
    function enCodeId($var)
    {
        $hashids = new Hashids\Hashids(md5('sadeghi'));

        return $hashids->encode($var);
    }
}
if (!function_exists('deCodeId'))
{
    function deCodeId($var)
    {
        try
        {
            $hashids = new Hashids\Hashids(md5('sadeghi'));

            return $hashids->decode($var);
        } catch (Illuminate\Contracts\Encryption\DecryptException $e)
        {
            return false;
        }
    }
}

if (!function_exists('LGS_CreateModalGalleryManager'))
{
    function LGS_CreateModalGalleryManager()
    {
        $src = route('LGS.Gallery');
        $html = '<iframe style="width:100%;height: calc(100vh - 51px);    max-height: calc(100vh - 50px);    border: none;" id="iframShowGalleryManager" src="' . $src . '"></iframe>';
        return $html;
    }
}

if (!function_exists('LGS_CreateModalSliderManager'))
{
    function LGS_CreateModalSliderManager()
    {
        $src = route('LGS.Slider');
        $html = '<iframe style="width:100%;height: calc(100vh - 51px);    max-height: calc(100vh - 50px);    border: none;" id="iframShowSliderManager" src="' . $src . '"></iframe>';
        return $html;
    }
}

if (!function_exists('LGS_getImagesLink'))
{
    function LGS_propearSlider($sliders,$type='original',$quality=100,$width=100,$height=100)
    {
        $src=[];
        $title=[];
        $items = $sliders->slider_items ;
        $options = json_decode($sliders->style_options) ;
        foreach ($items as $item)
        {
            $itemFind = \ArtinCMS\LGS\Model\GalleryItem::find($item->item_id);
            $link=LFM_GenerateDownloadLink('ID',$itemFind->file_id,$type,'404.png',$quality,$width,$height);
            array_push($src,$link);
            array_push($title,$itemFind->title);
        }
        $result['captions']=$title;
        $result['url']=$src;
        $result['options'] = $options ;
        return $result ;
    }
}
