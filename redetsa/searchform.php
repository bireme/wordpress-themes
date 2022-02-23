<?php extract( $args ); ?>
<div id="searchandfilter">
  <form action="/" method="get" class="searchandfilter <?php if ( $is_cat ) { echo 'widgetfilter'; } ?>">
    <div>
      <ul>
        <li><input type="text" name="ofsearch" placeholder="<?php pll_e("Enter one or more words"); ?>" value="<?php echo $ofsearch; ?>"></li>
        <li>
          <select name="category_name" id="ofcategory" class="postform">
            <option value=""><?php pll_e("All Categories"); ?></option>
            <?php
              $option = '';
              $categories = get_categories();
              foreach ($categories as $category) {
                  $cat_lang = pll_get_term_language($category->term_id);
                  if ( $cat_lang == $lang ) {
                      $selected = ( $ofcategory == $category->slug ) ? 'selected' : '';
                      $option .= '<option value="'.$category->slug.'" '.$selected.'>';
                      $option .= $category->cat_name;
                      // $option .= ' ('.$category->category_count.')';
                      $option .= '</option>';
                  }
              }
              echo $option;
            ?>
          </select>
          <!-- <input type="hidden" name="ofcategory_operator" value="and"> -->
        </li>
        <li>
          <!-- <input type="hidden" name="ofsubmitted" value="1"> -->
          <input type="submit" value="<?php pll_e("Search"); ?>">
        </li>
      </ul>
    </div>
  </form>
</div>