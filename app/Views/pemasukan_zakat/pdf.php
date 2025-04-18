// app/Views/zakat_pdf.php
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

    .content {
        margin-top: 20px;
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
    <?php foreach ($pemasukan_zakat as $p): ?>
    <div class="container">
        <div class="header">
            <?php
                $path = FCPATH . 'logo.jpg';
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>
            <img src="<?= $base64; ?>" width="50" style="float:left;">

            <h2>PANITIA ZAKAT/INFAQ/SHADAQOH TAHUN <?= date('Y'); ?></h2>
            <h3>Masjid</h3>
        </div>
        <div class="line"></div>
        <table class="table">
            <?php
                $id = $p['id'];
                $id_formatted = str_pad($id, 2, '0', STR_PAD_LEFT);
                // $tanggal = date('d/m/Y');
                $tanggal = $p['tanggal_masuk'];
                $tanggal_parts = explode('-', $tanggal);
                $nomor = "{$id_formatted}/{$tanggal_parts[2]}/{$tanggal_parts[1]}/{$tanggal_parts[0]}";

                $namaList = explode(',', $p['nama']);
                $kepalaKeluarga = trim($namaList[0]);
                ?>
            <tr>
                <td></td>
                <td>Nomor: <?= $nomor; ?></td>
            </tr>
            <tr>
                <td>Kepala keluarga : <?= $kepalaKeluarga; ?></td>
                <td></td>
            </tr>
        </table>
        <h4><strong>Untuk Pembayaran</strong></h4>
        <table class="table">
            <tr>
                <td>Zakat Fitrah</td>
                <td>: Rp
                    <?= $p['jenis_zakat'] == 'Zakat Fitrah' && $p['jenis'] == 'uang' ? number_format($p['jumlah'], 0, ',', '.') : '-'; ?>
                </td>
                <td>Zakat Beras</td>
                <td>: <?= $p['jenis_zakat'] == 'Zakat Fitrah' && $p['jenis'] == 'beras' ? $p['jumlah'] : '-'; ?> Ltr
                </td>
            </tr>
            <tr>
                <td>Zakat Maal</td>
                <td>: Rp
                    <?= $p['jenis_zakat'] == 'Zakat Maal' && $p['jenis'] == 'uang' ? number_format($p['jumlah'], 0, ',', '.') : '-'; ?>
                </td>
                <td>Sadaqoh/Infaq</td>
                <td>: Rp <?= $p['infaq'] ? number_format($p['infaq'], 0, ',', '.') : '-'; ?></td>
            </tr>
            <!-- <tr>
                <td>Fidyah</td>
                <td>: Rp 3</td>
            </tr> -->
        </table>
        <p>Dari sejumlah <?= $p['jumlah_keluarga']; ?> jiwa, yaitu : </p>
        <ul style="list-style-type: none; padding-left: 10px;">
            <?php
                foreach ($namaList as $nama) {
                    echo '<li>- ' . $nama . '</li>';
                }
                ?>
        </ul>
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