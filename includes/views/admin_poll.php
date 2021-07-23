
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <a href="?page=new-poll" class="page-title-action">Créer un sondage</a>
    <hr class="wp-header-end">

    <table class="wp-list-table widefat fixed striped table-view-list users">
        <thead>
        <tr>
            <th scope="col">
                <a href="">
                    <span>Date</span><span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col">
                <a href="">
                    <span>Sondage(s)</span><span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col">
                <a href="">
                    <span>Question</span><span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col">
                <a href="">
                    <span>Résultats</span><span class="sorting-indicator"></span>
                </a>
            </th>  <th scope="col">
            </th>

        </tr>
        </thead>
        <tbody id="the-list">
        <?php
        foreach ( $polls as $poll ){
        ?>
            <tr id="poll-">
                <td class="has-row-actions">
                    <strong>
                        <a href="" class="edit">
                            <span><?php
                                echo date('d/m/Y H:i:s', strtotime($poll['createDate']));
                            ?></span>
                        </a>
                    </strong>
                    <div class="row-actions">
            <span>
              <a href="">
                <strong style="color: #555"></strong>
                <span alt="f105" class="dashicons dashicons-admin-page"></span>
              </a>
            </span>
                    </div>
                </td>
                    <td class="has-row-actions column-primary">
                        <strong>
                            <a href="" class="edit">
                                <span><?= $poll['titre']; ?></span>
                            </a>
                        </strong>
                        <div class="row-actions">
                            <span class="edit"><a href=""></a></span> |
                            <span class="delete"><a class="submitdelete" href=""></a>
                        </div>
                    </td>
                    <td class="has-row-actions column-primary">
                        <strong>
                            <a href="" class="edit">
                                <span><?= $poll['question']; ?></span>
                            </a>
                        </strong>
                        <div class="row-actions">
                            <span class="edit"><a href=""></a></span> |
                            <span class="delete"><a class="submitdelete" href=""></a>
                        </div>
                    </td>
                    <td class="has-row-actions column-primary">
                        <strong>
                            <a href="" class="edit">
                                <span><?= "Réponses : ". $poll['countReponse']; ?></span>
                            </a>
                            <?php
                            foreach ( $answers as $answer ){
                                echo "</br>".$answer['reponse'] ." : ". $answer['countReponse'];
                             } ?>
                        </strong>
                    </td>
                <td class="has-row-actions column-primary">
                    <strong>
                        <span class="edit"><a href="">Editer</a></span> |
                        <span class="delete"><a class="submitdelete" href="">Supprimer</a></span>
                    </strong>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>