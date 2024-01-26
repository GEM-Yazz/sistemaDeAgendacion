<?php

namespace App\Controllers;

use Timber\Timber;
use Exception;

class PageController {
    public function __construct() { }

    public function show($request) {
        $pageData = [];

        switch ($request['type']) {
            case 'page':
            case 'post-type':
                $post = Timber::get_post([
                    'post_type' => ($request['type'] == 'post-type')
                        ? $request['type-name']
                        : 'page',
                    'name' => $request['slug']
                ]);

                if ($post) {
                    $post->title;
                    $post->content;

                    if ($post->thumbnail) $post->thumbnail->src;

                    $pageData = [
                        'post' => $post
                    ];

                    $pageData = array_merge($pageData, $this->__getPostData($request['type'], $request['type-name'], $request['slug'], $post->ID));
                } else {
                    $pageData = false;
                }

                break;

            case 'term':
                $terms = Timber::get_terms([
                    'taxonomy'  => $request['type-name'],
                    'slug'      => $request['slug']
                ]);
                $term = count($terms) ? $terms[0] : false;

                if ($term) {
                    $term->title;

                    $pageData = [
                        'term' => $term
                    ];

                    $pageData = array_merge($pageData, $this->__getTermData($request['type-name'], $request['slug'], $term->ID, $request['parent']));
                } else {
                    $pageData = false;
                }
                break;
            case 'general':
                $pageData = $this->__getGeneralData();
                break;
        }

        if ($pageData) {
            return $pageData;
        } else {
            return false;
        }
    }

    private function __getPostData($objectType, $objectTypeName, $postSlug, $objectId) {
        $data = [];

        switch ($objectType) {
            case 'post-type':
                switch ($objectTypeName) {
                    case 'example':
                        $data = ['example' => 'Hi, From Panda WP'];
                        break;
                }
                break;

            case 'page':
                switch ($postSlug) {
                    case 'example':
                        $data = ['example' => 'Hi, From Panda WP'];
                        break;
                }
                break;
        }

        return $data;
    }

    private function __getTermData($objectTypeName, $postSlug, $objectId, $parent) {
        $data = [];

        switch ($objectTypeName) {
            case 'example':
                if ($parent) {
                    /* subcategory */
                } else {
                    /* category */
                }

                $data = ['example' => 'Hi, From Panda WP'];
                break;
        }

        return $data;
    }

    private function __getGeneralData() {
        return [
            'information' => (object)[
                "politics" => get_field('politics', 'options')
            ]
        ];
    }
}
