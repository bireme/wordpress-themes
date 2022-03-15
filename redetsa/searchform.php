<?php extract( $args ); ?>
<div id="searchandfilter">
  <form method="get" class="searchandfilter <?php if ( $is_cat ) { echo 'widgetfilter'; } ?>">
    <div>
      <ul>
        <li><input type="text" name="ofsearch" placeholder="<?php pll_e("Enter one or more words"); ?>" value="<?php echo $ofsearch; ?>"></li>
        <li>
          <select name="ofyear" id="ofyear" class="postform">
            <option value=""><?php pll_e("Filter by year"); ?></option>
            <?php
              $option = '';
              $earliest_year = 2015;
              foreach (range(date('Y'), $earliest_year) as $year) {
                  $selected = ( $year == $ofyear ) ? 'selected' : '';
                  $option .= '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
              }
              echo $option;
            ?>
          </select>
        </li>
        <li>
          <input type="submit" value="<?php pll_e("Search"); ?>">
        </li>
      </ul>
    </div>
  </form>
</div>