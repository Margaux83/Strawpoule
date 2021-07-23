<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?>
  </h1>
  <form method="post">
    <div>
      <table class="form-table" role="presentation" id="createuser">
        <tr class="form-field form-required">
                  <tr class="form-field form-required">
                      <th><label>Titre du sondage</label></th>
                      <td><input type="text" name="title-poll" value="" required /></td>
                  </tr>
                  <th><label>Question</label></th>
                  <td><textarea name="question-poll" style="width: auto" rows="5" cols="40" required /></textarea></td>
                </tr>
                <tr class="form-field form-required">
                    <th><label>#1</label></th>
                    <td><input type="text" name="name-choice1" value="" required /></td>
                </tr>
                <tr class="form-field form-required">
                    <th><label>#2</label></th>
                    <td><input type="text" name="name-choice2" value="" required /></td>
                </tr>
                <tr class="form-field">
                    <th><label>#3</label></th>
                    <td><input type="text" name="name-choice3" value=""/></td>
                </tr>
                <tr class="form-field">
                    <th><label>#4</label></th>
                    <td><input type="text" name="name-choice4" value=""/></td>
                </tr>
                <tr class="form-field">
                    <th><label>#5</label></th>
                    <td><input type="text" name="name-choice5" value=""/></td>
                </tr>
            </table>
        </div>
        <?php
        wp_nonce_field();
        submit_button(); ?>
    </form>
</div>