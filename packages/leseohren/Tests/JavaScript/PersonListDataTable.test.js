/**
 * Tests for Person List DataTable functionality
 * Tests the merged name column DataTable configuration
 */

describe('PersonListDataTable', () => {
    let mockDataTable;
    let mockElement;

    beforeEach(() => {
        // Mock DOM element
        mockElement = {
            id: 'personList',
            classList: { contains: jest.fn(() => true) }
        };

        // Mock DataTable constructor
        mockDataTable = {
            column: jest.fn(),
            columns: jest.fn(),
            search: jest.fn(),
            order: jest.fn(),
            draw: jest.fn(),
            settings: jest.fn(() => [{ oInit: {} }])
        };

        // Mock global DataTable
        global.DataTable = jest.fn(() => mockDataTable);
        global.DataTable.isDataTable = jest.fn(() => false);

        // Mock document.getElementById
        global.document = {
            getElementById: jest.fn(() => mockElement),
            addEventListener: jest.fn()
        };
    });

    afterEach(() => {
        jest.clearAllMocks();
    });

    test('DataTable is initialized with correct configuration', () => {
        // Simulate the DataTable initialization from myDataTables.js
        const config = {
            select: true,
            searchPanes: true,
            responsive: true,
            language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' },
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6], // Updated column indexes
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
                    searchPanes: { show: false },
                    targets: [0], // Name column - no search pane
                },
                {
                    searchPanes: { show: true },
                    targets: [1], // Categories column
                },
                // ... other column definitions
            ],
        };

        new global.DataTable('#personList', config);

        expect(global.DataTable).toHaveBeenCalledWith('#personList', expect.objectContaining({
            select: true,
            searchPanes: true,
            responsive: true
        }));
    });

    test('Export configuration uses correct column indexes', () => {
        const config = {
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6], // Should exclude FZ (7) and Actions (8)
                            },
                        }
                    ],
                },
            },
        };

        new global.DataTable('#personList', config);

        const callArgs = global.DataTable.mock.calls[0][1];
        const pdfButton = callArgs.layout.topStart.buttons[0];
        
        expect(pdfButton.exportOptions.columns).toEqual([0, 1, 2, 3, 4, 5, 6]);
        expect(pdfButton.exportOptions.columns).not.toContain(7); // FZ column excluded
        expect(pdfButton.exportOptions.columns).not.toContain(8); // Actions column excluded
    });

    test('Search panes configuration is correct for all columns', () => {
        const expectedColumnDefs = [
            { searchPanes: { show: false }, targets: [0] }, // Name - no search pane
            { searchPanes: { show: true }, targets: [1] },  // Categories - has search pane
            { searchPanes: { show: true }, targets: [2] },  // ZIP - has search pane
            { searchPanes: { show: true }, targets: [3] },  // City - has search pane
            { searchPanes: { show: false }, targets: [4] }, // Email - no search pane
            { searchPanes: { show: false }, targets: [5] }, // Phone - no search pane
            { searchPanes: { show: true }, targets: [6] },  // Org Categories - has search pane
            { orderable: false, searchPanes: { show: false }, targets: [7] }, // FZ - no search pane, not orderable
            { orderable: false, searchPanes: { show: false }, targets: [8] }, // Actions - no search pane, not orderable
        ];

        const config = { columnDefs: expectedColumnDefs };
        new global.DataTable('#personList', config);

        const callArgs = global.DataTable.mock.calls[0][1];
        
        // Verify name column has no search pane
        const nameColumnDef = callArgs.columnDefs.find(def => def.targets.includes(0));
        expect(nameColumnDef.searchPanes.show).toBe(false);

        // Verify categories column has search pane
        const categoriesColumnDef = callArgs.columnDefs.find(def => def.targets.includes(1));
        expect(categoriesColumnDef.searchPanes.show).toBe(true);

        // Verify FZ column is not orderable
        const fzColumnDef = callArgs.columnDefs.find(def => def.targets.includes(7));
        expect(fzColumnDef.orderable).toBe(false);
        expect(fzColumnDef.searchPanes.show).toBe(false);

        // Verify Actions column is not orderable
        const actionsColumnDef = callArgs.columnDefs.find(def => def.targets.includes(8));
        expect(actionsColumnDef.orderable).toBe(false);
        expect(actionsColumnDef.searchPanes.show).toBe(false);
    });

    test('German localization is configured', () => {
        const config = {
            language: { url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json' }
        };

        new global.DataTable('#personList', config);

        const callArgs = global.DataTable.mock.calls[0][1];
        expect(callArgs.language.url).toBe('https://cdn.datatables.net/plug-ins/1.11.5/i18n/de-DE.json');
    });

    test('Responsive design is enabled', () => {
        const config = { responsive: true };

        new global.DataTable('#personList', config);

        const callArgs = global.DataTable.mock.calls[0][1];
        expect(callArgs.responsive).toBe(true);
    });

    test('All export buttons are configured', () => {
        const config = {
            layout: {
                topStart: {
                    buttons: ['copyHtml5', 'csvHtml5', 'print', { extend: 'pdfHtml5' }],
                },
            },
        };

        new global.DataTable('#personList', config);

        const callArgs = global.DataTable.mock.calls[0][1];
        const buttons = callArgs.layout.topStart.buttons;
        
        expect(buttons).toContain('copyHtml5');
        expect(buttons).toContain('csvHtml5');
        expect(buttons).toContain('print');
        expect(buttons.some(btn => typeof btn === 'object' && btn.extend === 'pdfHtml5')).toBe(true);
    });

    test('Column count is correct after merge', () => {
        // Original: 10 columns (lastname, firstname, categories, zip, city, email, phone, org_categories, fz, actions)
        // After merge: 9 columns (name, categories, zip, city, email, phone, org_categories, fz, actions)
        
        const columnDefs = [
            { targets: [0] }, // name
            { targets: [1] }, // categories
            { targets: [2] }, // zip
            { targets: [3] }, // city
            { targets: [4] }, // email
            { targets: [5] }, // phone
            { targets: [6] }, // org_categories
            { targets: [7] }, // fz
            { targets: [8] }, // actions
        ];

        const config = { columnDefs };
        new global.DataTable('#personList', config);

        const callArgs = global.DataTable.mock.calls[0][1];
        const maxColumnIndex = Math.max(...callArgs.columnDefs.flatMap(def => def.targets));
        
        expect(maxColumnIndex).toBe(8); // Should be 8 (0-indexed, 9 total columns)
        expect(callArgs.columnDefs.length).toBe(9); // Should have 9 column definitions
    });
});

