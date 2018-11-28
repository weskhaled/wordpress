<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;

class PageSubmitCv extends Controller
{
    public function getPartners()
    {
        $args = array(
        'post_type'              => 'partner',
        'posts_per_page'         => -1
        );
        $query = new WP_Query($args);
        return $query;
    }
    public function submitCv()
    {
        if(isset($_POST['submitted'])){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $mail = $_POST['mail'];
            $phone = $_POST['phone'];
            $resumefile = $_FILES['resumefile'];
            $message = $_POST['message'];
            // return $resumefile['name'];
            // if (!is_user_logged_in()){
            //     $new_post = array(
            //         'post_title' => 'Test Post Title test for condidate',
            //         'post_content' => 'Test Post Content',
            //         'post_status' => 'pending',
            //         'post_author' => 0,
            //         'post_type' => 'condidate',
        
            //     );
            //     $newid = wp_insert_post($args); 
            //     if ($newid){ 
            //         // add_post_meta here if  your post type have 
            //         //some success notification 
            //         return $newid;
            //     } else { 
            //         return false;
            //     }
            // }
            if(isset($_FILES['resumefile']) && isset($_POST['mail'])) { 
                $upload_dir = wp_upload_dir();
                
                $folderPath = trailingslashit( $upload_dir['basedir'] )."condidates/files";
                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                $filename = $mail . '_' . basename($_FILES['resumefile']['name']);
                $filetype = $_FILES['resumefile']['type'];
                $target_path = $folderPath . "/" . $filename;
                    if(move_uploaded_file($_FILES['resumefile']['tmp_name'], $target_path)) {

                        $new_post = array(
                            'post_title' => $firstname,
                            'post_content' => $mail,
                            'post_name' => $mail ,
                            'post_status' => 'pending',
                            'post_date' => date('Y-m-d H:i:s'),
                            'post_type' => 'condidate'
                        );
                        $post_id = wp_insert_post($new_post);
                        if ($post_id){ 
                            $condidateinfo = Array(
                                'firstname' => $firstname,
                                'lastname' => $lastname,
                                'mail' => $mail,
                                'phone' => $phone,
                                'message' => $message,
                                'resumeurl' => 'wp-content/uploads/condidates/files/'.$filename
                            );
                            update_post_meta($post_id, 'condidate_info', $condidateinfo, true);
                            return $post_id;
                        } else { 
                            return false;
                        }

                    }
                chmod("{$target_path}", 0755);
            } else {
                return false;
            }

        } else {
            return false;
        }

    }
    public function getCaptcha(){

    }
}
