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
- **PDF Export**: Uses `dompdf/dompdf`. Table-based layout for high precision on A4.
- **Printing & Selection**:
  - Selection is strictly client-side via JavaScript (no `is_selected` in database).
  - Supports label type **121** (38x75mm).
  - Automatic print trigger via `window.print()`.
  - Hard limit of **10 recipients** per print batch to ensure alignment.
  - Prefix "di-" added automatically. If address is empty, uses "Tempat".

## Preferred Styles
- Controller logic: Concise; use models for DB interaction.
- UI Design: Minimal dashboard style, using modern standard web conventions (modals, client-side interactions where appropriate).
- Interaction: Single-page workflow using Modals for CRUD (Recipients and Users).
- Data State: Use fetch API for background updates (e.g., printed status).
- Bulk Actions: Client-side gathering of IDs for mass operations.
