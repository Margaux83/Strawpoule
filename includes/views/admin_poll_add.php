<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post">
        <div class="wrapper">
            <table class="form-table" role="presentation" id="createuser">
                <tr class="form-field form-required">
                    <th>
                        <label>Titre du sondage</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_titre" value="titre" required/>
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
                <tr class="form-field form-required ">
                    <th>
                        <label>#1</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_reponse_1" value="test" required />
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th>
                        <label>#2</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_reponse_2" value="test" required />
                    </td>
                </tr>
                <tr class="form-field form-required">
                    <th>
                        <label>#3</label>
                    </th>
                    <td>
                        <input type="text" name="strawpoule_reponse_3" value="test"/>
                    </td>
                </tr>
                <tr class="form-field form-required reponse">
                </tr>
                <tr>
                    <td>
                        <button id="add-response">Ajouter une réponse</button>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        submit_button();
        ?>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    /*var response_component = {

    }
    jQuery('#add-response').on('click', function() {

        alert('qzd');
    })*/

    /*$(document).ready(function() {
        var max_fields = 10;
        var wrapper = $(".form-field.form-required.reponse");
        var add_button = $("#add-response");

        var x = 1;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append(
                    '   <th class="form-field-add">' +
                    '   <label>#'+
                    '</label>' +
                    ' </th>' +
                    ' <td>' +
                    '<div><input type="text" name="strawpoule_reponse_3"/><button class="delete">Supprimer</button></div>' +

                    '  </td><br>' );
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $('.form-field-add').remove();
            x--;
        })
    });*/
    var x = 1;
        $('#add-response').click(function(e) {

            e.preventDefault();
            const wrapper = $(".form-field.form-required.reponse");
            $(wrapper).append(
                    '   <th class="form-field-add">' +
                    '   <label>#'+
                    '</label>' +
                    ' </th>' +
                    ' <td>' +
                    '<div><input type="text" name="strawpoule_reponse_3"/><button class="delete">Supprimer</button></div>' +

                    '  </td><br>' );
        });


    /*$('.form-field.form-required.reponse').on("click", ".delete", function(e) {
        e.preventDefault();
        $('.form-field-add').remove();
        x--;
    })*/
   $('.delete').click( function(e) {
            e.preventDefault();
         $('.form-field-add').remove();
        });
</script>