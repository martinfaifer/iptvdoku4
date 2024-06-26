<?php

namespace Database\Seeders;

use App\Models\CssColor;
use Illuminate\Database\Seeder;

// cs- is custom color
class CssColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! CssColor::first()) {

            CssColor::create([
                'color' => 'bg-slate-50',
                'hex' => '#f8fafc',
            ]);

            CssColor::create([
                'color' => 'bg-slate-100',
                'hex' => '#f1f5f9',
            ]);

            CssColor::create([
                'color' => 'bg-slate-300',
                'hex' => '#cbd5e1',
            ]);

            CssColor::create([
                'color' => 'bg-slate-600',
                'hex' => '#475569',
            ]);

            CssColor::create([
                'color' => 'bg-slate-700',
                'hex' => '#334155',
            ]);

            CssColor::create([
                'color' => 'bg-slate-800',
                'hex' => '#1e293b',
            ]);

            CssColor::create([
                'color' => 'bg-slate-900',
                'hex' => '#0f172a',
            ]);

            CssColor::create([
                'color' => 'bg-slate-950',
                'hex' => '#020617',
            ]);

            CssColor::create([
                'color' => 'bg-gray-500',
                'hex' => '#6b7280',
            ]);

            CssColor::create([
                'color' => 'bg-gray-700',
                'hex' => '#374151',
            ]);

            CssColor::create([
                'color' => 'bg-gray-900',
                'hex' => '#111827',
            ]);

            CssColor::create([
                'color' => 'bg-gray-950',
                'hex' => '#030712',
            ]);

            CssColor::create([
                'color' => 'bg-zinc-500',
                'hex' => '#71717a',
            ]);

            CssColor::create([
                'color' => 'bg-zinc-800',
                'hex' => '#27272a',
            ]);

            CssColor::create([
                'color' => 'bg-zinc-900',
                'hex' => '#18181b',
            ]);

            CssColor::create([
                'color' => 'bg-zinc-950',
                'hex' => '#09090b',
            ]);

            CssColor::create([
                'color' => 'bg-red-200',
                'hex' => '#fecaca',
            ]);

            CssColor::create([
                'color' => 'bg-red-300',
                'hex' => '#fca5a5',
            ]);

            CssColor::create([
                'color' => 'bg-red-400',
                'hex' => '#f87171',
            ]);

            CssColor::create([
                'color' => 'bg-red-500',
                'hex' => '#ef4444',
            ]);

            CssColor::create([
                'color' => 'bg-red-600',
                'hex' => '#dc2626',
            ]);

            CssColor::create([
                'color' => 'bg-red-700',
                'hex' => '#b91c1c',
            ]);

            CssColor::create([
                'color' => 'bg-red-800',
                'hex' => '#991b1b',
            ]);

            CssColor::create([
                'color' => 'bg-red-900',
                'hex' => '#7f1d1d',
            ]);

            CssColor::create([
                'color' => 'bg-red-950',
                'hex' => '#450a0a',
            ]);

            CssColor::create([
                'color' => 'bg-orange-200',
                'hex' => '#fed7aa',
            ]);

            CssColor::create([
                'color' => 'bg-orange-300',
                'hex' => '#fdba74',
            ]);

            CssColor::create([
                'color' => 'bg-orange-400',
                'hex' => '#fb923c',
            ]);

            CssColor::create([
                'color' => 'bg-orange-500',
                'hex' => '#f97316',
            ]);

            CssColor::create([
                'color' => 'bg-orange-600',
                'hex' => '#ea580c',
            ]);

            CssColor::create([
                'color' => 'bg-orange-700',
                'hex' => '#c2410c',
            ]);

            CssColor::create([
                'color' => 'bg-orange-800',
                'hex' => '#9a3412',
            ]);

            CssColor::create([
                'color' => 'bg-orange-900',
                'hex' => '#7c2d12',
            ]);

            CssColor::create([
                'color' => 'bg-orange-950',
                'hex' => '#431407',
            ]);

