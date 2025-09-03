@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Mes commandes</h1>

<div class="bg-white border rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $order->number ?? $order->id }}</td>
                    <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">{{ number_format($order->total, 2, ',', ' ') }} €</td>
                    <td class="px-4 py-2">{{ __($order->status) }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('orders.show', $order) }}" class="text-sm hover:underline">Détails</a>
                    </td>
                </tr>
            @empty
                <tr><td class="px-4 py-3" colspan="5">Aucune commande.</td></tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($orders, 'links'))
        <div class="p-4">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
