<?php

namespace App\Http\Controllers\blog\querys;

use App\Http\Controllers\Controller;
use App\Models\blog\TabelaBlogPost;

class QueryBlogPost extends Controller
{
    public function blogPost($idPostagem){

        $blogPost = TabelaBlogPost::where('id_post_user', auth()->user()->id);

        if(!empty($idPostagem)){
            $blogPost = $blogPost->where('id_postagem', $idPostagem);
        }

        $blogPost = $blogPost->orderBy('id_postagem', 'DESC')
        ->get();

        //ARQUIVO
        $blogPost->transform(
            function($blogPost){
                $identificando = substr($blogPost->file_img, 0, 1);

                if ($identificando == 'p') {
                    $blogPost->file_img = str_replace('postagens/', '../intranet/public/img/postagens/', $blogPost->file_img);
                } else {
                    $blogPost->file_img = str_replace('../unico/sistemas/blog/postagens/', '../intranet/public/img/postagens/', $blogPost->file_img);
                }

                return $blogPost;
            }
        );

        //DATA
        $blogPost->transform(

            function ($blogPost) {
                $blogPost->data = date('d/m/Y', strtotime($blogPost->data));

                return $blogPost;
            }

        );

        //DATA DROP
        $blogPost->transform(

            function ($blogPost) {
                if($blogPost->data_drop == NULL || $blogPost->data_drop == '0000-00-00'){

                    $blogPost->data_drop = '---';

                }else{
                    $blogPost->data_drop = date('d/m/Y', strtotime($blogPost->data_drop));
                }


                return $blogPost;
            }

        );

        return $blogPost;
    }
}
