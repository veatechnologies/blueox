<?php 

/* All Product Specifications Variables */
$part_number = get_field( "part_number" );
$fit_years = get_field( "fit_years" );
$tab_type = get_field( "tab_type" );
$notes = get_field( "notes" );
$ir = get_field( "ir" );
$wiring_kit_options = get_field( "wiring_kit_options" );
$fuse_bypass_switch = get_field( "fuse_bypass_switch" );
$weight = get_field( "weight" );
$tab_height = get_field( "tab_height" );
$tab_width = get_field( "tab_width" );
$instructions = get_field( "instructions" );
$link_to_warranty = get_field( "link_to_warranty" );
$literature = get_field( "literature" );

// if at least one value exists then section will show
if ($part_number || $fit_years || $tab_type || $notes || $ir || $wiring_kit_options || $fuse_bypass_switch || $weight || $tab_height || $tab_width || $instructions || $link_to_warranty || $literature):
?>
<div id="product-specifications" class="container-fluid">
    <div class="row">
        <div class="col">
            <h3>Specifications</h3>
        </div>
    </div>
            
    <?php if( $part_number ): ?>
        <dl class="row">
            <dt class="col-sm-3">Part Number</dt>
            <dd class="col-sm-8"><?= $part_number ?></dd>
        </dl>
    <?php endif; ?>

    <?php if( $fit_years ): ?>
        <dl class="row">
            <dt class="col-sm-3">Fit Years</dt>
            <dd class="col-sm-8"><?= $fit_years ?></dd>
        </dl>
    <?php endif; ?>

    <?php if( $tab_type ): ?>
        <dl class="row">
            <dt class="col-sm-3">
                Tab Type
                <u title="Removable indicates Blue Ox baseplates that have removable attachment tabs, Standard indicates Blue Ox baseplates with standard attachment tabs, and D indicates Duncan bracket kits. Duncan bracket kits require the BX88230 adapter to use a Blue Ox towbar.">
                    ?
                </u>
            </dt>
            <dd class="col-sm-8"><?= $tab_type ?></dd>
        </dl>
    <?php endif; ?>

    <?php if( $notes ): 
        $notes_url = $notes['url'];
        $notes_title = $notes['title'];
        $notes_target = $notes['target'] ? $notes['target'] : '_self';
    ?>
        <dl class="row">
            <dt class="col-sm-3">Notes</dt>
            <dd class="col-sm-8">
                <a class="button" href="<?php echo esc_url( $notes_url ); ?>" target="<?php echo esc_attr( $notes_target ); ?>"><?php echo esc_html( $notes_title ); ?></a>
            </dd>
        </dl>
    <?php endif; ?>

    <?php if( $ir ): ?>
        <dl class="row">
            <dt class="col-sm-3">
                IR
                <u title="IR (Installation Rating) is a rough measure of the time required for baseplate or bracket installation by a trained installer. These numbers can be used as rough suggested installation time by a trained installer. The first installation of a particular baseplate, and installation by untrained individuals will likely increase installation time substantially.">?</u>
            </dt>
            <dd class="col-sm-8"><?= $ir ?></dd>
        </dl>
    <?php endif; ?>

    <?php
        if( $wiring_kit_options ): 
            $wiring_kit_options_url = $wiring_kit_options['url'];
            $wiring_kit_options_title = $wiring_kit_options['title'];
            $wiring_kit_options_target = $wiring_kit_options['target'] ? $wiring_kit_options['target'] : '_self';
        ?>
        <dl class="row">
            <dt class="col-sm-3">
                Wiring Kit Options
                <u title="IR (Installation Rating) is a rough measure of the time required for baseplate or bracket installation by a trained installer. These numbers can be used as rough suggested installation time by a trained installer. The first installation of a particular baseplate, and installation by untrained individuals will likely increase installation time substantially.">?</u>
            </dt>
            <dd class="col-sm-8">
                <a class="button" href="<?php echo esc_url( $wiring_kit_options_url ); ?>" target="<?php echo esc_attr( $wiring_kit_options_target ); ?>"><?php echo esc_html( $wiring_kit_options_title ); ?></a>
            </dd>
        </dl>
    <?php endif; ?>

    <?php
        if( $fuse_bypass_switch ): 
            $fuse_bypass_switch_url = $fuse_bypass_switch['url'];
            $fuse_bypass_switch_title = $fuse_bypass_switch['title'];
            $fuse_bypass_switch_target = $fuse_bypass_switch['target'] ? $fuse_bypass_switch['target'] : '_self';
        ?>
        <dl class="row">
            <dt class="col-sm-3">Fuse Bypass Switch</dt>
            <dd class="col-sm-8">
                <a class="button" href="<?php echo esc_url( $fuse_bypass_switch_url ); ?>" target="<?php echo esc_attr( $fuse_bypass_switch_target ); ?>"><?php echo esc_html( $fuse_bypass_switch_title ); ?></a>
            </dd>
        </dl>
    <?php endif; ?>

    <?php if( $weight ): ?>
        <dl class="row">
            <dt class="col-sm-3">Weight</dt>
            <dd class="col-sm-8"><?= $weight ?></dd>
        </dl>
    <?php endif; ?>

    <?php if( $tab_height ): ?>
        <dl class="row">
            <dt class="col-sm-3">Tab Height</dt>
            <dd class="col-sm-8"><?= $tab_height ?></dd>
        </dl>
    <?php endif; ?>

    <?php if( $tab_width ): ?>
        <dl class="row">
            <dt class="col-sm-3">Tab Width</dt>
            <dd class="col-sm-8"><?= $tab_width ?></dd>
        </dl>
    <?php endif; ?>
    
    <?php if( $instructions ): ?>
        <dl class="row">
            <dt class="col-sm-3">Instructions</dt>
            <dd class="col-sm-8"><a href="<?php echo $instructions['url']; ?>" target="_blank"><?php echo $instructions['filename']; ?></a></dd>
        </dl>
    <?php endif; ?>

    <?php if( $link_to_warranty ): ?>
        <dl class="row">
            <dt class="col-sm-3">Link to Warranty</dt>
            <dd class="col-sm-8"><a href="<?php echo $link_to_warranty['url']; ?>" target="_blank"><?php echo $link_to_warranty['filename']; ?></a></dd>
        </dl>
    <?php endif; ?>

    <?php if( $literature ): ?>
        <dl class="row">
            <dt class="col-sm-3">Literature</dt>
            <dd class="col-sm-8"><a href="<?php echo $literature['url']; ?>" target="_blank"><?php echo $literature['filename']; ?></a></dd>
        </dl>
    <?php endif; ?>

</div>
<?php endif; ?>
