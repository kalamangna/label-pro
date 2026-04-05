<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4;
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
        
        .sheet-103 {
            left: 23mm;
            top: 50mm;
            width: 130mm;
        }
        .sheet-121 {
            left: 28mm;
            top: 50mm;
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
        
        .spacer-col { width: 2mm; }
        .spacer-row { height: 2mm; }
    </style>
</head>
<body>
    <div class="page">
        <?php if ($type === '103'): ?>
            <table class="sheet-103">
                <?php 
                $chunks = array_chunk($recipients, 2);
                foreach ($chunks as $rowIndex => $row): 
                ?>
                    <tr>
                        <td style="width: 64mm; height: 32mm;">
                            <div class="name"><?= esc($row[0]['name'] ?? '') ?></div>
                            <div class="prefix">&nbsp;</div>
                            <div class="address"><?= esc($row[0]['address'] ?? '') ?></div>
                        </td>
                        <td class="spacer-col"></td>
                        <td style="width: 64mm; height: 32mm;">
                            <?php if (isset($row[1])): ?>
                                <div class="name"><?= esc($row[1]['name']) ?></div>
                                <div class="prefix">di-</div>
                                <div class="address"><?= esc($row[1]['address']) ?></div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ($rowIndex < 5): ?>
                        <tr class="spacer-row"><td colspan="3"></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        <?php else: // 121 ?>
            <table class="sheet-121">
                <?php 
                $chunks = array_chunk($recipients, 2);
                foreach ($chunks as $rowIndex => $row): 
                ?>
                    <tr>
                        <td style="width: 75mm; height: 38mm;">
                            <div class="name"><?= esc($row[0]['name'] ?? '') ?></div>
                            <div class="prefix">&nbsp;</div>
                            <div class="address"><?= esc($row[0]['address'] ?? '') ?></div>
                        </td>
                        <td class="spacer-col"></td>
                        <td style="width: 75mm; height: 38mm;">
                            <?php if (isset($row[1])): ?>
                                <div class="name"><?= esc($row[1]['name']) ?></div>
                                <div class="prefix">di-</div>
                                <div class="address"><?= esc($row[1]['address']) ?></div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ($rowIndex < 4): ?>
                        <tr class="spacer-row"><td colspan="3"></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
