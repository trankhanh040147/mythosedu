<?php if(!count($outstanding)){return;} ?>

<style>
    #tutor-pmpro-outstanding-categories {
        background: #FFFFFF;
        border: 1px solid #E0E2EA;
        box-sizing: border-box;
        border-radius: 6px;
        padding: 15px 20px;
        margin-top: 25px;
    }

    #tutor-pmpro-outstanding-categories>div {
        background: #F6F8FD;
        border: 1px solid #D2DBF5;
        box-sizing: border-box;
        border-radius: 6px;
        padding: 25px 20px;
        overflow: auto;
    }

    #tutor-pmpro-outstanding-categories>div>div {
        float:left;
    }

    #tutor-pmpro-outstanding-categories>div>div:first-child{
        width:60px;
    }

    #tutor-pmpro-outstanding-categories>div>div:last-child{
        width: calc(100% - 60px);
    }

    #tutor-pmpro-outstanding-categories h3 {
        margin-top: 17px;
        font-style: normal;
        font-weight: bold;
        font-size: 20px;
        color: #28408E;
    }

    #tutor-pmpro-outstanding-categories p{
        font-style: normal;
        font-weight: normal;
        font-size: 15px;
        color: #28408E;
    }

    #tutor-pmpro-outstanding-categories  span{
        background: #E9EDFB;
        border: 1px solid #D2DBF5;
        box-sizing: border-box;
        border-radius: 100px;

        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        color: #28408E;
        opacity: 0.9;
        margin-right: 10px;
        margin-bottom: 10px;
        display: inline-block;
        padding: 6px 22px;
    }
</style>

<div id="tutor-pmpro-outstanding-categories">
    <div>
        <div>
            <img src="<?php echo TUTOR_PMPRO()->url; ?>assets/images/info.svg"/>
        </div>
        <div>
            <h3><?php _e('Tutor course categories not used in any level', 'tutor-pro'); ?></h3>
            <p><?php _e('Some course categories from LMS are not in any category. Make sure you have them in a category if you want to monetize them. Otherwise, they will be free to access.', 'tutor-pro'); ?></p>
            
            <div class="tutor-outstanding-cat-holder">
                <?php 
                    foreach($outstanding as $cat) {
                        echo '<span>' . $cat->name . '</span>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>