<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped" id="{ID}">
        <thead>
        <tr>
            {HEADER}
        </tr>
        </thead>
        <tbody>
        {BODY}
        </tbody>
    </table>
</div>
<script>
    window.onload = function () {
        if ({DATATABLE}) {
            var {ID} =
            $('#{ID}').DataTable({
                'pageLength': 25
            });
        }
    }
</script>

