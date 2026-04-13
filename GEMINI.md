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
- **Excel Import**: Uses `phpoffice/phpspreadsheet`. Skips headers and duplicate name+address pairs.
- **Printing & Selection**:
  - **Server-side Selection**: Persistent selection state stored in the database (`is_selected`).
  - **Sticky Toolbar**: Real-time selected count and actions (Print/Clear) in a full-width footer toolbar.
  - **Label Offset**: Supports starting print from any position (1-10) to reuse partially spent sticker sheets.
  - **Label Type 121**: Precision layout for 38x75mm stickers (2 columns x 5 rows).
  - **Print Layout**: Visualized with yellow backing and white stickers in the browser preview.
  - **Auto-Print**: Triggers `window.print()` automatically when parameters are met.
  - **Batch Limit**: Strictly enforces a maximum of 10 recipients per print page.
  - **Auto-Prefix**: "di-" added automatically. If address is empty, uses "Tempat".
- **Visual Assets**: Uses high-quality SVGs for all technical illustrations (Printer, Alignment, Flow).
- **Interactive Guides**: Print alignment and position guides include a click-to-preview modal for better visibility.

## Preferred Styles
- Controller logic: Concise; use models for DB interaction.
- UI Design: Minimal dashboard style, using modern standard web conventions (modals, client-side interactions where appropriate).
- Interaction: Single-page workflow using Modals for CRUD (Recipients and Users).
- Data State: Use fetch API for background updates (e.g., printed status, selection state).
- Bulk Actions: Handled via AJAX with immediate UI feedback.
