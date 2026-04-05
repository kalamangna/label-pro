<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Label <?= $type ?></title>
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
            text-align: left;
            width: 100%;
        }
        .address {
            font-size: 9pt;
            line-height: 1.1;
        }

        /* Toolbar for preview */
        .toolbar {
            background: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .btn {
            background: #4F46E5;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
            text-decoration: none;
            display: inline-block;
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
        <span>Pratinjau: Label <?= $type ?></span>
        <button onclick="window.print()" class="btn">Cetak Sekarang</button>
        <a href="/recipients/export-pdf?type=<?= $type ?>" class="btn" style="background:#10B981;">Unduh PDF</a>
        <button onclick="window.history.back()" class="btn" style="background:#666">Kembali</button>
        <div style="font-size: 11px; margin-top: 5px; opacity: 0.8;">
            * Penting: Atur "Margin" ke "None" dan "Scale" ke "100%" pada pengaturan cetak browser Anda.
        </div>
    </div>

    <div class="page">
        <div class="sticker-sheet sheet-<?= $type ?>">
            <?php foreach ($recipients as $recipient): ?>
            <div class="label">
                <div class="name"><?= esc($recipient['name']) ?></div>
                <div class="prefix">&nbsp;</div>
                <div class="address"><?= esc($recipient['address']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
