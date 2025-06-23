<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rekap Data <?= esc(ucfirst($tab)) ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', 'Open Sans', Arial, sans-serif;
            background: #f5f6fa;
            color: #22223b;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-top: 36px;
            margin-bottom: 10px;
        }
        .logo {
            height: 60px;
            border-radius: 10px;
            box-shadow: 0 2px 14px #6c7cf644;
        }
        .header-text {
            font-weight: 700;
            font-size: 2rem;
            color: #6C7CF6;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        h2 {
            color: #4f46e5;
            letter-spacing: 1px;
            margin-bottom: 24px;
            margin-top: 4px;
            text-shadow: 1px 2px 10px #c7d2fe22;
            font-size: 1.45rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .print-container {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px 0 #6c7cf611;
            padding: 28px 36px;
            max-width: 1100px;
            margin: 32px auto;
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin: 1.5rem 0;
            background: #fafbff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px #6c7cf611;
        }
        th, td {
            padding: 12px 18px;
            font-size: 15px;
        }
        th {
            background: linear-gradient(90deg, #6C7CF6 80%, #b4b7fa 100%);
            color: #fff;
            font-weight: bold;
            text-align: left;
            border-bottom: 2px solid #d6e0fc;
            text-shadow: 0 1px 3px #23255a26;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) td {
            background: #f1f5fd;
        }
        tr:nth-child(odd) td {
            background: #f9fafc;
        }
        tr:hover td {
            background: #e0e7ff !important;
        }
        td {
            border-bottom: 1px solid #e2e8f0;
            color: #23255a;
        }
        @media print {
            body { background: #fff; }
            .print-container { box-shadow:none; border-radius:0; padding:0;}
            .no-print { display:none !important; }
            .header { margin-top: 8px; margin-bottom: 0;}
            table { box-shadow: none; }
            tr:hover td { background: #f1f5fd !important;}
        }
        .btn-print {
            padding: 10px 28px;
            background: linear-gradient(90deg, #6C7CF6 60%, #7367f0 100%);
            color: #fff;
            font-size: 15px;
            border-radius: 12px;
            border: none;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 24px;
            cursor: pointer;
            box-shadow: 0 2px 6px #b4b7fa55;
            transition: background .18s, transform .15s;
        }
        .btn-print:hover {
            background: linear-gradient(90deg, #7367f0 40%, #6C7CF6 100%);
            transform: scale(1.035);
        }
        .icon-col {
            text-align: center;
            color: #6C7CF6;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
<div class="print-container">
    <div class="header">
        <img src="<?= base_url('assets/images/logo.png') ?>" class="logo" alt="Logo">
        <span class="header-text">
            <i class="fa-solid fa-school-flag"></i>
            SIAKAD SMK KOREA
        </span>
    </div>
    <div class="no-print" style="margin-bottom:16px; text-align:right">
        <button class="btn-print" onclick="window.print()">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
    <h2>
        <i class="fa-solid fa-file-lines"></i> Rekap Data <?= ucfirst($tab) ?>
    </h2>
    <?php if ($tab == 'guru'): ?>
        <table>
            <thead>
                <tr>
                    <th class="icon-col"><i class="fa fa-hashtag"></i></th>
                    <th><i class="fa fa-user-tie"></i> Nama Lengkap</th>
                    <th><i class="fa fa-id-card"></i> NIP</th>
                    <th><i class="fa fa-book"></i> Mapel</th>
                    <th><i class="fa fa-phone"></i> No. HP</th>
                    <th><i class="fa fa-location-dot"></i> Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                <tr>
                    <td class="icon-col"><?= $i+1 ?></td>
                    <td><?= esc($d['nama_lengkap']) ?></td>
                    <td><?= esc($d['nip']) ?></td>
                    <td><?= esc($d['mapel'] ?? '-') ?></td>
                    <td><?= esc($d['no_hp']) ?></td>
                    <td><?= esc($d['alamat']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'siswa'): ?>
        <table>
            <thead>
                <tr>
                    <th class="icon-col"><i class="fa fa-hashtag"></i></th>
                    <th><i class="fa fa-user"></i> Nama Lengkap</th>
                    <th><i class="fa fa-id-card"></i> NIS</th>
                    <th><i class="fa fa-barcode"></i> NISN</th>
                    <th><i class="fa fa-school"></i> Kelas</th>
                    <th><i class="fa fa-shapes"></i> Jurusan</th>
                    <th><i class="fa fa-phone"></i> No. HP</th>
                    <th><i class="fa fa-location-dot"></i> Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                <tr>
                    <td class="icon-col"><?= $i+1 ?></td>
                    <td><?= esc($d['nama_lengkap']) ?></td>
                    <td><?= esc($d['nis']) ?></td>
                    <td><?= esc($d['nisn']) ?></td>
                    <td><?= esc($d['nama_kelas'] ?? '-') ?></td>
                    <td><?= esc($d['jurusan']) ?></td>
                    <td><?= esc($d['no_hp']) ?></td>
                    <td><?= esc($d['alamat']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'kelas'): ?>
        <table>
            <thead>
                <tr>
                    <th class="icon-col"><i class="fa fa-hashtag"></i></th>
                    <th><i class="fa fa-school"></i> Nama Kelas</th>
                    <th><i class="fa fa-user-tie"></i> Wali Kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                <tr>
                    <td class="icon-col"><?= $i+1 ?></td>
                    <td><?= esc($d['nama_kelas']) ?></td>
                    <td><?= esc($d['wali_nama'] ?? '-') ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'mapel'): ?>
        <table>
            <thead>
                <tr>
                    <th class="icon-col"><i class="fa fa-hashtag"></i></th>
                    <th><i class="fa fa-book"></i> Nama Mapel</th>
                    <th><i class="fa fa-user-tie"></i> Guru Pengampu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                <tr>
                    <td class="icon-col"><?= $i+1 ?></td>
                    <td><?= esc($d['nama_mapel']) ?></td>
                    <td><?= esc($d['nama_guru'] ?? '-') ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'jadwal'): ?>
        <table>
            <thead>
                <tr>
                    <th class="icon-col"><i class="fa fa-hashtag"></i></th>
                    <th><i class="fa fa-school"></i> Kelas</th>
                    <th><i class="fa fa-book"></i> Mapel</th>
                    <th><i class="fa fa-user-tie"></i> Guru</th>
                    <th><i class="fa fa-calendar-alt"></i> Hari</th>
                    <th><i class="fa fa-clock"></i> Jam Mulai</th>
                    <th><i class="fa fa-clock"></i> Jam Selesai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                <tr>
                    <td class="icon-col"><?= $i+1 ?></td>
                    <td><?= esc($d['nama_kelas'] ?? '-') ?></td>
                    <td><?= esc($d['nama_mapel'] ?? '-') ?></td>
                    <td><?= esc($d['nama_guru'] ?? '-') ?></td>
                    <td><?= esc($d['hari']) ?></td>
                    <td><?= esc($d['jam_mulai']) ?></td>
                    <td><?= esc($d['jam_selesai']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php elseif ($tab == 'nilai'): ?>
        <table>
            <thead>
                <tr>
                    <th class="icon-col"><i class="fa fa-hashtag"></i></th>
                    <th><i class="fa fa-user"></i> Siswa</th>
                    <th><i class="fa fa-school"></i> Kelas</th>
                    <th><i class="fa fa-book"></i> Mapel</th>
                    <th><i class="fa fa-user-tie"></i> Guru</th>
                    <th><i class="fa fa-star"></i> Nilai Angka</th>
                    <th><i class="fa fa-star-half-stroke"></i> Nilai Huruf</th>
                    <th><i class="fa fa-calendar-alt"></i> Semester</th>
                    <th><i class="fa fa-calendar"></i> Tahun Ajaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dataList as $i => $d): ?>
                <tr>
                    <td class="icon-col"><?= $i+1 ?></td>
                    <td><?= esc($d['nama_siswa'] ?? '-') ?></td>
                    <td><?= esc($d['nama_kelas'] ?? '-') ?></td>
                    <td><?= esc($d['nama_mapel'] ?? '-') ?></td>
                    <td><?= esc($d['nama_guru'] ?? '-') ?></td>
                    <td><?= esc($d['nilai_angka']) ?></td>
                    <td><?= esc($d['nilai_huruf']) ?></td>
                    <td><?= esc($d['semester']) ?></td>
                    <td><?= esc($d['tahun_ajaran']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
</body>
</html>
