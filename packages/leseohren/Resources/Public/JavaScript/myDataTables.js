// See https://datatables.net
addEventListener('DOMContentLoaded', () => {
    let tablePersonList = new DataTable('#personList', {
        select: true,
        searchPanes: true,
        responsive: true,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Personen Liste',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8],
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10
                            doc.styles.tableHeader.fontSize = 11
                            doc.styles.tableHeader.bold = true
                        },
                    },
                    'copyHtml5',
                    'csvHtml5',
                    'print',
                ],
            },
            bottom: {
                searchPanes: {
                    initCollapsed: true,
                },
            },
        },
        columnDefs: [
            {
                searchPanes: {
                    show: false,
                },
                targets: [0],
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [1],
            },
            {
                searchPanes: {
                    show: true,
                    orthogonal: {
                        filter: 'spFilter'
                    }
                },
                targets: [2],
                render: function (data, type, row, meta) {
                    const cell = meta && meta.col !== undefined && meta.row !== undefined
                        ? tablePersonList.cell(meta.row, meta.col).node()
                        : null;
                    if (cell) {
                        const search = cell.querySelector('[data-search]');
                        if (search) {
                            const searchValue = search.getAttribute('data-search') || '';
                            const categoriesArray = searchValue.split(',').map(s => s.trim()).filter(Boolean);
                            if (
                                type === 'spFilter' ||
                                type === 'filter' ||
                                type === 'search' ||
                                type === 'display'
                            ) {
                                return categoriesArray;
                            }
                            // Für sort etc. einen String zurückgeben
                            return searchValue;
                        }
                    }
                    return data;
                },
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [3],
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [4],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [5],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [6],
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [7],
            },
            {
                searchPanes: {
                    show: true,
                    orthogonal: {
                        filter: 'spFilter'
                    }
                },
                targets: [8],
                render: function (data, type, row, meta) {
                    const cell = meta && meta.col !== undefined && meta.row !== undefined
                        ? tablePersonList.cell(meta.row, meta.col).node()
                        : null;
                    if (cell) {
                        const search = cell.querySelector('[data-search]');
                        if (search) {
                            const searchValue = search.getAttribute('data-search') || '';
                            const categoriesArray = searchValue.split(',').map(s => s.trim()).filter(Boolean);
                            if (
                                type === 'spFilter' ||
                                type === 'filter' ||
                                type === 'search' ||
                                type === 'display'
                            ) {
                                return categoriesArray;
                            }
                            // Für sort etc. einen String zurückgeben
                            return searchValue;
                        }
                    }
                    return data;
                },
            },
            {
                orderable: false,
                searchPanes: {
                    show: false,
                },
                targets: [9],
            },
        ],
    })

    let tableOrganizationList = new DataTable('#organizationList', {
        select: true,
        searchPanes: true,
        responsive: true,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Organisationen Liste',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10
                            doc.styles.tableHeader.fontSize = 11
                            doc.styles.tableHeader.bold = true
                        },
                    },
                    'copyHtml5',
                    'csvHtml5',
                    'print',
                ],
            },
            bottom: {
                searchPanes: {
                    initCollapsed: true,
                },
            },
        },
        columnDefs: [
            {
                searchPanes: {
                    show: false,
                },
                targets: [0],
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [1],
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [2],
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [3],
            },
            {
                orderable: false,
                searchPanes: {
                    show: false,
                },
                targets: [4],
            },
        ],
    })

    let tableEventList = new DataTable('#eventList', {
        select: true,
        searchPanes: true,
        responsive: true,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Veranstaltungen Liste',
                        exportOptions: {
                            columns: [1, 2, 3, 4],
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10
                            doc.styles.tableHeader.fontSize = 11
                            doc.styles.tableHeader.bold = true
                        },
                    },
                    'copyHtml5',
                    'csvHtml5',
                    'print',
                ],
            },
            bottom: {
                searchPanes: {
                    initCollapsed: true,
                },
            },
        },
        order: {
            idx: 1,
            dir: 'asc',
        },
        columnDefs: [
            {
                searchPanes: {
                    show: true,
                },
                visible: false,
                targets: [0],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [1],
                render: DataTable.render.date(),
            },
            {
                searchPanes: {
                    show: true,
                },
                targets: [2],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [3],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [4],
            },
            {
                orderable: false,
                searchPanes: {
                    show: false,
                },
                targets: [5],
            },
        ],
    })

    let tableParticipantsList = new DataTable('#participantsList', {
        select: true,
        paging: false,
        info: false,
        searchPanes: false,
        responsive: true,
        language: {
            ...{ url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' },
            searchPanes: {
                emptyPanes: null,
            },
        },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Teilnehmer-Liste',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10
                            doc.styles.tableHeader.fontSize = 12
                            doc.styles.tableHeader.bold = true
                        },
                    },
                    'copyHtml5',
                    'csvHtml5',
                    'print',
                ],
            },
            bottom: {
                searchPanes: {
                    initCollapsed: true,
                },
            },
        },
        order: {
            idx: 0,
            dir: 'asc',
        },
        columnDefs: [
            {
                searchPanes: {
                    show: false,
                },
                visible: true,
                targets: [0],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [1],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [2],
            },
        ],
    })

    let tableWaitingList = new DataTable('#waitingList', {
        select: true,
        paging: false,
        info: false,
        searchPanes: false,
        responsive: true,
        language: {
            ...{ url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' },
            searchPanes: {
                emptyPanes: null,
            },
        },
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'Warteliste',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10
                            doc.styles.tableHeader.fontSize = 12
                            doc.styles.tableHeader.bold = true
                        },
                    },
                    'copyHtml5',
                    'csvHtml5',
                    'print',
                ],
            },
            bottom: {
                searchPanes: {
                    initCollapsed: true,
                },
            },
        },
        order: {
            idx: 0,
            dir: 'asc',
        },
        columnDefs: [
            {
                searchPanes: {
                    show: false,
                },
                visible: true,
                targets: [0],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [1],
            },
            {
                searchPanes: {
                    show: false,
                },
                targets: [2],
            },
        ],
    })
})


console.log('leseohren myDataTables.js loaded!')