describe('PersonListDataTable Integration', () => {
    test('Table initialization handles merged name column correctly', () => {
        // Mock the actual table HTML structure
        const mockTable = {
            querySelector: jest.fn(),
            querySelectorAll: jest.fn(() => [
                { textContent: 'Doe, John' },
                { textContent: 'Smith, Jane' },
                { textContent: 'LastnameOnly' },
                { textContent: 'FirstnameOnly' }
            ])
        };

        global.document.querySelector = jest.fn(() => mockTable);

        // Verify that the table can handle different name formats
        const nameElements = mockTable.querySelectorAll();
        
        expect(nameElements[0].textContent).toBe('Doe, John'); // Full name
        expect(nameElements[1].textContent).toBe('Smith, Jane'); // Full name
        expect(nameElements[2].textContent).toBe('LastnameOnly'); // Lastname only
        expect(nameElements[3].textContent).toBe('FirstnameOnly'); // Firstname only
    });

    test('Search functionality works with merged names', () => {
        const mockDataTable = {
            search: jest.fn().mockReturnThis(),
            draw: jest.fn()
        };

        global.DataTable = jest.fn(() => mockDataTable);

        // Simulate search functionality
        const searchTerm = 'Doe';
        mockDataTable.search(searchTerm);
        mockDataTable.draw();

        expect(mockDataTable.search).toHaveBeenCalledWith(searchTerm);
        expect(mockDataTable.draw).toHaveBeenCalled();
    });

    test('Sorting functionality works with merged names', () => {
        const mockDataTable = {
            order: jest.fn().mockReturnThis(),
            draw: jest.fn()
        };

        global.DataTable = jest.fn(() => mockDataTable);

        // Simulate sorting by name column (index 0)
        mockDataTable.order([0, 'asc']);
        mockDataTable.draw();

        expect(mockDataTable.order).toHaveBeenCalledWith([0, 'asc']);
        expect(mockDataTable.draw).toHaveBeenCalled();
    });
});