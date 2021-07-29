<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post">
        <input type="hidden" name="strawpoule_id" value="<?php echo $item_question['id']; ?>" />
        <div>
            <table class="form-table" role="presentation" id="createuser">
                <tr class="form-field form-required">
                <tr class="form-field form-required">
                    <th>
                        <label>Titre du sondage</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_titre" value="<?= (empty($_GET['id_poll'])) ? 'défaut' : $item_question['titre']; ?>" required/>
                    </td>
                </tr>
                <th>
                    <label>Question</label>
                </th>
                <td>
                    <textarea name="strawpoule_question" style="width: auto" rows="5" cols="53" required><?= (empty($_GET['id_poll'])) ? 'défaut' : $item_question['question']; ?></textarea>
                </td>
                </tr>
                <?php if(!$_GET['id_poll']) { ?>
                <tr class="form-field form-required">
                    <th>
                        <label>#1</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_reponse_1" required />
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th>
                        <label>#2</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_reponse_2" required />
                    </td>
                </tr>
                <tr class="form-field">
                    <th>
                        <label>#3</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_reponse_3"/>
                        <a href="#">Supprimer</a>
                    </td>
                </tr>
                <?php } else {
                    $i = 1;
                    foreach($item_response as $response) {
                        if(!empty($response)) { ?>
                            <tr class="form-field form-required">
                                <th>
                                    <label>#<?= $i; ?></label>
                                </th>
                                <td>
                                    <input type="text" name="strawpoule_reponse_<?= $i; ?>" value="<?= $response['reponse'] ?>" required />
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                <?php
                        $i++;
                    }
                    if($i < 4) {
                        ?>
                        <tr class="form-field form-required">
                            <th>
                                <label>#<?= $i; ?></label>
                            </th>
                            <td>
                                <input type="text" name="strawpoule_reponse_<?= $i; ?>" value="" />
                            </td>
                        </tr>
                    <?php
                        $i++;
                    }
                }
                ?>
            </table>
        </div>
        <?php
        //wp_nonce_field();
        submit_button();
        ?>
    </form>
</div>
<script>
    var response_component = {

    }
    jQuery('#add-response').on('click', function() {

        alert('qzd');
    })
</script>