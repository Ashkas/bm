<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use DateTime;

class SingleWorks extends Controller
{

	/**
     * Return images from Advanced Custom Fields
     *
     * @return array
    */

    public function main_catalogue()
    {

	    // Date

		$date = get_field('c_date', $post_id, false, false);
		$date = new DateTime($date);
		$date = $date->format('j M Y');

	    return (object) array(
            'feat_image_id' => get_post_thumbnail_id() ?? null,
            'feat_image_thumb_src' => wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ) ?? null,
            'feat_image_full_src' => wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ?? null,
            'catalogue_number' => get_field('c_catalogue_number', $post_id, false, false) ?? null,
            'year_start' => get_field('c_year_start', $post_id, false, false) ?? null,
            'year_end' => get_field('c_year_end', $post_id, false, false) ?? null,
            'date' => get_field('c_date', $post_id, false, false) ?? null,
            'date_description' => get_field('c_date_description', $post_id, false, false) ?? null,
            'series_set_title' => get_field('c_series_set_title', $post_id) ?? null,
            'artist_number' => get_field('c_artist_number', $post_id, false, false) ?? null,
            //'medium' => get_field('c_medium_category') ?? null,
            'technique' => get_field('c_technique_matrix') ?? null,
            'technique_new' => get_field('c_technique_matrix_type') ?? null,
            'technique_desc' => get_field('c_technique_description', $post_id, false, false) ?? null,
            //'support' => get_field('c_support_category') ?? null,
            'support_desc' => get_field('c_support_description', $post_id, false, false) ?? null,
            'text_num_comp' => get_field('c_textual_numerical_component_of_image', $post_id, false, false) ?? null,
            'inscriptions' => get_field('c_inscriptions', $post_id, false, false) ?? null,
            'dimensions' => get_field('c_dimensions', $post_id, false, false) ?? null,
            'desc_work' => get_field('c_description_work', $post_id, false, false) ?? null,
            'desc_img' => get_field('c_description_image', $post_id, false, false) ?? null,
            'desc_feat_img' => get_field('c_description_featured_image', $post_id, false, false) ?? null,
            'artist_comment' => get_field('c_arist_comment') ?? null,
            'comment' => get_field('c_comment') ?? null,
            'special_notes' => get_field('c_special_notes') ?? null,
            'keywords' => get_field('c_keywords') ?? null,
            'state_type' => get_field('c_p_c_p_s_e_type') ?? null,
	    );
    }

    // Verso Recto function
    public function verso_recto()
	{
		global $post;

        $data = [];

        $verso_recto = get_field('c_verso_recto');

		if($verso_recto) {
	        foreach ($verso_recto as $w) {

	            $this_post = (object) array(
	                'image_id' => get_post_thumbnail_id($w) ?? null,
	                'image_thumb_src' => wp_get_attachment_image_src( get_post_thumbnail_id($w), 'thumbnail' ) ?? null,
	                'permalink' => get_the_permalink($w) ?? null,
	                'title' => get_the_title($w) ?? null,
	            );

	            array_push($data, $this_post);
	        }

	        return $data;
	    }
	}

    // Related works
    public function related_works()
	{
		global $post;

        $data = [];

        $related_works = get_field('c_related_works');

		if($related_works) {
	        foreach ($related_works as $w) {

	            $this_post = (object) array(
	                'image_id' => get_post_thumbnail_id($w) ?? null,
	                'permalink' => get_the_permalink($w),
	                'title' => get_the_title($w),
	            );

	            array_push($data, $this_post);
	        }

	        return $data;
	    }
	}

    // Studio & Summary Ed. Info. Tab
    public function studio_summary_info()
    {

	    return (object) array(
	        'where_made' => get_field('c_where_made', $post_id),
	        //'printers_workshops' => get_field('c_printers_workshops', $post_id),
	        'printer_notes' => get_field('c_printer_notes', $post_id, false, false),
	        'sum_edition' => get_field('c_sum_edition_information', $post_id, false, false),
	    );
    }

    // Exhibtions
    public function exhibitions()
    {
	    if(get_field('c_exhibitions')) {

		    return array_map(function($exhibitions) {
	            return [
			        'type' => $exhibitions['c_exhibtion_type'] ?? null,
			        'year_start' => $exhibitions['c_exhibition_year_start'] ?? null,
			        'year_end' => $exhibitions['c_exhibition_year_end'] ?? null,
	 		        'abb_ref' => get_term_by( 'id', $exhibitions['c_exhibition_abbreviated_reference'], 'exhibitions') ?? null,
			        'citation' => $exhibitions['c_exhibition_citation'] ?? null,
			    ];
	        }, get_field('c_exhibitions') !== null ? (array) get_field('c_exhibitions') : []);
	    }
    }

    // Bibliographical Sources
    public function bib_sources()
    {
	    if(get_field('c_bib_sources')) {

		    return array_map(function($bib_sources) {
	            return [
			        'type' => $bib_sources['c_bib_sources_type'] ?? null,
			        'year' => $bib_sources['c_bib_sources_year'] ?? null,
	 		        'abb_ref' => get_term_by( 'id', $bib_sources['c_bib_sources_abbreviated_reference'], 'bib_sources') ?? null,
			        'citation' => $bib_sources['c_bib_sources_citation'] ?? null,
			    ];
	        }, get_field('c_bib_sources') !== null ? (array) get_field('c_bib_sources') : []);
	    }
    }

    // Collection
    public function collections()
    {
	    if(get_field('c_collection')) {

		    return array_map(function($exhibitions) {
	            return [
			        'details' => $exhibitions['c_collection_acquisition_details'] ?? null,
	 		        'location' => get_term_by( 'id', $exhibitions['c_collection_location'], 'collection') ?? null,
			    ];
	        }, get_field('c_collection') !== null ? (array) get_field('c_collection') : []);
	    }
    }

    // Series or Set
    public function series_set()
    {
	    if(get_field('c_series')) {

		    return array_map(function($exhibitions) {
	            return [
			        'description' => $exhibitions['c_series_description'] ?? null,
	 		        'series' => get_term_by( 'id', $exhibitions['c_series'], 'series') ?? null,
			    ];
	        }, get_field('c_series') !== null ? (array) get_field('c_series') : []);
	    }
    }

    // Additional Material
	public function additional_material()
	{

		if(get_field('c_additional_material')) {

			return array_map(function($material) {
		      return [
			       'type' => $material['material_type'] ?? null,
		           'file' => $material['file'] ?? null,
		           'file_name' => $material['file_name'] ?? null,
		           'video' => $material['video_link'] ?? null,
		           'caption' => $material['caption'] ?? null,
		      ];
		   }, get_field('c_additional_material') ?? [] );
		}
	}

    // States & Eds
	public function states()
	{
		//type
		$type = get_field('c_p_c_p_s_e_type');

		if($type == 'State & Edition' && get_field('c_states')) {

		    return array_map(function($states) {
		      return [
		         'identifier' => $states['s_identifier'] ?? null,
		         'description' => $states['s_description'] ?? null,
		         'impression_description' => $states['s_impression_description'] ?? null,
		         'component_of_image' => $states['s_textual_numerical_comp_of_image'] ?? null,
		         'inscriptions' => $states['s_inscriptions'] ?? null,
	 	         'artists_comments' => $states['s_artists_comments'] ?? null,
		         'authors_comments' => $states['s_authors_comments'] ?? null,
                 'image_thumb' => wp_get_attachment_image_src( $states['s_image'], 'thumbnail' ) ?? null,
                 'image' => wp_get_attachment_image_src( $states['s_image'], 'medium' ) ?? null,
		         'image_id' => $states['s_image'] ?? null,
		         'related_works' => $states['s_related_works'] ?? null,
		         'final_state' => $states['s_final_state'] ?? null,
		         'bib_sources_set' => $states['s_bib_source_c_bib_sources'] ?? null,
		         'bib_sources' =>  array_map(function($bib_sources) {
		             return [
				         'type' => $bib_sources['c_bib_sources_type'] ?? null,
				         'year' => $bib_sources['c_bib_sources_year'] ?? null,
				         'abb_ref' => get_term_by( 'id', $bib_sources['c_bib_sources_abbreviated_reference'], 'bib_sources') ?? null,
				         'citation' => $bib_sources['c_bib_sources_citation'] ?? null,
				      ];
		          }, isset( $states['s_bib_source_c_bib_sources'] ) ? (array) $states['s_bib_source_c_bib_sources'] : []),
		      ];
		   }, get_field('c_states') ?? []);
		}
	}

	public function pages()
	{
		//type
		$type = get_field('c_p_c_p_s_e_type');

		if($type == 'Page' && get_field('c_pages')) {

		    return array_map(function($pages) {
		      return [
		         'identifier' => ($pages)['s_identifier'] ?? null,
		         'description' => ($pages)['s_description'] ?? null,
		         'component_of_image' => ($pages)['s_component_of_image'] ?? null,
		         'inscriptions' => ($pages)['s_inscriptions'] ?? null,
	 	         'artists_comments' => ($pages)['s_artists_comments'] ?? null,
		         'authors_comments' => ($pages)['s_authors_comments'] ?? null,
                 'image_thumb' => wp_get_attachment_image_src( $pages['s_image'], 'thumbnail' ) ?? null,
                 'image' => wp_get_attachment_image_src( $pages['s_image'], 'medium' ) ?? null,
		         'image_id' => $pages['s_image'] ?? null,
		         'related_works' => ($pages)['s_related_works'] ?? null,
		         'bib_sources_set' => ($pages)['s_bib_source_c_bib_sources'] ?? null,
		         'bib_sources' =>  array_map(function($bib_sources) {
		             return [
				         'type' => $bib_sources['c_bib_sources_type'] ?? null,
				         'year' => $bib_sources['c_bib_sources_year'] ?? null,
				         'abb_ref' => get_term_by( 'id', $bib_sources['c_bib_sources_abbreviated_reference'], 'bib_sources') ?? null,
				         'citation' => $bib_sources['c_bib_sources_citation'] ?? null,
				      ];
		          }, isset( ($pages)['s_bib_source_c_bib_sources'] ) ? (array) ($pages)['s_bib_source_c_bib_sources'] : []),
		      ];
		   }, get_field('c_pages') ?? array());
		}

	}

    public function comp_parts()
	{
		//type
		$type = get_field('c_p_c_p_s_e_type');

		if($type == 'Component Part' && get_field('c_component_parts')) {

		    return array_map(function($comp_parts) {
		      return [
			     'type' => $type ?? null,
		         'identifier' => $comp_parts['s_identifier'] ?? null,
		         'description' => $comp_parts['s_description'] ?? null,
		         'component_of_image' => $comp_parts['s_component_of_image'] ?? null,
		         'inscriptions' => $comp_parts['s_inscriptions'] ?? null,
	 	         'artists_comments' => $comp_parts['s_artists_comments'] ?? null,
                 'authors_comments' => $comp_parts['s_authors_comments'] ?? null,
                 'image_thumb' => wp_get_attachment_image_src( $comp_parts['s_image'], 'thumbnail' ) ?? null,
                 'image' => wp_get_attachment_image_src( $comp_parts['s_image'], 'medium' ) ?? null,
		         'image_id' => $comp_parts['s_image'] ?? null,
		         'related_works' => $comp_parts['s_related_works'] ?? null,
		         'bib_sources_set' => $comp_parts['s_bib_source_c_bib_sources'] ?? null,
		         'bib_sources' =>  array_map(function($bib_sources) {
		             return [
				         'type' => $bib_sources['c_bib_sources_type'] ?? null,
				         'year' => $bib_sources['c_bib_sources_year'] ?? null,
				         'abb_ref' => get_term_by( 'id', $bib_sources['c_bib_sources_abbreviated_reference'], 'bib_sources') ?? null,
				         'citation' => $bib_sources['c_bib_sources_citation'] ?? null,
				      ];
		          }, isset( $comp_parts['s_bib_source_c_bib_sources'] ) ? (array) $comp_parts['s_bib_source_c_bib_sources'] : []),
		      ];
		   }, get_field('c_component_parts') ?? array());
		}

	}

}
