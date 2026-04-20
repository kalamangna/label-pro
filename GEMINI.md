# LabelPro Memory

## Architectural Decisions
- **Framework**: CodeIgniter 4.7.2.
- **Frontend Stack**: Tailwind CSS v4 + Vite + Alpine.js + Flowbite.
- **Asset Resolution**: Vite during development (`localhost:5173`), `manifest.json` parsing in production.
- **Authentication & RBAC**:
  - Roles: `admin`, `user`, `demo`.
  - Data Isolation: Users/Demo see their own data; Admins see all data.
  - Demo Mode: Automatic guest account provisioning with isolated session data.
- **Branding**: Official name is **LabelPro** (CamelCase).
- **UI Theme**: 
  - Primary: `emerald` (Elegant Green).
  - Accent: `amber` (Gold) for printing and warnings.
  - Secondary/Filters: `slate` for a clean look.
  - Layout: Minimal light theme using Flowbite components.
- **Localization & Timezone**:
  - UI: 100% **Bahasa Indonesia**.
  - Timezone: `Asia/Jakarta` (WIB).
- **Excel Import**: 
  - Uses `phpoffice/phpspreadsheet`. 
  - Skips headers and duplicate name+jabatan+address sets.
  - Required structure: Kolom A (Nama), Kolom B (Jabatan - Opsional), Kolom C (Alamat - Opsional).
- **Printing & Selection**:
  - **Server-side Selection**: Persistent selection state stored in the database (`is_selected`).
  - **Unlimited Selection**: No hard limit on how many guests can be selected at once.
  - **Multi-page Printing**: Automatically chunks selected guests into groups of 10 for multi-sheet printing.
  - **Sticky Toolbar**: Real-time selected count and actions (Print/Clear) in a full-width footer toolbar.
  - **Label Offset**: Supports starting print from any position (1-10) on the first sheet to reuse partially spent sticker sheets.
  - **Label Type 121**: Precision layout for 38x75mm stickers (2 columns x 5 rows).
  - **Print Layout**: Visualized with yellow backing and white stickers in the browser preview.
  - **Address Logic**: "di-" added automatically. If address is empty, uses "Tempat".
  - **Jabatan Support**: Optional "Jabatan" displayed between name and address with consistent spacing.
- **Event Management**: 
  - The event filter dropdown is removed from the main Guest list for a cleaner UI.
  - Users manage guest lists per event by selecting an event from the Events page.
- **Visual Assets**: Uses high-quality SVGs for all technical illustrations (Printer, Alignment, Flow).
- **Interactive Guides**: Print alignment and position guides include a click-to-preview modal for better visibility.

## Preferred Styles
- Controller logic: Concise; use models for DB interaction.
- UI Design: Minimal dashboard style, using modern standard web conventions (modals, client-side interactions where appropriate).
- Interaction: Single-page workflow using Modals for CRUD (Guests and Events).
- Data State: Use fetch API for background updates (e.g., selection state).
- Bulk Actions: Handled via AJAX with immediate UI feedback.
- Status Management: Individual print status (`is_printed`) is managed via radio buttons within the Edit Modal.
- Table Layout: Status column uses stylized badges (Green "Sudah", Gray "Belum"); important columns use `whitespace-nowrap` for readability.
- Terminology: Consistently use "**Tamu**" (Guest) instead of generic "Data" in labels, buttons, and counts.