            CssColor::create([
                'color' => 'bg-amber-200',
                'hex' => '#fde68a',
            ]);

            CssColor::create([
                'color' => 'bg-amber-300',
                'hex' => '#fcd34d',
            ]);

            CssColor::create([
                'color' => 'bg-amber-400',
                'hex' => '#fbbf24',
            ]);

            CssColor::create([
                'color' => 'bg-amber-500',
                'hex' => '#f59e0b',
            ]);

            CssColor::create([
                'color' => 'bg-amber-600',
                'hex' => '#d97706',
            ]);

            CssColor::create([
                'color' => 'bg-amber-700',
                'hex' => '#b45309',
            ]);

            CssColor::create([
                'color' => 'bg-amber-800',
                'hex' => '#92400e',
            ]);

            CssColor::create([
                'color' => 'bg-amber-900',
                'hex' => '#78350f',
            ]);

            CssColor::create([
                'color' => 'bg-amber-950',
                'hex' => '#451a03',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-200',
                'hex' => '#fef08a',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-300',
                'hex' => '#fde047',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-400',
                'hex' => '#facc15',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-500',
                'hex' => '#eab308',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-600',
                'hex' => '#ca8a04',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-700',
                'hex' => '#a16207',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-800',
                'hex' => '#854d0e',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-900',
                'hex' => '#713f12',
            ]);

            CssColor::create([
                'color' => 'bg-yellow-950',
                'hex' => '#422006',
            ]);

            CssColor::create([
                'color' => 'bg-lime-200',
                'hex' => '#d9f99d',
            ]);

            CssColor::create([
                'color' => 'bg-lime-300',
                'hex' => '#bef264',
            ]);

            CssColor::create([
                'color' => 'bg-lime-400',
                'hex' => '#a3e635',
            ]);

            CssColor::create([
                'color' => 'bg-lime-500',
                'hex' => '#84cc16',
            ]);

            CssColor::create([
                'color' => 'bg-lime-600',
                'hex' => '#65a30d',
            ]);

            CssColor::create([
                'color' => 'bg-lime-700',
                'hex' => '#4d7c0f',
            ]);

            CssColor::create([
                'color' => 'bg-lime-800',
                'hex' => '#3f6212',
            ]);

            CssColor::create([
                'color' => 'bg-lime-900',
                'hex' => '#365314',
            ]);

            CssColor::create([
                'color' => 'bg-lime-950',
                'hex' => '#1a2e05',
            ]);

            CssColor::create([
                'color' => 'bg-green-200',
                'hex' => '#bbf7d0',
            ]);

            CssColor::create([
                'color' => 'bg-green-300',
                'hex' => '#86efac',
            ]);

            CssColor::create([
                'color' => 'bg-green-400',
                'hex' => '#4ade80',
            ]);

            CssColor::create([
                'color' => 'bg-green-500',
                'hex' => '#22c55e',
            ]);

            CssColor::create([
                'color' => 'bg-green-600',
                'hex' => '#16a34a',
            ]);

            CssColor::create([
                'color' => 'bg-green-700',
                'hex' => '#15803d',
            ]);

            CssColor::create([
                'color' => 'bg-green-800',
                'hex' => '#166534',
            ]);

            CssColor::create([
                'color' => 'bg-green-900',
                'hex' => '#14532d',
            ]);

            CssColor::create([
                'color' => 'bg-green-950',
                'hex' => '#052e16',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-200',
                'hex' => '#a7f3d0',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-300',
                'hex' => '#6ee7b7',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-400',
                'hex' => '#34d399',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-500',
                'hex' => '#10b981',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-600',
                'hex' => '#059669',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-700',
                'hex' => '#047857',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-800',
                'hex' => '#065f46',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-900',
                'hex' => '#064e3b',
            ]);

            CssColor::create([
                'color' => 'bg-emerald-950',
                'hex' => '#022c22',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-200',
                'hex' => '#a5f3fc',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-300',
                'hex' => '#67e8f9',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-400',
                'hex' => '#22d3ee',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-500',
                'hex' => '#06b6d4',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-600',
                'hex' => '#0891b2',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-700',
                'hex' => '#0e7490',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-800',
                'hex' => '#155e75',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-900',
                'hex' => '#164e63',
            ]);

