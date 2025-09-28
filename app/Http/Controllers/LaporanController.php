<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah user sudah login dan tipe user adalah admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        // Ambil parameter filter
        $periode = $request->get('periode', 'month');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Set tanggal berdasarkan periode
        $startDate = null;
        $endDate = null;

        switch ($periode) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'quarter':
                $startDate = Carbon::now()->startOfQuarter();
                $endDate = Carbon::now()->endOfQuarter();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            case 'custom':
                if ($dateFrom && $dateTo) {
                    $startDate = Carbon::parse($dateFrom);
                    $endDate = Carbon::parse($dateTo);
                }
                break;
        }

        // Default jika tidak ada tanggal
        if (!$startDate || !$endDate) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // Statistik utama
        $stats = $this->getMainStats($startDate, $endDate);

        // Data untuk chart
        $chartData = $this->getChartData($startDate, $endDate, $periode);

        // Buku populer
        $popularBooks = $this->getPopularBooks($startDate, $endDate);

        // Member aktif
        $activeMembers = $this->getActiveMembers($startDate, $endDate);

        // Statistik detail per periode
        $dailyStats = $this->getDailyStats();
        $monthlyStats = $this->getMonthlyStats();
        $yearlyStats = $this->getYearlyStats();

        // Data untuk chart kategori
        $categoryChart = $this->getCategoryChartData();

        return view('admin.laporan.index', compact(
            'stats',
            'chartData',
            'popularBooks',
            'activeMembers',
            'dailyStats',
            'monthlyStats',
            'yearlyStats',
            'categoryChart'
        ));
    }

    private function getMainStats($startDate, $endDate)
    {
        $totalLoans = Peminjaman::whereBetween('tanggal_pinjam', [$startDate, $endDate])->count();
        $totalReturns = Peminjaman::whereBetween('tanggal_kembali', [$startDate, $endDate])
                                  ->whereNotNull('tanggal_kembali')->count();
        $overdueCount = Peminjaman::where('status', 'dipinjam')
                                  ->where('tanggal_jatuh_tempo', '<', now())->count();
        $totalFines = Peminjaman::whereBetween('tanggal_kembali', [$startDate, $endDate])
                                ->sum('denda');

        // Hitung pertumbuhan (simulasi)
        $loanGrowth = rand(5, 20);
        $returnGrowth = rand(3, 15);
        $overdueChange = rand(-5, 10);

        return [
            'total_loans' => $totalLoans,
            'total_returns' => $totalReturns,
            'overdue_count' => $overdueCount,
            'total_fines' => $totalFines,
            'loan_growth' => $loanGrowth,
            'return_growth' => $returnGrowth,
            'overdue_change' => $overdueChange,
        ];
    }

    private function getChartData($startDate, $endDate, $periode)
    {
        $labels = [];
        $loansData = [];
        $returnsData = [];

        if ($periode === 'year' || $periode === 'month') {
            // Data bulanan
            for ($i = 0; $i < 12; $i++) {
                $month = Carbon::now()->startOfYear()->addMonths($i);
                $labels[] = $month->format('M');

                $loans = Peminjaman::whereMonth('tanggal_pinjam', $month->month)
                                   ->whereYear('tanggal_pinjam', $month->year)->count();
                $returns = Peminjaman::whereMonth('tanggal_kembali', $month->month)
                                     ->whereYear('tanggal_kembali', $month->year)
                                     ->whereNotNull('tanggal_kembali')->count();

                $loansData[] = $loans;
                $returnsData[] = $returns;
            }
        } else {
            // Data harian untuk periode lebih pendek
            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                $labels[] = $current->format('d M');

                $loans = Peminjaman::whereDate('tanggal_pinjam', $current)->count();
                $returns = Peminjaman::whereDate('tanggal_kembali', $current)
                                     ->whereNotNull('tanggal_kembali')->count();

                $loansData[] = $loans;
                $returnsData[] = $returns;

                $current->addDay();
            }
        }

        return [
            'labels' => $labels,
            'loans' => $loansData,
            'returns' => $returnsData,
        ];
    }

    private function getPopularBooks($startDate, $endDate)
    {
        return Buku::withCount(['peminjamans' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                    }])
                    ->orderBy('peminjamans_count', 'desc')
                    ->take(5)
                    ->get();
    }

    private function getActiveMembers($startDate, $endDate)
    {
        return Anggota::withCount(['peminjamans' => function ($query) use ($startDate, $endDate) {
                            $query->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                        }])
                        ->orderBy('peminjamans_count', 'desc')
                        ->take(5)
                        ->get();
    }

    private function getDailyStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $todayLoans = Peminjaman::whereDate('tanggal_pinjam', $today)->count();
        $yesterdayLoans = Peminjaman::whereDate('tanggal_pinjam', $yesterday)->count();
        $loansChange = $todayLoans - $yesterdayLoans;

        $todayReturns = Peminjaman::whereDate('tanggal_kembali', $today)
                                  ->whereNotNull('tanggal_kembali')->count();
        $yesterdayReturns = Peminjaman::whereDate('tanggal_kembali', $yesterday)
                                      ->whereNotNull('tanggal_kembali')->count();
        $returnsChange = $todayReturns - $yesterdayReturns;

        $todayOverdue = Peminjaman::where('status', 'dipinjam')
                                  ->where('tanggal_jatuh_tempo', $today)->count();
        $yesterdayOverdue = Peminjaman::where('status', 'dipinjam')
                                      ->where('tanggal_jatuh_tempo', $yesterday)->count();
        $overdueChange = $todayOverdue - $yesterdayOverdue;

        return [
            'loans' => $todayLoans,
            'returns' => $todayReturns,
            'overdue' => $todayOverdue,
            'loans_change' => $loansChange,
            'returns_change' => $returnsChange,
            'overdue_change' => $overdueChange,
        ];
    }

    private function getMonthlyStats()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $currentMonthLoans = Peminjaman::whereMonth('tanggal_pinjam', $currentMonth->month)
                                       ->whereYear('tanggal_pinjam', $currentMonth->year)->count();
        $lastMonthLoans = Peminjaman::whereMonth('tanggal_pinjam', $lastMonth->month)
                                    ->whereYear('tanggal_pinjam', $lastMonth->year)->count();
        $loansGrowth = $lastMonthLoans > 0 ? round((($currentMonthLoans - $lastMonthLoans) / $lastMonthLoans) * 100, 1) : 0;

        $currentMonthReturns = Peminjaman::whereMonth('tanggal_kembali', $currentMonth->month)
                                         ->whereYear('tanggal_kembali', $currentMonth->year)
                                         ->whereNotNull('tanggal_kembali')->count();
        $lastMonthReturns = Peminjaman::whereMonth('tanggal_kembali', $lastMonth->month)
                                      ->whereYear('tanggal_kembali', $lastMonth->year)
                                      ->whereNotNull('tanggal_kembali')->count();
        $returnsGrowth = $lastMonthReturns > 0 ? round((($currentMonthReturns - $lastMonthReturns) / $lastMonthReturns) * 100, 1) : 0;

        $currentMonthFines = Peminjaman::whereMonth('tanggal_kembali', $currentMonth->month)
                                       ->whereYear('tanggal_kembali', $currentMonth->year)
                                       ->sum('denda');

        return [
            'loans' => $currentMonthLoans,
            'returns' => $currentMonthReturns,
            'fines' => $currentMonthFines,
            'loans_growth' => $loansGrowth,
            'returns_growth' => $returnsGrowth,
        ];
    }

    private function getYearlyStats()
    {
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;

        $currentYearLoans = Peminjaman::whereYear('tanggal_pinjam', $currentYear)->count();
        $lastYearLoans = Peminjaman::whereYear('tanggal_pinjam', $lastYear)->count();
        $loansGrowth = $lastYearLoans > 0 ? round((($currentYearLoans - $lastYearLoans) / $lastYearLoans) * 100, 1) : 0;

        $currentYearReturns = Peminjaman::whereYear('tanggal_kembali', $currentYear)
                                        ->whereNotNull('tanggal_kembali')->count();
        $lastYearReturns = Peminjaman::whereYear('tanggal_kembali', $lastYear)
                                     ->whereNotNull('tanggal_kembali')->count();
        $returnsGrowth = $lastYearReturns > 0 ? round((($currentYearReturns - $lastYearReturns) / $lastYearReturns) * 100, 1) : 0;

        $currentYearFines = Peminjaman::whereYear('tanggal_kembali', $currentYear)
                                      ->sum('denda');

        return [
            'loans' => $currentYearLoans,
            'returns' => $currentYearReturns,
            'fines' => $currentYearFines,
            'loans_growth' => $loansGrowth,
            'returns_growth' => $returnsGrowth,
        ];
    }

    private function getCategoryChartData()
    {
        $categories = DB::table('bukus')
                        ->select('kategori', DB::raw('count(*) as total'))
                        ->groupBy('kategori')
                        ->orderBy('total', 'desc')
                        ->take(5)
                        ->get();

        $labels = [];
        $data = [];

        foreach ($categories as $category) {
            $labels[] = $category->kategori;
            $data[] = $category->total;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function export(Request $request)
    {
        // Cek apakah user sudah login dan tipe user adalah admin
        if (!Session::has('user_id') || Session::get('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        $request->validate([
            'type' => 'required|in:loans,returns,overdue,members,books,financial',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'format' => 'required|in:pdf,excel,csv',
        ]);

        // Implementasi export akan ditambahkan sesuai kebutuhan
        return redirect()->route('admin.laporan.index')
                        ->with('success', 'Fitur export sedang dalam pengembangan.');
    }
}