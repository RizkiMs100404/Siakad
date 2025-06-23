<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\JadwalModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use Mpdf\Mpdf;

class LaporanRekapController extends BaseController
{
    public function index()
    {
        $tab = $this->request->getGet('tab') ?? 'guru';
        $search = $this->request->getGet('search');

        // DATA LIST
        switch ($tab) {
           case 'guru':
    $model = new GuruModel();
    if ($search) $model->like('nama_lengkap', $search)->orLike('nip', $search);
    $dataList = $model->orderBy('nama_lengkap')->findAll();
    break;

            case 'siswa':
                $model = new SiswaModel();
                if ($search) $model->like('siswa.nama_lengkap', $search)->orLike('nis', $search)->orLike('nisn', $search);
                $dataList = $model
                    ->select('siswa.*, kelas.nama_kelas')
                    ->join('kelas', 'siswa.kelas_id=kelas.id', 'left')
                    ->orderBy('siswa.nama_lengkap')->findAll();
                break;
            case 'kelas':
                $model = new KelasModel();
                if ($search) $model->like('kelas.nama_kelas', $search);
                $dataList = $model
                    ->select('kelas.*, guru.nama_lengkap as wali_nama')
                    ->join('guru', 'kelas.guru_id=guru.id', 'left')
                    ->orderBy('kelas.nama_kelas')->findAll();
                break;
            case 'mapel':
                $model = new MapelModel();
                if ($search) $model->like('mapel.nama_mapel', $search);
                $dataList = $model
                    ->select('mapel.*, guru.nama_lengkap as nama_guru')
                    ->join('guru', 'mapel.guru_id=guru.id', 'left')
                    ->orderBy('mapel.nama_mapel')->findAll();
                break;
            case 'jadwal':
                $model = new JadwalModel();
                if ($search) $model->like('jadwal.hari', $search);
                $dataList = $model
                    ->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel, guru.nama_lengkap as nama_guru')
                    ->join('kelas', 'jadwal.kelas_id=kelas.id', 'left')
                    ->join('mapel', 'jadwal.mapel_id=mapel.id', 'left')
                    ->join('guru', 'jadwal.guru_id=guru.id', 'left')
                    ->orderBy('jadwal.hari')->findAll();
                break;
            case 'nilai':
                $model = new NilaiModel();
                if ($search) $model->like('nilai_angka', $search)->orLike('nilai_huruf', $search);
                $dataList = $model
                    ->select('nilai.*, siswa.nama_lengkap as nama_siswa, kelas.nama_kelas, mapel.nama_mapel, guru.nama_lengkap as nama_guru')
                    ->join('siswa', 'nilai.siswa_id=siswa.id', 'left')
                    ->join('kelas', 'siswa.kelas_id=kelas.id', 'left')
                    ->join('mapel', 'nilai.mapel_id=mapel.id', 'left')
                    ->join('guru', 'nilai.guru_id=guru.id', 'left')
                    ->orderBy('nilai.semester')->findAll();
                break;
            default:
                $tab = 'guru';
                $model = new GuruModel();
                $guruList = $model->orderBy('nama_lengkap')->findAll();
                foreach ($guruList as &$g) { $g['mapel'] = '-'; }
                $dataList = $guruList;
                break;
        }

        $pageTitle = 'Rekap ' . ucfirst($tab);
        $breadcrumb = ['Laporan', ucfirst($tab)];

        return view('admin/laporan/rekap', [
            'tab'      => $tab,
            'dataList' => $dataList,
            'search'   => $search,
            'pageTitle' => $pageTitle,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function print($tab)
    {
        $dataList = $this->_getData($tab);
        return view('admin/laporan/print', [
            'tab'      => $tab,
            'dataList' => $dataList
        ]);
    }

    public function pdf($tab)
    {
        $dataList = $this->_getData($tab);
        $title = 'Rekap Data ' . ucfirst($tab);

        $html = view('admin/laporan/print', [
            'tab'      => $tab,
            'dataList' => $dataList,
            'pdfMode'  => true
        ]);

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $mpdf->SetTitle($title);
        $mpdf->WriteHTML($html);
        return $this->response->setHeader('Content-Type', 'application/pdf')
            ->setBody($mpdf->Output($title.'.pdf', 'S'));
    }

    public function excel($tab)
    {
        $dataList = $this->_getData($tab);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Header
        switch ($tab) {
            case 'guru':
                $sheet->fromArray(['No', 'Nama Lengkap', 'NIP', 'Mapel', 'No. HP', 'Alamat'], NULL, 'A1');
                $row = 2;
                foreach ($dataList as $i => $d) {
                    $sheet->fromArray([
                        $i + 1,
                        $d['nama_lengkap'],
                        $d['nip'],
                        $d['mapel'],
                        $d['no_hp'],
                        $d['alamat'],
                    ], NULL, 'A'.$row++);
                }
                break;
            case 'siswa':
                $sheet->fromArray(['No', 'Nama Lengkap', 'NIS', 'NISN', 'Kelas', 'Jurusan', 'No. HP', 'Alamat'], NULL, 'A1');
                $row = 2;
                foreach ($dataList as $i => $d) {
                    $sheet->fromArray([
                        $i + 1,
                        $d['nama_lengkap'],
                        $d['nis'],
                        $d['nisn'],
                        $d['nama_kelas'],
                        $d['jurusan'],
                        $d['no_hp'],
                        $d['alamat'],
                    ], NULL, 'A'.$row++);
                }
                break;
            case 'kelas':
                $sheet->fromArray(['No', 'Nama Kelas', 'Wali Kelas'], NULL, 'A1');
                $row = 2;
                foreach ($dataList as $i => $d) {
                    $sheet->fromArray([
                        $i + 1,
                        $d['nama_kelas'],
                        $d['wali_nama'],
                    ], NULL, 'A'.$row++);
                }
                break;
            case 'mapel':
                $sheet->fromArray(['No', 'Nama Mapel', 'Guru Pengampu'], NULL, 'A1');
                $row = 2;
                foreach ($dataList as $i => $d) {
                    $sheet->fromArray([
                        $i + 1,
                        $d['nama_mapel'],
                        $d['nama_guru'],
                    ], NULL, 'A'.$row++);
                }
                break;
            case 'jadwal':
                $sheet->fromArray(['No', 'Kelas', 'Mapel', 'Guru', 'Hari', 'Jam Mulai', 'Jam Selesai'], NULL, 'A1');
                $row = 2;
                foreach ($dataList as $i => $d) {
                    $sheet->fromArray([
                        $i + 1,
                        $d['nama_kelas'],
                        $d['nama_mapel'],
                        $d['nama_guru'],
                        $d['hari'],
                        $d['jam_mulai'],
                        $d['jam_selesai'],
                    ], NULL, 'A'.$row++);
                }
                break;
            case 'nilai':
                $sheet->fromArray(['No', 'Siswa', 'Mapel', 'Guru', 'Kelas', 'Nilai Angka', 'Nilai Huruf', 'Semester', 'Tahun Ajaran'], NULL, 'A1');
                $row = 2;
                foreach ($dataList as $i => $d) {
                    $sheet->fromArray([
                        $i + 1,
                        $d['nama_siswa'],
                        $d['nama_mapel'],
                        $d['nama_guru'],
                        $d['nama_kelas'],
                        $d['nilai_angka'],
                        $d['nilai_huruf'],
                        $d['semester'],
                        $d['tahun_ajaran'],
                    ], NULL, 'A'.$row++);
                }
                break;
            default:
                $sheet->fromArray(['Data Tidak Ada'], NULL, 'A1');
        }

        $fileName = 'Rekap_'.$tab.'_'.date('Ymd_His').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function _getData($tab)
    {
        switch ($tab) {
            case 'guru':
                $model = new GuruModel();
                return $model->orderBy('nama_lengkap')->findAll();
            case 'siswa':
                $model = new SiswaModel();
                return $model
                    ->select('siswa.*, kelas.nama_kelas')
                    ->join('kelas', 'siswa.kelas_id=kelas.id', 'left')
                    ->orderBy('siswa.nama_lengkap')->findAll();
            case 'kelas':
                $model = new KelasModel();
                return $model
                    ->select('kelas.*, guru.nama_lengkap as wali_nama')
                    ->join('guru', 'kelas.guru_id=guru.id', 'left')
                    ->orderBy('kelas.nama_kelas')->findAll();
            case 'mapel':
                $model = new MapelModel();
                return $model
                    ->select('mapel.*, guru.nama_lengkap as nama_guru')
                    ->join('guru', 'mapel.guru_id=guru.id', 'left')
                    ->orderBy('mapel.nama_mapel')->findAll();
            case 'jadwal':
                $model = new JadwalModel();
                return $model
                    ->select('jadwal.*, kelas.nama_kelas, mapel.nama_mapel, guru.nama_lengkap as nama_guru')
                    ->join('kelas', 'jadwal.kelas_id=kelas.id', 'left')
                    ->join('mapel', 'jadwal.mapel_id=mapel.id', 'left')
                    ->join('guru', 'jadwal.guru_id=guru.id', 'left')
                    ->orderBy('jadwal.hari')->findAll();
            case 'nilai':
                $model = new NilaiModel();
                return $model
                    ->select('nilai.*, siswa.nama_lengkap as nama_siswa, kelas.nama_kelas, mapel.nama_mapel, guru.nama_lengkap as nama_guru')
                    ->join('siswa', 'nilai.siswa_id=siswa.id', 'left')
                    ->join('kelas', 'siswa.kelas_id=kelas.id', 'left')
                    ->join('mapel', 'nilai.mapel_id=mapel.id', 'left')
                    ->join('guru', 'nilai.guru_id=guru.id', 'left')
                    ->orderBy('nilai.semester')->findAll();
            default:
                return [];
        }
    }
}
