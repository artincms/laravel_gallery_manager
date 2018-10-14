<?php
namespace ArtinCMS\LGS\Database\Seeds;
use Illuminate\Database\Seeder;

class LmmMorphableTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lmm_morphable')->delete();
        
        \DB::table('lmm_morphable')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pck_name' => 'lgs',
                'dev_name' => 'gallery_model',
                'name' => 'گالری',
                'model_name' => 'ArtinCMS\\LGS\\Model\\Gallery',
                'target_column_name' => 'title',
                'target_column_alias' => 'عنوان',
                'created_by' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'pck_name' => 'lgs',
                'dev_name' => 'item_model',
                'name' => 'گالری آیتم',
                'model_name' => 'ArtinCMS\\LGS\\Model\\GalleryItem',
                'target_column_name' => 'title',
                'target_column_alias' => 'عنوان',
                'created_by' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}