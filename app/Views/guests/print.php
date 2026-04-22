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
            size: A4 portrait;
            margin: 2mm;
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
            background-color: #fef08a;
            /* Light yellow background for sticker backing */
            margin: 0 auto;
            display: flex;
            align-items: flex-start;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 5mm;
            break-after: page;
        }

        /* The actual sticker sheet area */
        .sticker-sheet {
            position: relative;
            display: grid;
            box-sizing: border-box;
        }

        /* Label 121 (38x75mm, 2 cols x 5 rows) */
        .sheet-121 {
            width: 152mm;
            height: 198mm;
            grid-template-columns: repeat(2, 75mm);
            grid-template-rows: repeat(5, 38mm);
            column-gap: 2mm;
            row-gap: 2mm;
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
            background-color: white;
            /* White sticker */
            border-radius: 2mm;
            /* Rounded corners typical for stickers */
        }

        .name {
            font-size: 10pt;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 0.5mm;
        }

        .position {
            font-size: 8pt;
            line-height: 1.1;
            margin-bottom: 0.5mm;
        }

        .details {
            display: block;
            text-align: center;
        }

        .prefix {
            font-size: 9pt;
            margin-bottom: 0.5mm;
            width: 100%;
        }

        .address {
            font-size: 9pt;
            line-height: 1.1;
        }

        /* Toolbar for preview */
        .toolbar {
            background: #064e3b;
            /* emerald-950 */
            color: white;
            padding: 15px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .btn {
            background: #059669;
            /* emerald-600 */
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-amber {
            background: #f59e0b;
            /* amber-500 */
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 16pt;
            font-weight: 900;
            color: rgba(239, 68, 68, 0.15);
            /* red-500 with low opacity */
            white-space: nowrap;
            pointer-events: none;
            z-index: 10;
            letter-spacing: 2px;
        }

        @media print {

            body,
            .page {
                background: none !important;
                background-color: white !important;
            }

            .page {
                box-shadow: none;
                margin: 0;
                border: none;
                padding-top: 0;
            }

            .toolbar {
                display: none;
            }

            .label {
                border: none;
                background-color: transparent !important;
            }

            .sticker-sheet {
                border: none;
            }
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
        <div style="font-size: 11px; margin-top: 12px; opacity: 0.7; font-style: italic;">
            * Penting: Atur "Margin" ke "None" dan "Scale" ke "100%" pada pengaturan browser Anda.
        </div>
    </div>

    <?php foreach ($pages as $guests): ?>
        <div class="page" style="justify-content: <?= esc($align ?? 'center') ?>;">
            <div class="sticker-sheet sheet-<?= $type ?>">
                <?php foreach ($guests as $guest): ?>
                    <div class="label" style="position: relative;">
                        <?php if (!empty($guest)): ?>
                            <?php if (session()->get('role') === 'demo'): ?>
                                <div class="watermark">DEMO VERSION</div>
                            <?php endif; ?>
                            <div class="name"><?= esc($guest['name'] ?? '') ?></div>
                            <?php if (!empty(trim((string)($guest['position'] ?? '')))): ?>
                                <div class="position"><?= esc($guest['position']) ?></div>
                            <?php endif; ?>
                            <div style="height: 2mm;">&nbsp;</div>
                            <div class="details">
                                <div class="prefix">di-</div>
                                <div class="address"><?= empty(trim((string)($guest['address'] ?? ''))) ? 'Tempat' : esc($guest['address']) ?></div>
                            </div>
                        <?php else: ?>
                            <div class="name">&nbsp;</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>

</html>