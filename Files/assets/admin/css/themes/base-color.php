<?php
header ("Content-Type:text/css");
$color = "#746EF1"; // Change your Color Here
$secColor = "#746EE0"; // Change your Color Here


function checkhexcolor($color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if( isset( $_GET[ 'color' ] ) AND $_GET[ 'color' ] != '' ) {
    $color = "#".$_GET[ 'color' ];
}
if( isset( $_GET[ 'secColor' ] ) AND $_GET[ 'secColor' ] != '' ) {
    $secColor = "#".$_GET[ 'secColor' ];
}

if( !$color OR !checkhexcolor( $color ) ) {
    $color = "#746EF1";
}
if( !$secColor OR !checkhexcolor( $secColor ) ) {
    $secColor = "#746EE0";
}

?>

.main-menu {
    background-color: <?php echo $color; ?>;
}

.footer-support-list {
    background-color: <?php echo $color; ?>;
}

.footer-support-list ul li:hover .footer-thumb i {
    background-color: <?php echo $color; ?>;
}

.footer-area {
    background-color: <?php echo $color; ?>;
}

.card__header {
  background-color: <?php echo $color; ?>;
}

.widget-content {
  background-color: <?php echo $color; ?>;
}

.client-section1 {
  background-color: <?php echo $secColor; ?>;
}

.support-bar-top {
  background-color: <?php echo $secColor; ?>;
}

.footer-support-list {
  border-bottom: 8px solid <?php echo $secColor; ?>;
}

.main-menu ul li .mega-menu1 {
      background-color: <?php echo $color; ?>;
}
r: white;
}
