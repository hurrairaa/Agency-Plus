<?php
header ("Content-Type:text/css");
$color = $_GET['color']; // Change your Color Here


function checkhexcolor($color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if( isset( $_GET[ 'color' ] ) AND $_GET[ 'color' ] != '' ) {
    $color = "#".$_GET[ 'color' ];
}

if( !$color OR !checkhexcolor( $color ) ) {
    $color = "#25D06F";
}

?>

.single-pricing-table:hover {
    border: 1px solid <?php echo $color ?>;
}
.page-link:hover {
    background-color: <?php echo $color ?>;
}
input[type="submit"], button[type="submit"] {
    background-color: <?php echo $color ?>;
}
input[type="submit"]:hover, button[type="submit"]:hover {
    color: <?php echo $color ?>;
}
.fc-unthemed td.fc-today {
    background: <?php echo $color ?>;
}
.fc-view-container tr.fc-list-item:hover td {
    background: <?php echo $color ?>;
}
.paginate_button .page-link {
    color: #73818c;
}
div.dataTables_wrapper div.dataTables_info {
    color: #73818c;
}
.table thead th {
    color: #fff;
}
.view-order-page .order-info h3 {
    color: #fff;
}
.order-info strong {
    color: #fff;
}
.reply-form label {
    color: #fff;
}
.message-section>h5 {
    color: #fff;
}
.reply-section>h5 {
    color: #fff;
}
.single-message {
    background: #0a0d14;
}
.user-infos h6.name {
    color: #fff;
}
.single-message .user-infos span.type {
    color: #73818c;
}
.message p {
    color: #73818c;
}
.description p {
    color: #73818c;
}
.form_control {
    border: 1px solid #ffffff2a;
}