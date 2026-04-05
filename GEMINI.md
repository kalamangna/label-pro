# LabelPro Memory

## Architectural Decisions
- **Framework**: CodeIgniter 4.7.2.
- **Frontend Stack**: Tailwind CSS v4 + Vite + Alpine.js.
- **Asset Resolution**: Vite during development (`localhost:5173`), `manifest.json` parsing in production.
- **Branding**: Official name is **LabelPro** (CamelCase).
- **UI Theme**: 
  - Primary: `emerald` (Elegant Green).
  - Accent: `amber` (Gold).
- **Localization**: User Interface is 100% in **Bahasa Indonesia**.
- **Excel Import**: Uses `phpoffice/phpspreadsheet`. Skips headers and duplicate names.
- **PDF Export**: Uses `dompdf/dompdf`. Table-based layout for high precision on A4.
- **Printing**:
  - Supports label types **103** (32x64mm) and **121** (38x75mm).
  - Automatic print trigger via `window.print()`.
  - Hard limit of **10 recipients** per print batch to ensure alignment.
  - Prefix "di-" added before addresses with a line break.

## Preferred Styles
- Controller logic should be concise; use models for DB interaction.
- UI must follow a modern dashboard style with a sidebar.
- Use Fetch API for real-time status updates (is_selected, is_printed).
