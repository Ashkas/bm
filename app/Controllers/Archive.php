<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Archive extends Controller
{

	/**
     * Return images from Advanced Custom Fields
     *
     * @return array
    */

    public function main_catalogue() {

	    return (object) array(
            'catalogue_number' => get_field('c_catalogue_number', $post_id, false, false) ?? null,

	    );
    }
}
