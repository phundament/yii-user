<?php
$count  = count($reply['add_data']['codes']);
$length = strlen($count);
?>
<style>
    table {
        text-align: right;
    }
</style>
<table>
    <tr class="title">
        <td colspan="4">
            <?php echo UserModule::t("Expire date"); ?>: <?php echo $reply['add_data']['expire_date']; ?>
        </td>
    </tr>
    <tr class="title">
        <td colspan="4">
        </td>
    </tr>
    <tr>
        <td>
            <?php

            foreach ($reply['add_data']['codes'] as $nr => $code) {
                
                $nr = str_pad($nr, $length, '0', STR_PAD_LEFT);
                ?>
                <?php echo $nr; ?>. <?php echo $code; ?>
                <?php
                
                if ($nr < $count) {
                    
                    if (!($nr % 8)) {
                        ?>
                        </td><td>
                        <?php
                    } else {
                        ?>
                        <br/>
                        <?php
                    }
                    
                }

            }

            ?>
        </td>
    </tr>
</table>