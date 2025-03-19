<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penerima Zakat</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .title {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>

    <div class="title">Laporan Penerima Zakat</div>

    <table>
        <thead>
            <tr>
                <th>Nama Warga</th>
                <th>Jenis Zakat</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Tanggal Terima</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($penerima_zakat as $p): ?>
            <tr>
                <td><?= $p['nama']; ?></td>
                <td><?= ucfirst($p['jenis_zakat']); ?></td>
                <td><?= $p['jumlah']; ?></td>
                <td><?= $p['satuan']; ?></td>
                <td><?= date('d-m-Y', strtotime($p['tanggal_terima'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>