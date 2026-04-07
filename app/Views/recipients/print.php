<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label <?= $type ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        /* Base Print Settings */
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        /* Container to center the sticker sheet on A4 */
        .page {
            width: 210mm;
            height: 297mm;
            background: white;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* The actual sticker sheet area (approx 165x205mm) */
        .sticker-sheet {
            width: 165mm;
            height: 205mm;
            position: relative;
            display: grid;
            box-sizing: border-box;
        }

        /* Label 103 (32x64mm, 2 cols x 6 rows) */
        .sheet-103 {
            grid-template-columns: 64mm 64mm;
            grid-template-rows: repeat(6, 32mm);
            column-gap: 2mm;
            row-gap: 2mm;
            padding: 1.5mm 17.5mm;
        }

        /* Label 121 (38x75mm, 2 cols x 5 rows) */
        .sheet-121 {
            grid-template-columns: 75mm 75mm;
            grid-template-rows: repeat(5, 38mm);
            column-gap: 2mm;
            row-gap: 2mm;
            padding: 3.5mm 6.5mm;
        }

        .label {
            width: 100%;
            height: 100%;
            padding: 2mm 4mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }

        .name {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 1mm;
        }
        .prefix {
            font-size: 10pt;
            margin-bottom: 1mm;
            text-align: center;
            width: 100%;
        }
        .address {
            font-size: 9pt;
            line-height: 1.1;
        }

        /* Toolbar for preview */
        .toolbar {
            background: #064e3b; /* emerald-950 */
            color: white;
            padding: 15px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        .btn {
            background: #059669; /* emerald-600 */
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin: 0 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn-amber {
            background: #f59e0b; /* amber-500 */
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
        }

        @media print {
            body { background: none; }
            .page { box-shadow: none; margin: 0; border: none; }
            .toolbar { display: none; }
            .label { border: none; }
            .sticker-sheet { border: none; }
        }
    </style>
</head>
<body onload="if(window.location.search.includes('print=true')) window.print()">
    <div class="toolbar">
        <div style="margin-bottom: 12px; font-weight: 800; letter-spacing: -0.025em; font-size: 20px;">
            Label<span style="color: #10b981;">Pro</span> <span style="font-weight: 400; opacity: 0.6; font-size: 14px; margin-left: 8px;">| Pratinjau <?= $type ?></span>
        </div>
        <button onclick="window.print()" class="btn btn-amber">
            <i class="fa-solid fa-print" style="margin-right: 8px;"></i> Cetak Sekarang
        </button>
        <a href="/recipients/export-pdf?type=<?= $type ?>" class="btn">
            <i class="fa-solid fa-file-pdf" style="margin-right: 8px;"></i> Unduh PDF
        </a>
        <div style="font-size: 11px; margin-top: 12px; opacity: 0.7; font-style: italic;">
            * Penting: Atur "Margin" ke "None" dan "Scale" ke "100%" pada pengaturan browser Anda.
        </div>
    </div>

    <div class="page">
        <div class="sticker-sheet sheet-<?= $type ?>">
            <?php foreach ($recipients as $recipient): ?>
            <div class="label">
                <div class="name"><?= esc($recipient['name']) ?></div>
                <div class="prefix">di-</div>
                <div class="address"><?= esc($recipient['address']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
