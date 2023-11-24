jQuery(function($) {
    class tableJS {
        constructor() {
            this.table = null;
            this.deletedRow = null;
            this.registerEvent();
        }

        registerEvent = () => {
            $("#modal-delete-row #modal-submit").off("click").on("click", this.clickButtonSubmit);
            $("table #row-delete").off("click").on("click", this.clickButtonDelete);

            $(document).off('change.checkall', '.checkall').on('change.checkall', '.checkall', function (ev) {
                ev.preventDefault();
                let checked = $(this).prop('checked');
                let $table = $(this).closest('table');
                $table.find('td .switch input[type="checkbox"]').prop('checked', checked);
                let numberOfChecked = $table.find('td .switch input[type="checkbox"]:checked').length;
                if( numberOfChecked ){
                    $('.action-after-checked', $(this).closest('.wrap-layout')).removeClass('hidden');
                }else{
                    $('.action-after-checked', $(this).closest('.wrap-layout')).addClass('hidden');
                }
            });
        };

        clickButtonDelete = (ev) => {
            ev.preventDefault();
            this.deletedRow = $(ev.currentTarget);
            let id = this.deletedRow.data("id");
            let title = this.deletedRow.data("title");

            $("#modal-delete-row").find("input[name='id']").val(id);
            $("#modal-delete-row").find(".item-title").html(title);
        };

        clickButtonSubmit = (ev) => {
          //  ev.preventDefault();

            //console.log(this.deletedRow);

        };
    }

    new tableJS();
});