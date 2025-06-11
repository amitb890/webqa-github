<script src="{{ asset('new-assets/js/project-list.js') }}"></script>
<script src="{{ asset('new-assets/vendor/datatable/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var projectDataTable = $('#projects-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('getProjectData') }}",
                data: function(d) {
                    d.search = $('input[type="search"]').val();
                }
            },
            columns: [{
                    data: 'name',
                    name: 'name',
                    render: function(data, type, row) {
                        // Customize the rendering of the "name" column here
                        var activeFavicon = '';
                        if (row.favicon == "default" || row.favicon == "") {
                            activeFavicon = "/new-assets/assets/images/amazon.png";
                        } else {
                            activeFavicon = row.favicon;
                        }
                        return `<td class="project_action"><p>
                    <img src="${activeFavicon}" alt="icon" class="datatableFaviconImage">
                    ${row.name}</p>
                        </td>`;
                    }
                },
                {
                    data: 'homepage',
                    name: 'homepage'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <td class="project_action"><span class="project_action">
                            <a href="/projects/${row.id}/edit"> <img
                                src="{{ asset('new-assets/assets/images/project/edit.png') }}" alt="icon"
                                data-id="${row.id}" title="Edit"> </a>
                            <a href="/settings/${row.id}/edit"> <img
                                src="{{ asset('new-assets/assets/images/project/setting.png') }}" alt="icon"
                                title="Setting"></a>
                            <img src="{{ asset('new-assets/assets/images/project/delete.png') }}" alt="icon"
                                class="deleteProject" data-id="${row.id}" title="Delete"><span>
                        </td>
                    `;
                    }
                }
            ]
        });

    });
</script>
