$(document).ready(function() {
    let table = null;
    let checkboxes = [];
    const load = {
        init : () => {
            table = new Tabulator("#myTable", {
                pagination : true,
                filterMode : "local",
                layout : "fitColumns",
                paginationSize : 10,
                placeholder : "No Data",
                columns : [
                    {
                        title    : "Title",
                        field    : "title",
                        sorter   : "string",
                        hozAlign : "left",
                        width    : 200
                    },
                    {
                        title    : "Content",
                        field    : "content",
                        sorter   : "string",
                        hozAlign : "left"
                    },
                    {
                        title    : "Status",
                        field    : "task_status.status",
                        sorter   : "string",
                        hozAlign : "center",
                        width    : 200,
                        mutator  : load.getStatusValues
                    },
                    {
                        title        : "Date Created",
                        field        : "created_at",
                        sorter       : "datetime",
                        hozAlign     : "center",
                        width        : 200,
                        sorterParams : {
                            format : "yyyy-MM-dd HH:mm:ss"
                        }
                    },
                    {
                        title    : "Last Updated",
                        field    : "updated_at",
                        sorter   : "datetime",
                        hozAlign : "center",
                        width    : 200
                    },
                ],
            });
        },
        ajaxSetup : () => {
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },
        bindEvents : () => {
            table.on("rowClick", function(e, row){
                $('#task_modal').modal('show');
                $('#delete').prop({hidden : false});
                $('#title-header').text("Edit Task");

                var task_id = row._row.data.task_id;
                var title = row._row.data.title;
                var content = row._row.data.content;
                var task_status = row._row.data.task_status[0];
                var task_status_id = task_status.task_status_id;
                var is_draft = row._row.data.is_draft;

                load.setDropdown(task_status_id);

                $('[name="task_id"]').val(task_id);
                $('[name="title"]').val(title);
                $('[name="content"]').val(content);
                $('[name="is_draft"]').prop("checked", is_draft);
            });

            $('#add').click(function(){
                $('#delete').prop({hidden : true});
                $('#title-header').text("Add Task");

                $('#task_modal').modal('show');
                $('[name="task_id"]').val(null);
                $('[name="title"]').val("");
                $('[name="content"]').val("");
                $('[name="is_draft"]').prop("checked", false);

                load.setDropdown(null);
            });

            $('#submit').click(function() {
                $.ajax({
                    type: "POST",
                    url: "/task",
                    data: {
                        task_id        : $('[name="task_id"]').val(),
                        task_status_id : $('[name="task_status_id"]').val(),
                        title          : $('[name="title"]').val(),
                        content        : $('[name="content"]').val(),
                        is_draft       : $('[name="is_draft"]').prop('checked')
                    },
                    complete : function(data) {
                        data = JSON.parse(data.responseText)
                        alert(data.message);
                        if (data.status) {
                            load.loadTableData();
                            $('#task_modal').modal('hide');
                        }
                    }
                });
            });

            $('#delete').click(function() {
                $.ajax({
                    type: "DELETE",
                    url: "/task",
                    data: {
                        task_id : $('[name="task_id"]').val()
                    },
                    complete : function(data) {
                        data = JSON.parse(data.responseText)
                        alert(data.message);
                        if (data.status) {
                            load.loadTableData();
                            $('#task_modal').modal('hide');
                        }
                    }
                });
            });

            $('[name="task_status_ids"]').on('change', () => load.loadTableData());
            $('[name="search"]').on('keyup mouseup', () => load.loadTableData());
        },
        getCheckboxes: () => {
            checkboxes = [];
            $('[name="task_status_ids"]:checked').each(function(){
                checkboxes.push($(this).val());
            });
        },
        getStatusValues : (value, data) => {
            return data.task_status[0].status;
        },
        setDropdown : (taskStatusId) => {
            $('[name=task_status_id]').empty();
            $.get('/task/status', (response) => {
                response.forEach(function( e) {
                    var option = $("<option>").text(e.status).val(e.task_status_id);
                    (taskStatusId == e.task_status_id && option.attr("selected", true));
                    $('[name=task_status_id]').append(option);
                });
            });
        },
        loadTableData : () => {
            load.getCheckboxes();
            setTimeout(() => {
                table.setData("/task", {
                    title           : $('[name="search"]').val(),
                    task_status_ids : checkboxes
                });
                table.setSort([
                    {
                        column : "title",
                        dir    : "asc"
                    },
                    {
                        column : "created_at",
                        dir    : "asc"
                    }
                ]);
            }, 100);
        }
    }

    load.init();
    load.ajaxSetup();
    load.bindEvents();
    load.loadTableData();
});