            CssColor::create([
                'color' => 'bg-cyan-950',
                'hex' => '#083344',
            ]);

            CssColor::create([
                'color' => 'bg-sky-200',
                'hex' => '#bae6fd',
            ]);

            CssColor::create([
                'color' => 'bg-sky-300',
                'hex' => '#7dd3fc',
            ]);

            CssColor::create([
                'color' => 'bg-sky-400',
                'hex' => '#38bdf8',
            ]);

            CssColor::create([
                'color' => 'bg-sky-500',
                'hex' => '#0ea5e9',
            ]);

            CssColor::create([
                'color' => 'bg-sky-600',
                'hex' => '#0284c7',
            ]);

            CssColor::create([
                'color' => 'bg-sky-700',
                'hex' => '#0369a1',
            ]);

            CssColor::create([
                'color' => 'bg-sky-800',
                'hex' => '#075985',
            ]);

            CssColor::create([
                'color' => 'bg-sky-900',
                'hex' => '#0c4a6e',
            ]);

            CssColor::create([
                'color' => 'bg-sky-950',
                'hex' => '#082f49',
            ]);

            CssColor::create([
                'color' => 'bg-blue-200',
                'hex' => '#bfdbfe',
            ]);

            CssColor::create([
                'color' => 'bg-blue-300',
                'hex' => '#93c5fd',
            ]);

            CssColor::create([
                'color' => 'bg-blue-400',
                'hex' => '#60a5fa',
            ]);

            CssColor::create([
                'color' => 'bg-blue-500',
                'hex' => '#3b82f6',
            ]);

            CssColor::create([
                'color' => 'bg-blue-600',
                'hex' => '#2563eb',
            ]);

            CssColor::create([
                'color' => 'bg-blue-700',
                'hex' => '#1d4ed8',
            ]);

            CssColor::create([
                'color' => 'bg-blue-800',
                'hex' => '#1e40af',
            ]);

            CssColor::create([
                'color' => 'bg-blue-900',
                'hex' => '#1e3a8a',
            ]);

            CssColor::create([
                'color' => 'bg-blue-950',
                'hex' => '#172554',
            ]);

            CssColor::create([
                'color' => 'bg-indigo-400',
                'hex' => '#818cf8',
            ]);

            CssColor::create([
                'color' => 'bg-indigo-500',
                'hex' => '#6366f1',
            ]);

            CssColor::create([
                'color' => 'bg-indigo-600',
                'hex' => '#4f46e5',
            ]);

            CssColor::create([
                'color' => 'bg-indigo-700',
                'hex' => '#4338ca',
            ]);

            CssColor::create([
                'color' => 'bg-indigo-800',
                'hex' => '#3730a3',
            ]);

            CssColor::create([
                'color' => 'bg-indigo-900',
                'hex' => '#312e81',
            ]);

            CssColor::create([
                'color' => 'bg-rose-200',
                'hex' => '#fecdd3',
            ]);

            CssColor::create([
                'color' => 'bg-rose-300',
                'hex' => '#fda4af',
            ]);

            CssColor::create([
                'color' => 'bg-rose-400',
                'hex' => '#fb7185',
            ]);

            CssColor::create([
                'color' => 'bg-rose-500',
                'hex' => '#f43f5e',
            ]);

            CssColor::create([
                'color' => 'bg-rose-600',
                'hex' => '#e11d48',
            ]);

            CssColor::create([
                'color' => 'bg-rose-700',
                'hex' => '#be123c',
            ]);

            CssColor::create([
                'color' => 'bg-rose-800',
                'hex' => '#9f1239',
            ]);

            CssColor::create([
                'color' => 'bg-rose-900',
                'hex' => '#881337',
            ]);

            CssColor::create([
                'color' => 'bg-rose-950',
                'hex' => '#4c0519',
            ]);

        }
    }
}
