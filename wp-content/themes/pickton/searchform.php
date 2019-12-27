<!-- Search -->
<div class="search-box">
    <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="form-group">
            <input type="search" name="s" value="" placeholder="<?php esc_attr_e('Search...', 'pickton');?>" required>
            <button type="submit"><span class="icon fa fa-search"></span></button>
        </div>
    </form>
</div>