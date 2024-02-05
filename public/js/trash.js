$(document).ready(function() {
    let table = null;
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
                $('#trash_modal').modal('show');
                $('#submit').on('click', function() {
                    let action = $('[name="action"]:checked').val();
                    if (action) {
                        $.ajax({
                            type: (action === 'delete') ? "DELETE" : "POST",
                            url: "/task/trash",
                            data: {
                                task_id : row._row.data.task_id,
                                _token  : $('[name="csrf-token"]').prop('content')
                            },
                            complete : function(data) {
                                data = JSON.parse(data.responseText)
                                alert(data.message);
                                if (data.status) {
                                    $('#trash_modal').modal('hide');
                                    load.loadTableData();
                                }
                            }
                        });
                    } else {
                        alert('Please select an action.');
                    }
                });
            });
        },
        getStatusValues : (value, data) => {
            return data.task_status[0].status;
        },
        loadTableData : () => {
            setTimeout(() => {
                table.setData("/task/trash");
            }, 100)
        }
    }

    load.init();
    load.ajaxSetup();
    load.bindEvents();
    load.loadTableData();
});

