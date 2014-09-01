<?php do_action('bp_before_profile_loop_content'); ?>
<?php if (bp_has_profile()) : ?>
    <?php while (bp_profile_groups()) : bp_the_profile_group(); ?>
        <?php if (bp_profile_group_has_fields()) : ?>
            <?php do_action('bp_before_profile_field_content'); ?>
            <div class="bp-widget <?php bp_the_profile_group_slug(); ?>">
                <div id="detailedinfo">
                    <div class="bbp_content">
                        <dl>
                            <?php while (bp_profile_fields()) : bp_the_profile_field(); ?>
                                <?php if (bp_field_has_data()) : ?>
                                    <dt><?php bp_the_profile_field_name(); ?></dt>
                                    <dd><?php bp_the_profile_field_value(); ?></dd>
                                <?php endif; ?>
                                <?php do_action('bp_profile_field_item'); ?>
                            <?php endwhile; ?>
                        </dl>
                    </div>
                </div>
            </div>
            <?php do_action('bp_after_profile_field_content'); ?>
        <?php endif; ?>
    <?php endwhile; ?>
    <?php do_action('bp_profile_field_buttons'); ?>
<?php endif; ?>

<?php do_action('bp_after_profile_loop_content'); ?>
