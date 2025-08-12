# TASKS (Generated via MCP TaskManager)

Request ID: req-1

Progress Overview
| Task ID | Title | Status |
|--------|-------|--------|
| task-1 | Enable multiple file upload for Person "other files" field | Planned |
| task-2 | Add modal in person detail view for Certificate of Conduct fields | ✅ Completed |

---

## task-1 — Enable multiple file upload for Person "other files" field

Goal
Enable uploading and managing multiple files in the Person entity’s "file_others" field and persist them as file references.

Checklist
- [ ] Backend (TCA): Allow multiple sys_file_reference items for the "file_others" field (type=inline, maxitems > 1, proper appearance, sorting, and allowed file types).
- [ ] Domain Model: Map the property to ObjectStorage<FileReference> with correct persistence mapping and add add/remove helpers as needed.
- [ ] Persistence/Controller: Ensure create/update actions correctly persist multiple file references and handle removals.
- [ ] Fluid/Form: Add an "Edit" button in the person detail view that opens a Bootstrap modal to support multi-file selection and upload; show selected files.
- [ ] Display: List existing files in the person detail viewwith filename and remove action; handle removal on save.
- [ ] Validation: Server-side validation for file types/size; graceful error handling and messaging.
- [ ] Acceptance: User can upload multiple files, see them listed, remove individual files, and they persist after saving.

Notes
- Follow TYPO3 best practices (Extbase + FAL). Use TYPO3 v13 APIs for file processing and references.
- Analyze the packages/extbase_upload/ Extension, as it contains examples for multiple file upload.
- Maintain CSRF protection in forms and use proper FlashMessages for feedback.

---

## task-2 — Add modal in person detail view for Certificate of Conduct fields ✅ COMPLETED

Goal
From the person detail view, allow editing of certificate of conduct date (fuehrungszeugnis_date) and certificate of conduct checked status (fuehrungszeugnis_checked) via a modal.

Checklist
- [x] UI: Add an "Edit" button in the person detail view that opens a Bootstrap modal containing a date picker (HTML5 date input) and a checkbox.
- [x] Accessibility: Ensure keyboard/focus management, labels, and descriptive help text in the modal.
- [x] Backend: Implement an Extbase action (AJAX-friendly) to update only these fields with validation (date format, required constraints) and CSRF protection.
- [x] Frontend/JS: Submit the modal form via fetch/XHR; on success, update the visible values in the detail view without a full page reload.
- [x] UX: Show success/error feedback; close the modal on success; keep open on validation errors.
- [x] Acceptance: Opening the modal allows editing both fields; changes persist and the detail view reflects updates immediately.

Implementation Summary
- Added edit button and Bootstrap modal in AccordionRight.html with proper form fields
- Implemented updateFuehrungszeugnisAction and initializeUpdateFuehrungszeugnisAction in PersonController.php
- Added proper DateTime conversion, checkbox handling, and flash messages
- Registered new action in ext_localconf.php
- Fixed Fluid template syntax for checkbox value binding
- Tested functionality with local PHP server

Notes
- Keep business logic in Controller/Domain layers, not in templates.
- Ensure proper permission checks and use TYPO3's FormProtection/CSRF mechanisms.
