<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post">
        <div>
            <table class="form-table" role="presentation" id="createuser">
                <tr class="form-field form-required">
                <tr class="form-field form-required">
                    <th>
                        <label>Titre du sondage</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_title" value="titre" required/>
                    </td>
                </tr>
                <th>
                    <label>Question</label>
                </th>
                <td>
                    <textarea name="strawpoule_question" style="width: auto" rows="5" cols="53" required>question</textarea>
                </td>
                </tr>
                <tr class="form-required">
                    <th>
                        <label>Réponse libre</label>
                    </th>
                    <td>
                        <input type="checkbox" id="horns" name="horns">
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th>
                        <label>#1</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_response_1" value="test" required />
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th>
                        <label>#2</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_response_2" value="test" required />
                    </td>
                </tr>
                <tr class="form-field">
                    <th>
                        <label>#3</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_response_3" value="test"/>
                        <a href="#">Supprimer</a>

                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#" id="add-response">Ajouter une réponse</a>
                    </td>
                </tr>
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