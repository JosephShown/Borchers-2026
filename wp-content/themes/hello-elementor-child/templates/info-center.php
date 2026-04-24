<?php
   /**
    * Template Name: info-center
    *
    * @package PathTheme
    * @subpackage Templates
    * @author Path Interactive
    * @link http://www.pathinteractive.com
    * @since PathTheme 1.0
    */
   
   get_header();
   if ( have_posts() ) :
   	while ( have_posts() ) :
   		the_post(); ?>
         <main class="main-content">
            <?php get_template_part( 'template-parts/inner-banner','inner-banner');?>
            <?php
            $queriedObject = get_queried_object();
            if(  get_field('info_section_title', $queriedObject) ): ?>
               <!-- Header Below section -->
               <section class="info-center-check grey-section">
                  <div class="container">
                     
                     <p><?php echo get_field('info_section_title', $queriedObject);  ?></p>
                     <ul class="rem-ul-def tick-list clearfix">
                        <?php if( have_rows('info_list') ): ?>
                           <?php while( have_rows('info_list') ): the_row(); ?>
                              <li>
                                 <i class="fas fa-check"></i> <?php the_sub_field('enter_the_items'); ?>
                              </li>
                           <?php endwhile; ?>
                        <?php endif; ?>
                     </ul>
                  </div>
               </section>
            <?php endif; ?>
            <section class="info-center-main">
               <div class="container">
                  <div class="row rem-row">
                     <div class="col-md-3 rem-col left-pill">
                        <ul class="nav nav-pills nav-stacked rem-ul-def info-sidebar">
                           <li class="active"><a href="#tab_a" data-toggle="pill" class="active main-pill">Product Brochures</a></li>

                           <li>
                              <a href="#tab_b1" data-toggle="pill" class="main-pill spf"><span class="toggle-custom" >Starting Formulations</span></a>
                              <?php if( have_rows('starting_formulation_category') ): $counter = 1;  ?>
                                 <div class="subs">
                                 <h6 class="group-header" >Categories</h6>
                                 <ul>
                                    <?php while( have_rows('starting_formulation_category') ): the_row(); ?>
                                       <li>  <a href="javascript:void(0);" class="formulation-category" 
                                          data-id="sft_<?php echo $counter; ?>"
                                          > <?php the_sub_field('starting_point_formulations_category_name'); ?></a></li>
                                       <?php $counter++; ?>  
                                    <?php endwhile; ?>
                                 </ul>
                              <?php endif; ?>
    
                              <h6 class="group-header" >Filters</h6>
                              <?php
                                 $formulationsavailability = get_terms( array(
                                    'taxonomy' => 'pa_formulations-availability',
                                    'hide_empty' => false,
                                ) );
                                $formulationssystem = get_terms( array(
                                 'taxonomy' => 'pa_formulations-system',
                                 'hide_empty' => false,
                             ) );                                
                             $formulationschemistry = get_terms( array(
                              'taxonomy' => 'pa_formulations-chemistry',
                              'hide_empty' => false,
                          ) );
                              ?>
                              <div class="filter-grp  formulations-filters" >
                                    <h6 class="sub-header" >Region<span></span></h6>
                                 <ul class="checkbox-filters" >
                                    <?php foreach($formulationsavailability as $key=>$tval): ?>
                                    <li>
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox"
                                                   name="availability" disabled="disabled"
                                                   class="custom-control-input checkbox"
                                                   id="availability_<?= $tval->term_id ?>"
                                                   value="<?=$tval->term_id ?>">
                                             <label class="custom-control-label"
                                                   for="availability_<?= $tval->term_id ?>"><?= $tval->name ?></label>
                                          </div>
                                    </li>
                                    <?php endforeach; ?>
                                 </ul>
                              </div>
                              <div class="filter-grp formulations-filters">
                                    <h6 class="sub-header" >System<span></span></h6>
                                 <ul class="checkbox-filters" >
                                    <?php foreach($formulationssystem as $key=>$tval): ?>
                                    <li>
                                          <div class="custom-control custom-checkbox avilattr">
                                             <input type="checkbox"
                                                   name="system" disabled="disabled"
                                                   class="custom-control-input checkbox"
                                                   id="system_<?= $tval->term_id ?>"
                                                   value="<?=$tval->term_id ?>">
                                             <label class="custom-control-label"
                                                   for="system_<?= $tval->term_id ?>"><?= $tval->name ?></label>
                                          </div>
                                    </li>
                                    <?php endforeach; ?>
                                 </ul>
                              </div>
                              <div class="filter-grp formulations-filters">
                                    <h6 class="sub-header" >Resin Chemistry<span></span></h6>
                                 <ul class="checkbox-filters" >
                                    <?php foreach($formulationschemistry as $key=>$tval): ?>
                                    <li>
                                          <div class="custom-control custom-checkbox avilattr">
                                             <input type="checkbox"
                                                   name="chemistry" disabled="disabled"
                                                   class="custom-control-input checkbox"
                                                   id="chemistry_<?= $tval->term_id ?>"
                                                   value="<?=$tval->term_id ?>">
                                             <label class="custom-control-label"
                                                   for="chemistry_<?= $tval->term_id ?>"><?= $tval->name ?></label>
                                          </div>
                                    </li>
                                    <?php endforeach; ?>
                                 </ul>
                              </div>
                        </div>
                           </li>
                           <li><a href="#tab_c" data-toggle="pill" class="main-pill">ISO Certificates</a></li>
                           <li><a href="#tab_d" data-toggle="pill" class="main-pill">Video & Multimedia</a></li>
                           <li><a href="#tab_e" data-toggle="pill" class="main-pill">Webinars</a></li>
                        </ul>
                     </div>
                     <div class="col-md-9 rem-col">
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_a">
                              <div class="info-inner">
                                 <div class="info-desc">
                                    <h3><?php echo get_field('product_title');  ?></h3>
                                    <p><?php echo get_field('product_brochures_description');  ?></p>
                                    <!-- <span class="desc-image" style ="background-image: url(<?php echo get_field('product_brochures_image');  ?>);"></span> -->
                                 </div>
                                 <?php 
                                 if( have_rows('general__title') ): 
                                   while( have_rows('general__title') ): the_row(); ?>
                                    <div class="info-content">
                                       <h4><?php the_sub_field('general_availability_tit'); ?></h4>
                                       <?php if( have_rows('availability_region') ):  
                                          while( have_rows('availability_region') ): the_row(); ?>
                                             <h6><?php the_sub_field('label'); ?></h6>
                                             <ul class="rem-ul-def clearfix with-2-col">
                                                <?php 
                                                if( have_rows('region_label') ):  
                                                 while( have_rows('region_label') ): the_row(); ?>
                                                   <li>
                                                      <a href="<?php the_sub_field('file'); ?>" target="_blank"><img src="<?php echo site_url();?>/wp-content/themes/hello-elementor-child/images/file-icon.png" alt="file"></a>
                                                      <p><?php the_sub_field('file_content'); ?></p>
                                                   </li>
                                                <?php endwhile;endif;  ?>
                                             </ul>
                                          <?php endwhile; endif;  ?>
                                       </div>
                                    <?php endwhile;  endif;  ?>
                                 </div>
                              </div>
                              <div class="tab-pane" id="tab_b">
                                 <div class="info-inner">
                                    <div class="info-desc">
                                       <h3><?php echo get_field('starting_formulation_title');  ?></h3>
                                       <p><?php echo get_field('starting_formulation_content');  ?></p>
                                       <!-- <span class="desc-image" style ="background-image: url(<?php echo get_field('starting_formulation_image');  ?>);"></span> -->
                                    </div>
                                    <div class="formulation-grp">
                                       <?php 
                   
                                       if( have_rows('starting_formulation_list') ): $counter = 1;   

 
                                        while( have_rows('starting_formulation_list') ): the_row(); ?>
                                          <h4 id="sub<?php echo $counter; ?>"><?php the_sub_field('label'); ?></h4>
                                          <div class="table-stack-wrap">
                                             <table class="table tablesaw" data-tablesaw-mode="stack" data-tablesaw-hide-empty>
                                                <tbody>
                                                   <?php 
               
                                                   if( have_rows('label_table') ): ?>
                                                      <?php 
                           
                                                      while( have_rows('label_table') ): the_row();

                              	 
                                                       ?>
                                                       <tr>
                                                         <th class="" scope="row"><a target="_blank" href="<?php the_sub_field('pdf'); ?>"><?php the_sub_field('label_title'); ?></a></th>
                                                         <td><?php the_sub_field('label_content'); ?></td>
                                                      </tr>
                                                   <?php endwhile; ?>
                                                <?php endif; //if( get_sub_field('items') ): ?>
                                             </tbody>
                                          </table>
                                       </div>
                                       <?php $counter++; 
                                    endwhile; // while( has_sub_field('to-do_lists') ): ?>
                                 <?php endif; // if( get_field('to-do_lists') ): ?>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane" id="tab_b1">
                                 <div class="info-inner">
                                 <div class="info-desc">
                                       <h3><?php echo get_field('starting_formulation_title');  ?></h3>
                                       <p><?php echo get_field('starting_formulation_content');  ?></p>
                                       <!-- <span class="desc-image" style ="background-image: url(<?php echo get_field('starting_formulation_image');  ?>);"></span> -->
                                    </div>
                                 <!-- categories overview -->
                                    <div class="formulation-grp clearfix category-tiles"> 
                                       <?php  if( have_rows('starting_formulation_category') ): $counter = 1;   

 
                                        while( have_rows('starting_formulation_category') ): the_row(); ?>
                                        <div class="formulation-category" 
                                        data-id="sft_<?php echo $counter; ?>" 
                                        style="display:inline-block; width:50%; float: left; padding:20px; cursor:pointer;">
                                        <h4 id="sub"><?php the_sub_field('starting_point_formulations_category_name'); ?></h4>
                                        
                                          <img src="<?php the_sub_field('starting_point_formulations_category_image'); ?>"></img>
                                          </div>
                                       <?php $counter++; 
                                    endwhile; ?>
                                 <?php endif; ?>
                              </div>
                              <!-- main categories -->
                              <?php  if( have_rows('starting_formulation_category') ):
                               $counter = 1;   
                              while( have_rows('starting_formulation_category') ): the_row(); ?>
                              <div class="formulation-grp formulation-category-container" style="display:none;" id="sft_<?php echo $counter; ?>">
                                 <div class="color_banner" style=" background-image:url(<?php the_sub_field('starting_point_formulations_category_image'); ?>);"></div>
                     
                                 <h3 style="color:#262626;margin-bottom:20px;"><?php the_sub_field('starting_point_formulations_category_name'); ?></h4>
                                 <!-- color categories -->
                              <?php   if( have_rows('starting_point_formulations_color_category') ):
                                    while( have_rows('starting_point_formulations_color_category') ): the_row(); ?>
                                    <div class="color-category">
                                       <h4 style="border-color:<?php the_sub_field("color") ?>; background-color:<?php the_sub_field("color") ?>;color:<?php the_sub_field("font_color") ?>;"> <?php the_sub_field("name") ?></h4>
                                 <div class="table-stack-wrap">
                                    <table class="table tablesaw" data-tablesaw-mode="stack" data-tablesaw-hide-empty="">
                                          <tbody>
                                          <?php if( have_rows('item') ): ?>
                                             <?php while( have_rows('item') ): the_row();?>
                                             <tr class="formulation-row" 
                                             data-availability="<?php the_sub_field('region')["slug"]; ?>"
                                             data-system="<?php the_sub_field('system')["slug"]; ?>"
                                             data-chemistry="<?php the_sub_field('chemistry')["slug"]; ?>"
                                             >
                                                <th class="" scope="row"><a target="_blank" href="<?php the_sub_field('pdf'); ?>">
													<?php the_sub_field('name'); ?>
													</a></th>
                                                <td><?php the_sub_field('content'); ?></td>
                                             </tr>
                                          <?php endwhile; ?>
                                       <?php endif;?>
                                          </tbody>
                                    </table>
                                 </div>
                                          </div>
                                 <?php  endwhile; ?>
                                 <?php endif; ?>
                              </div>
                              <?php $counter++;  endwhile; ?>
                                 <?php endif; ?>
                           </div>
                        </div>
                        <div class="tab-pane" id="tab_c">
                           <div class="info-inner">
                              <div class="info-desc">
                                 <h3><?php echo get_field('product_regulatory_information_title');  ?></h3>
                                 <p><?php echo get_field('product_regulatory_information_description');  ?></p>
                                 <!-- <span class="desc-image" style ="background-image: url(<?php echo get_field('product_regulatory_information_image');  ?>);"></span> -->
                              </div>
                              <?php 
                  
                              if( have_rows('product_regulatory_information_content_section') ): 

                               while( have_rows('product_regulatory_information_content_section') ): the_row(); ?>
                                 <div class="info-content">
                                    <h4><?php the_sub_field('title'); ?> </h4>
                                    <p><?php the_sub_field('description'); ?></p>
                                    <?php 
                     
                                    if( have_rows('file_content') ): ?>
                                       <ul class="rem-ul-def clearfix">
                                          <?php 
                         
                                          while( have_rows('file_content') ): the_row();

 
                                           ?>
                                           <li>
                                             <a href="<?php the_sub_field('file_link'); ?>" target="_blank"><img src="<?php echo site_url();?>/wp-content/themes/hello-elementor-child/images/file-icon.png" alt="file"></a>
                                             <p><?php the_sub_field('file_description'); ?></p>
                                          </li>
                                       <?php endwhile; ?>
                                    </ul>
                                 <?php endif; //if( get_sub_field('items') ): ?>
                              </div>
                           <?php endwhile;   ?>
                        <?php endif;  ?>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab_d">
                     <div class="info-inner">
                        <div class="info-desc">
                           <h3><?php echo get_field('video_&_multimedia_tit');  ?></h3>
                           <p><?php echo get_field('video_&_multimedia_description');  ?></p>
                           <!-- <span class="desc-image" style ="background-image: url(<?php echo get_field('video_&_multimedia_image');  ?>);"></span> -->
                        </div>
                        <?php 
                   
                        if( have_rows('video_sec') ): 

                           $id_counter = 1; 

                           while( have_rows('video_sec') ): the_row(); ?>
                              <div class="info-content">
                                 <h4><?php the_sub_field('title'); ?> </h4>
                                 <?php 
                                 if( have_rows('video_sub_section') ): ?>
                                    <?php 
                    
                                    while( have_rows('video_sub_section') ): the_row();?>
                                       <h6><?php the_sub_field('section_title'); ?></h6>
                  <?php 
                  if( have_rows('media_file') ):  ?>
                     <ul class="rem-ul-def clearfix video-list">
                        <?php 
                       
                        while( have_rows('media_file') ): the_row();?>
                           <?php	 $image = get_sub_field('placeholder_image');  
                           $dft= '' . site_url().'/wp-content/themes/borchers-theme/dist/images/feature-product.jpg';

                           ?>
                           <?php if( get_sub_field('file') ): ?>
                              <li>

                                 <a class="popup-modal" href="#video-modal<?php echo $id_counter; ?>"  
                                    style="background-image: url(<?php if( !empty($image) ) { echo $image;}else {echo $dft;}?>);">
                                    <span>
                                       <!-- <i class="fas fa-play" aria-hidden="true"></i> -->
                                    </span>
                                 </a>
                                 <h5><?php  the_sub_field('video_title');  ?></h5>
                                 <p><?php  the_sub_field('video_content');  ?></p>
                                 <div id="video-modal<?php echo $id_counter; ?>" class="white-popup-block mfp-hide">
                                    <div class="modal-inner">
                                       <div class="video-inner">
                                            <iframe width="100%" height="450px" src="<?php  the_sub_field('file');  ?> " frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                          </div>
                                          <a class="popup-modal-dismiss" href="#"><i class="fas fa-times"></i></a>
                                       </div>
                                    </div>

                                 </li>
                              <?php endif; ?>
                              <?php  $id_counter++;  endwhile; ?>
                           </ul>
                        <?php endif; ?>
                     <?php endwhile; ?>
                  <?php endif; ?>						 
               </div>


            <?php endwhile;   ?>
         <?php endif;  ?>
      </div>

   </div>
   <div class="tab-pane" id="tab_e">
                     <div class="info-inner">
                        <div class="info-desc">
                           <h3><?php echo get_field('webinar_title');  ?></h3>
                        </div>
                        <?php  if( have_rows('webinar_list') ):  while( have_rows('webinar_list') ): the_row(); ?>
                           <div class="info-content">
                                 <a href="<?php  the_sub_field('url');  ?>" target="_blank">
                                    <h4><?php the_sub_field('title'); ?> </h4>
                                    <img src="<?php  the_sub_field('image');  ?>" />
                                    <p style="color:black; margin: 10px 0;"><?php the_sub_field('organizer'); ?>, <?php the_sub_field('date'); ?> </p>
                                 </a>
                           </div>
                        <?php endwhile; ?>
                        <?php endif; ?>		
                     </div>
               </div>
</div> 
</section>
</main>
<?php
endwhile;
endif;
get_footer();