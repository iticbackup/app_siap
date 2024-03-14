<div class="modal fade modalEditTeam" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="edit_title_kpi_team"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-team-update" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="edit_kpi_departemen_id" id="edit_kpi_departemen_ids">
            <div class="modal-body">
                <table class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Team</th>
                            <th class="text-center">Jabatan</th>
                            <th class="text-center">Validasi Verifikasi</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="edit_team_kpi">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-soft-primary btn-sm">Update</button>
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>