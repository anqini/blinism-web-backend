<form method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="form-group">
        <input type="search" name="s" value="" placeholder="<?php esc_attr_e('Search here', 'pickton');?>" required>
        <button type="submit" class="search-btn"><span class="fa fa-search"></span></button>
    </div>
</form>