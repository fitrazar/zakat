<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran Zakat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
        }

        .header h2,
        .header h3 {
            margin: 0;
        }

        .line {
            border-bottom: 1px solid black;
            margin: 10px 0;
        }

        .table {
            width: 100%;
        }

        .table td {
            padding: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
        }

        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <?php
    // Gabungkan data berdasarkan nama dan tanggal terima
    $mergedData = [];
    foreach ($penerima_zakat as $p) {
        $key = $p['nama'] . '-' . $p['tanggal_terima'];

        if (!isset($mergedData[$key])) {
            $mergedData[$key] = [
                'nama' => $p['nama'],
                'rt' => $p['rt'],
                'rw' => $p['rw'],
                'alamat' => $p['alamat'],
                'status' => $p['status'],
                'tanggal_terima' => $p['tanggal_terima'],
                'jumlah_uang' => ($p['jenis'] == 'uang') ? $p['jumlah'] : 0,
                'jumlah_beras' => ($p['jenis'] == 'beras') ? $p['jumlah'] : 0
            ];
        } else {
            // Jika nama dan tanggal sudah ada, update jumlah uang atau jumlah beras
            if ($p['jenis'] == 'uang') {
                $mergedData[$key]['jumlah_uang'] = $p['jumlah'];
            } elseif ($p['jenis'] == 'beras') {
                $mergedData[$key]['jumlah_beras'] = $p['jumlah'];
            }
        }
    }
    ?>

    <?php foreach ($mergedData as $p): ?>
        <div class="container">
            <div class="header">
                <?php
                $path = FCPATH . 'logo.jpg';
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>
                <img src="<?= $base64; ?>" width="50" style="float:left;">
                <h2>NOTA PENERIMAAN ZAKAT <?= date('Y'); ?></h2>
                <h3>Masjid</h3>
            </div>
            <div class="line"></div>

            <table class="table">
                <?php
                $tanggal = $p['tanggal_terima'];
                $tanggal_parts = explode('-', $tanggal);
                $nomor = "{$tanggal_parts[2]}/{$tanggal_parts[1]}/{$tanggal_parts[0]}";
                ?>
                <tr>
                    <td></td>
                    <td>Nomor: <?= $nomor; ?></td>
                </tr>
                <tr>
                    <td>Nama Keluarga : <?= $p['nama']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Alamat : <?= $p['rt']; ?>/<?= $p['rw']; ?> - <?= $p['alamat']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Status : <?= $p['status']; ?></td>
                    <td></td>
                </tr>
            </table>

            <h4><strong>Detail Penerimaan</strong></h4>
            <table class="table">
                <tr>
                    <td>Jumlah Uang : Rp <?= $p['jumlah_uang'] > 0 ? number_format($p['jumlah_uang'], 0, ',', '.') : '-'; ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jumlah Beras : <?= $p['jumlah_beras'] > 0 ? $p['jumlah_beras'] : '-'; ?> Ltr</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tanggal Diterima : <?= $p['tanggal_terima']; ?></td>
                    <td></td>
                </tr>
            </table>

            <div class="footer">
                <table width="100%">
                    <tr>
                        <?php
                        setlocale(LC_TIME, 'id_ID.utf8');
                        $date = date('d');
                        $bulan = [
                            'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        ];
                        $bulan_sekarang = $bulan[date('n') - 1];
                        $tahun = date('Y');
                        $tanggal_indonesia = "$date $bulan_sekarang $tahun";
                        ?>

                    <tr>
                        <td align="left" colspan="2" style="margin-bottom: 20px;">Purwakarta, <?= $tanggal_indonesia ?></td>
                        <td></td>
                    </tr>

                    </tr>
                    <tr>
                        <td align="center">Yang Menerima,</td>
                        <td></td>
                        <td align="center">Yang Menyerahkan,</td>
                    </tr>
                    <tr>
                        <td height="50"></td>
                        <td></td>
                        <td height="50"></td>
                    </tr>
                    <tr>
                        <td align="center">(_________________)</td>
                        <td></td>
                        <td align="center">(_________________)</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="page-break"></div>
    <?php endforeach; ?>
</body>

</html>