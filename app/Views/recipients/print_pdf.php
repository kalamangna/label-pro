<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .page {
            width: 210mm;
            height: 297mm;
            position: relative;
        }
        
        table {
            border-collapse: collapse;
            table-layout: fixed;
            position: absolute;
        }
        
        .sheet-121 {
            left: 29mm;
            top: 49.5mm;
            width: 152mm;
        }

        td {
            padding: 0;
            margin: 0;
            vertical-align: middle;
            text-align: center;
            overflow: hidden;
        }

        .name {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 0.5mm;
        }

        .details {
            display: block;
            text-align: center;
        }

        .prefix {
            font-size: 10pt;
            margin-bottom: 0.5mm;
            width: 100%;
        }

        .address {
            font-size: 10pt;
            line-height: 1.1;
        }
        
        .spacer-col { width: 2mm; }
        .spacer-row { height: 2mm; }
    </style>
</head>
<body>
    <div class="page">
        <table class="sheet-121">
            <?php 
            $chunks = array_chunk($recipients, 2);
            foreach (array_slice($chunks, 0, 5) as $rowIndex => $row): 
            ?>
                <tr>
                    <td style="width: 75mm; height: 38mm;">
                        <?php if (isset($row[0])): ?>
                            <div class="name"><?= esc($row[0]['name']) ?></div>
                            <div style="height: 3mm;">&nbsp;</div>
                            <div class="details">
                                <div class="prefix">di-</div>
                                <div class="address"><?= empty(trim((string)($row[0]['address'] ?? ''))) ? 'Tempat' : esc($row[0]['address']) ?></div>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="spacer-col"></td>
                    <td style="width: 75mm; height: 38mm;">
                        <?php if (isset($row[1])): ?>
                            <div class="name"><?= esc($row[1]['name']) ?></div>
                            <div style="height: 3mm;">&nbsp;</div>
                            <div class="details">
                                <div class="prefix">di-</div>
                                <div class="address"><?= empty(trim((string)$row[1]['address'])) ? 'Tempat' : esc($row[1]['address']) ?></div>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php if ($rowIndex < 4): ?>
                    <tr class="spacer-row"><td colspan="3"></td></tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
