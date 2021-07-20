
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
                    <span>Résultats</span><span class="sorting-indicator"></span>
                </a>
            </th>
        </tr>
        </thead>
        <tbody id="the-list">
            <tr id="poll-">
                <td class="has-row-actions">
                    <strong>
                        <a href="" class="edit">
                            <span></span>
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
                            <span></span>
                        </a>
                    </strong>
                    <div class="row-actions">
                        <span class="edit"><a href=""></a></span> |
                        <span class="delete"><a class="submitdelete" href=""></a>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>