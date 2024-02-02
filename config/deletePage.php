<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Suppresion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 

            <div class="modal-body">
                <input type="hidden" name="deleteId" id="deleteId">
                <h4 id="lb_msg_delete" style="font-size: 14px;">Voulez-vous supprimer ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm btn_oui" data-dismiss="modal" id="btn_oui">Oui</button>
                <button type="submit" class="btn btn-primary btn-sm" data-dismiss="modal" name="deleteData" id="btn_non">Non</button>
            </div>

        </div>
    </div>
</div>