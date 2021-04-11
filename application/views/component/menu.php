<div class="main-nav-wrap">
  <div class="mobile-overlay"></div>

  <ul class="mobile-main-nav">
    <div class="mobile-menu-helper-top"></div>

    <li class="has-children">
      <a >
        <i class="fas fa-th d-inline"></i>
        <span><?= 'Courses' ?></span>
        <span class="has-sub-category"><i class="fas fa-angle-right"></i></span>
      </a>

      <ul class="category corner-triangle top-left is-hidden">
        <?php foreach ($category_list as $category) { ?>
          <li class="has-children">
            <a href="<?php echo base_url('courses?category=' . $category->id) ?>" onclick="category(<?= $category->id?>, this)">
              <!-- <span class="icon"><i class="fas fa-chess"></i></span> -->
              <span><?php echo $category->name; ?></span>
              <?php if (count($category->sub_category_list) > 0) { ?>
              <span class="has-sub-category"><i class="fas fa-angle-right"></i></span>
              <?php } ?>
            </a>
            <ul class="sub-category is-hidden">
              <?php foreach ($category->sub_category_list as $sub_category) { ?>
                <li><a href="<?php echo base_url('courses?category=' . $sub_category->id) ?>"><?php echo $sub_category->name; ?></a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } ?>
        <li class="all-category-devided">
          <a href="<?php echo site_url('courses'); ?>">
            <span class="icon"><i class="fa fa-align-justify"></i></span>
            <span><?php echo get_phrase('all_courses'); ?></span>
          </a>
        </li>
      </ul>
    </li>

    <div class="mobile-menu-helper-bottom"></div>
  </ul>
</div>
<script type="text/javascript">
  
  // $("#cate_").on('click', function(event) {
  //   console.log(event.currentTarget.href);
  //   window.location.href = event.currentTarget.href;
  //   /* Act on the event */
  // });

  function category(id, event){
    path = event.origin + '' + event.pathname +'?category=';
    location.replace(path+id); 
   
  }
</script>